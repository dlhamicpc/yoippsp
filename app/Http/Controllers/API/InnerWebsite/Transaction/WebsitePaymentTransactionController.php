<?php

namespace App\Http\Controllers\API\InnerWebsite\Transaction;

use App\Models\InnerWebsite\WebsitePaymentTransactionTemporary;
use App\Models\InnerWebsite\WebsitePaymentTransaction;
use App\Models\InnerWebsite\Transaction;
use App\Models\InnerWebsite\WebsiteUser;
use App\Events\InnerWebsite\NotificationMessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebsitePaymentTransactionController extends Controller
{
    private $websiteUser;
    private $wptt;
    private $sender;
    private $transactionSuccess = false;

   /**
     * Display the payment form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $id )
    {
        $data = $this->check_if_the_data_belong_to_the_payer( $id );
        
        if( $data['operation'] == 'redirect' ) {
            return redirect($data['url']);
        }

        return view('innerWebsite.gateway.pay.index', $data);
    }

    private function check_if_the_data_belong_to_the_payer( $id )
    {
        $wptt = WebsitePaymentTransactionTemporary::find($id);
        if($wptt == null) {
            abort(404);
        }
        else {
            //$websiteUser = WebsiteUser::where('webhook_url', request()->server('HTTP_REFERER'))->get()->first();

            $websiteUser = WebsiteUser::find($wptt->website_user_id);

            if( $websiteUser == null ) {
                abort(404);
            }
            else{
                if( $wptt->status == 'Paid' ) {
                    return [
                        'operation' => 'redirect',
                        'url' => $websiteUser->callback_url
                    ];
                }
                else {
                    $this->set_session( $wptt, $websiteUser );
                    return [
                        'operation' => 'view',
                        'website_name' => $websiteUser->website_name,
                        'website_url' => $websiteUser->website_url,
                        'amount' => $wptt->amount
                    ];
                }
                
            }
            
        }
    }

    private function set_session( $wptt, $websiteUser )
    {
        session()->put('wptt', $wptt );
        session()->put('websiteUser', $websiteUser );
    }
    

    public function check_balance()
    {
        $userBalance = $this->sender->balance;
        
        if( $userBalance < $this->wptt->amount ){

            $this->wptt->update([
                'user_id' => $this->sender->user_id
            ]);

            $this->wptt->update([
                'status' => 'failed'
            ]);

            return false;
        }
        return true;
    }


    
    public function set_data()
    {
        $this->websiteUser = session()->get('websiteUser');
        $this->wptt = session()->get('wptt');
        $this->sender = auth()->user()->personal_user;

        return $this->websiteUser->callback_url;
    }


    public function perform_transaction()
    {

        $transaction_data = $this->get_transaction_data();

        DB::transaction(function() use ( $transaction_data )
        {
            $this->sender->update([
                'balance' => (double)$this->sender->balance - (double)$this->wptt->amount
            ]);

            $this->websiteUser->update([
                'balance' => (double)$this->websiteUser->balance + (double)$this->wptt->amount
            ]);

            $this->wptt->update([
                'user_id' => $this->sender->user_id
            ]);

            $this->wptt->update([
                'status' => 'Paid'
            ]);


            $transaction = Transaction::create($transaction_data);
            
            $websitePaymentTransactionData = $this->get_website_payment_transaction_data( $transaction->id );
            $websitePaymentTransaction = WebsitePaymentTransaction::create($websitePaymentTransactionData);

            $this->transactionSuccess = true;

        });

        if ( $this->transactionSuccess ) {
            $this->event_notification_message(
                $this->sender->user_id,
                $this->sender->full_name, 
                auth()->user()->avatar, 
                $this->websiteUser->user_id, 
                0, 
                $this->compose_message()
            );
            return true;
        }
        else{
            return false;
        }
    }

    protected function event_notification_message($senderUserID, $senderName, $senderImage, $receiverUserID, $notificationType, $message )
    {
         event( new NotificationMessageEvent(
            $senderUserID, $senderName, $senderImage, $receiverUserID, $notificationType, $message
          ));
    }

    private function get_transaction_data()
    {
        return [
            'sender_id'                             =>      $this->sender->user_id,
            'receiver_id'                           =>      $this->websiteUser->user_id,
            'sender_name'                           =>      $this->sender->full_name,
            'receiver_name'                         =>      $this->websiteUser->full_name,
            'amount'                                =>      $this->wptt->amount,
            'fee'                                   =>      0,
            'description'                           =>      'Online Payment',
            'transaction_type'                      =>      4,
            'status'                                =>      2,
            'sender_ip'                             =>      request()->ip(),
            'sender_address_from_google_map'        =>      null,
            'sender_coordinates_from_google_map'    =>      null,
        ];
    }

    private function get_website_payment_transaction_data( $transactionID )
    {
        return [
            'user_id' => $this->sender->user_id,
            'website_user_id' => $this->websiteUser->id,
            'wptt_id' => $this->wptt->id,
            'transaction_id' => $transactionID,
            'website_type_id' => $this->websiteUser->type,
            'metadata' => $this->wptt->metadata
        ];
    }

    private function compose_message()
    {
        $message = "You have received a ".$this->wptt->amount." Birr payment from ".ucwords($this->sender->full_name).".";
        return $message; 
    }
    
    
    public function get_payment_data( $payer_identitifcation )
    {
        $errors = array();
        $response = array('status' => 'failed');

        $wptt = WebsitePaymentTransactionTemporary::where('payer_identification', $payer_identitifcation)->latest()->get()->first();

        if( $wptt == null ) {
            return [
                'status' => 'failed',
                'errors' => [
                    'message' => '0 record found'
                ]
            ];
        }
        else {
            return [
                'status' => 'success',
                'data' => [
                    'payer_ip' => $wptt->payer_ip,
                    'payer_identification' => $wptt->payer_identification,
                    'metadata' => $wptt->metadata,
                    'amount' => $wptt->amount,
                    'payment_status' => $wptt->status,
                    'created_at' => $wptt->created_at,
                    'paid_at' => $wptt->updated_at
                ]
            ];
        }
    }








}

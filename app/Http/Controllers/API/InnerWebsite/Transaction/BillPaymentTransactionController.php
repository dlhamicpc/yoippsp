<?php
namespace App\Http\Controllers\API\InnerWebsite\Transaction;

use App\User;
use App\Models\InnerWebsite\PersonalUser;
use App\Models\InnerWebsite\BillPaymentUser;
use App\Models\InnerWebsite\UserBillPaymentInformation;
use App\Models\InnerWebsite\BillPaymentPost;
use App\Models\InnerWebsite\Transaction;
use App\Models\InnerWebsite\BillPaymentTransaction;
use App\Models\InnerWebsite\UserBillPaymentLink;
use App\Http\Controllers\NotificationMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillPaymentTransactionController extends TransactionController
{

    /******************************************************************/
    /************************   BillPayment  TRANSACTION  *************/
    /******************************************************************/
    /******************************************************************/
    /******************************************************************/
    /******************************************************************/

    protected $receiverUser;
    protected $receiverRoleID;
    protected $receiverUserID;
    protected $amount;
    public $receiverModel;
    protected $description;
    public $senderModel;
    protected $sender;
    protected $userBillPaymentInformation;



    
    public function bill_payment_transaction(Request $request)
    {
        $this->fill_data( $request );

        $this->validate_balance();
        

        //IF DATA IS VALID
        if( $this->perform_transaction($request) ){

           $n = new NotificationMessageController();
           return $n->fetch_notification_and_notify_online();

        }
        else{
            return 'failed';
        }

    }




    ////////////////  HELPER FUNCTIONS //////////////////////////

    private function get_bill_information( $id )
    {
        $userBillPaymentInformation = UserBillPaymentInformation::where(['id' => $id, 'payment_status' => 'Pending'] )
                                        ->orWhere(['id' => $id, 'payment_status' => 'Failed'] )
                                        ->get()->first();
        if( $userBillPaymentInformation == null ) {
            abort(423, 'Already Paid');
        }

        return $userBillPaymentInformation;
    }

    private function find_receiver_model( $billPaymentReceiverID )
    {
        $this->receiverModel = BillPaymentUser::find( $billPaymentReceiverID );
    }
    

    private function find_receiver_role_id()
    {
        $this->receiverRoleID = $this->receiverUser->role_id;
    }


    private function find_receiver_user_id()
    {
        $this->receiverUserID = $this->receiverModel->user_id;
    }


    private function find_receiver_user_model()
    {
        $this->receiverUser = User::find( $this->receiverModel->user_id );
    }

    private function find_paying_amount()
    {
        $this->amount = $this->userBillPaymentInformation->amount;
    }


    private function fill_data(Request $request)
    {
        $data = $this->validate_data($request);

        $this->userBillPaymentInformation = $this->get_bill_information( $data['id'] );
        $this->find_paying_amount();

        $this->sender = auth()->user();
        $this->senderModel = $this->sender->personal_user;

        $this->find_receiver_model( $this->userBillPaymentInformation->bill_payment_user_id );
        $this->find_receiver_user_model();
        $this->find_receiver_user_id();
        $this->find_receiver_role_id();

        $this->description = 'Bill Payment made to '.$this->receiverModel->bill_payment_name;
    }

    private function validate_data( $request )
    {
        return $request->validate([
            'id'      => ['bail', 'required', 'integer', 'exists:user_bill_payment_information,id'],
            'user_id' => ['bail', 'required', 'integer', 'exists:user_bill_payment_information,user_id'],
        ]);
    }



    private function validate_balance()
    {
        $userBalance = $this->senderModel->balance;
        if( $userBalance < $this->amount ){
            abort(422, 'Insuffiecient Balance');
        }
    }

    private function validate_date_passed( $payment_end_on )
    {
        if( $payment_end_on < date('Y-m-d') ){
            abort(424, 'Bill PAYMENT DATE PASSED');
        }
    }

    private function find_latest_bill_payment_post()
    {
        return BillPaymentPost::where('bill_payment_user_id', $this->receiverModel->id)->latest()->get()->first();
    }


    private function perform_transaction($request)
    {

        
        $transaction_data = $this->get_transaction_data();

        $billPaymentPost = $this->find_latest_bill_payment_post();

        $this->validate_date_passed( $billPaymentPost->payment_end_on );

        DB::transaction(function() use ( $transaction_data, $billPaymentPost )
        {
            $this->senderModel->update([
                'balance' => (double)$this->senderModel->balance - (double)$this->amount
            ]);

            $this->receiverModel->update([
                'balance' => (double)$this->receiverModel->balance + (double)$this->amount
            ]);

            $this->userBillPaymentInformation->update([
                'payment_status' => 'Paid' 
            ]);

            $billPaymentPost->update([
                'total_collected_amount' => (double)$billPaymentPost->total_collected_amount + (double)$this->amount
            ]);

            $transaction = Transaction::create($transaction_data);

            $billPaymentTransactionData = $this->get_bill_payment_transaction_data( $transaction->id );
            $billPaymentTransaction = BillPaymentTransaction::create($billPaymentTransactionData);

            $this->transactionSuccess = true;

        });

        if ( $this->transactionSuccess ) {
            $this->event_notification_message(
                $this->sender->id,
                $this->senderModel->full_name, 
                $this->sender->avatar, 
                $this->receiverUserID, 
                0, 
                $this->compose_message()
            );

            return true;
        }
        else{
            return false;
        }
    }

    private function compose_message()
    {
        $message = "You have received ".$this->amount." Birr from ".ucwords($this->senderModel->full_name).".";
        return $message; 
    } 

   

 

    private function get_transaction_data( )
    {
        return [
            'sender_id'                                     =>      $this->sender->id,
            'receiver_id'                                   =>      $this->receiverUserID,
            'sender_name'                                   =>      $this->senderModel->full_name,
            'receiver_name'                                 =>      $this->receiverModel->bill_payment_name,
            'amount'                                        =>      $this->amount,
            'fee'                                           =>      0,
            'description'                                   =>      $this->description,
            'transaction_type'                              =>      5,
            'status'                                        =>      2,
            'sender_ip'                              =>      request()->ip(),
            'sender_address_from_google_map'         =>      null,
            'sender_coordinates_from_google_map'     =>      null,
        ];
    }


    private function get_bill_payment_transaction_data( $transactionID )
    {
        return [
            'user_id' => $this->sender->id,
            'link_id' => $this->get_user_payment_identification_id(),
            'bill_payment_user_id' => $this->receiverModel->id,
            'payment_info_id' => $this->userBillPaymentInformation->id,
            'transaction_id' => $transactionID,
            'bill_payment_type' => $this->receiverModel->type,
            'description' => $this->description,
            'content' => 'Bill Payment'
        ];
    }

    private function get_user_payment_identification_id()
    {
        return UserBillPaymentLink::where([
            'user_id' => $this->sender->id,
            'bill_payment_id' => $this->receiverModel->id
        ])->get()->first()->id;
    }



}

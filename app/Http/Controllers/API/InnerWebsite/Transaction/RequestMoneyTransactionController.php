<?php
namespace App\Http\Controllers\API\InnerWebsite\Transaction;

use App\User;
use App\Models\InnerWebsite\PersonalUser;
use App\Models\InnerWebsite\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestMoneyTransactionController extends TransactionController
{

    /******************************************************************/
    /*********************  Request Money TRANSACTION   ***************/
    /******************************************************************/
    /******************************************************************/
    /******************************************************************/
    /******************************************************************/

    protected $receiverAddress;
    protected $receiverAddressType; // EMAIL or MOBILE NUMBER
    protected $receiverUser;
    protected $receiverRoleID;
    protected $receiverUserID;
    protected $requesterRoleID;
    protected $requestingAmount;
    protected $receiverModel;
    protected $requesterBalance;
    protected $description;



    
    public function request_money_transaction(Request $request)
    {
        $data = $this->validate_data($request);

        //IF DATA IS VALID
        if( $this->perform_transaction($request) ){

            //Upon Successful transaction
            return $this->update_front_end_data();

        }
        else{
            return 'failed';
        }

    }




    private function validate_data(Request $request)
    {
        $receiver_address_type = filter_var($request->receiver_address_request, FILTER_VALIDATE_EMAIL )
        ? 'email' : 'mobile_number';

        $this->receiverAddressType = $receiver_address_type;

        $data =  $request->validate([
            'requesting_amount' => ['bail', 'required', 'numeric'],
            'receiver_address_request' => ['bail', 'required', "$receiver_address_type", "exists:users,$receiver_address_type"],
            'description' => ['bail', 'sometimes'],
        ]);

        $this->receiverAddress = $request->receiver_address_request;
        $this->receiverUser = $this->find_receiver( );
        $this->receiverUserID = $this->receiverUser->id;
        $this->receiverRoleID = $this->receiverUser->role_id;
        $this->requestingAmount = $request->requesting_amount;
        $this->description = $request->description;

        return $data;
    }


    private function find_receiver( )
    {
        return User::where( $this->receiverAddressType, $this->receiverAddress )->get()->first();
    }

    private function perform_transaction($request)
    {
        $this->receiverModel = $this->find_model( $this->receiverRoleID );

        $receiver = $this->find_receiver_from_its_model( $this->receiverModel , 'user_id', $this->receiverUserID );

        $requsterBalance = $this->find_user_balance();
        $this->requesterModel = $this->senderModel;
        $requester = $this->requesterModel;

        $transaction_data = $this->get_transaction_data( $request, $requester, $receiver );

        
        DB::transaction(function() use ($requester, $receiver, $transaction_data)
        {
            $transaction = Transaction::create($transaction_data);

            $this->transactionSuccess = true;
        });

        if ( $this->transactionSuccess ) {
            $this->event_notification_message(
                auth()->user()->id,
                $this->senderModel->full_name, 
                auth()->user()->avatar, 
                $this->receiverUserID, 
                1, 
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
        $message = "You have received a ".$this->requestingAmount." Birr request from ".ucwords($this->senderModel->full_name).".";
        return $message; 
    } 

    private function find_model( $role_id )
    {

        switch ($role_id) {

            case 5:{
                return new PersonalUser();
            };

            default:
                # code...
                break;
        }

    }

    private function find_receiver_from_its_model( $model , $searchBy, $key )
    {
        return $model::where( $searchBy, $key )->get()->first();
    }

    private function get_transaction_data(Request $request, $requester, $receiver )
    {
        return [
            'sender_id'                             =>      $requester->user_id,
            'receiver_id'                              =>      $receiver->user_id,
            'sender_name'                           =>      $requester->full_name,
            'receiver_name'                            =>      $receiver->full_name,
            'amount'                                   =>      $this->requestingAmount,
            'fee'                                      =>      0,
            'description'                              =>      $this->description,
            'transaction_type'                         =>      3,
            'status'                                   =>      2,
            'sender_ip'                             =>      $request->ip(),
            'requester_address_from_google_map'        =>      null,
            'requester_coordinates_from_google_map'    =>      null,
        ];
    }

    public function update_front_end_data()
    {
        $user_id = auth()->user()->id;
        $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->latest()
                                    ->paginate(10);

        $updated_data = [
            'balance' => (double)$this->senderModel->balance ,
            'transactions' => $transactions
        ];

        return $updated_data;
    }

}

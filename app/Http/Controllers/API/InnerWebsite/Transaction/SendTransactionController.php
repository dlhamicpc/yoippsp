<?php
namespace App\Http\Controllers\API\InnerWebsite\Transaction;

use App\User;
use App\Models\InnerWebsite\PersonalUser;
use App\Models\InnerWebsite\BillPaymentUser;
use App\Models\InnerWebsite\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SendTransactionController extends TransactionController
{

    /******************************************************************/
    /************************   Send  TRANSACTION   *******************/
    /******************************************************************/
    /******************************************************************/
    /******************************************************************/
    /******************************************************************/

    protected $receiverAddress;
    protected $receiverAddressType; // EMAIL or MOBILE NUMBER
    protected $receiverUser;
    protected $receiverRoleID;
    protected $receiverUserID;
    protected $senderRoleID;
    protected $sendingAmount;
    protected $receiverModel;
    protected $senderBalance;
    protected $description;



    
    public function send_transaction(Request $request)
    {
        $validation_status = $this->return_if_invalid($request);
        if( is_array( $validation_status ) ){
            return $validation_status;
        }

        //IF DATA IS VALID
        if( $this->perform_transaction($request) ){

            //Upon Successful transaction
            return $this->update_front_end_data();

        }
        else{
            return 'failed';
        }

    }




    ////////////////  HELPER FUNCTIONS //////////////////////////

    private function return_if_invalid(Request $request)
    {
        $validation_status = $this->validate_data($request);
        $validation_message = ['INVALID RECEIVER ADDRESS', 'INVALID AMOUNT', 'INSUFICEINT BALANCE'];

        foreach ($validation_status as $key => $value) {
            if( in_array( $value, $validation_message ) ){
                return $validation_status;
            }
        }

        $this->receiverAddress = $request->receiver_address;
        $this->receiverUser = $this->find_receiver( );
        $this->receiverUserID = $this->receiverUser->id;
        $this->receiverRoleID = $this->receiverUser->role_id;
        $this->sendingAmount = $request->sending_amount;
        $this->description = $request->description;

        return 'VALID';
    }

    private function validate_data(Request $request)
    {
        $validation_status = [
            'receiver_address' => 'VALID',
            'sending_amount' => 'VALID',
            'description' => 'VALID'
        ];

        if( $this->validate_receiver_address($request) == false ){
            $validation_status['receiver_address'] = 'INVALID RECEIVER ADDRESS';
        }

        if( $this->validate_sending_amount($request) == false ){
            $validation_status['sending_amount'] = 'INVALID AMOUNT';
        }

        if( $this->validate_balance( $request->sending_amount ) == false && $validation_status['sending_amount'] == true ){
            $validation_status['sending_amount'] = 'INSUFICEINT BALANCE';
        }


        return $validation_status;
    }

    private function validate_receiver_address(Request $request)
    {
        $receiver_address_type = filter_var($request->input('receiver_address'), FILTER_VALIDATE_EMAIL )
        ? 'email' : 'mobile_number';

        $this->receiverAddressType = $receiver_address_type;

        try {
            $request->validate([
                'receiver_address' => "required|$receiver_address_type|exists:users,$receiver_address_type"
            ]);
            //No Error
            return true;
        } catch (\Throwable $th) {
            //Invalid receiver address
            return false;
        }
    }

    private function validate_sending_amount(Request $request)
    {
        try {
            $request->validate([
                'sending_amount' => "required|numeric"
            ]);
            //No Error
            return true;
        } catch (\Throwable $th) {
            //Invalid receiver address
            return false;
        }
    }

    private function validate_balance( $sending_amount )
    {
        $userBalance = $this->find_user_balance();
        $this->senderBalance = $userBalance;
        if( $userBalance < $sending_amount ){
            return false;
        }
        return true;
    }

    private function validate_description(Request $request)
    {
        try {
            $request->validate([
                'description' => "required|string"
            ]);
            //No Error
            return true;
        } catch (\Throwable $th) {
            //Invalid receiver address
            return false;
        }
    }

    private function find_receiver( )
    {
        return User::where( $this->receiverAddressType, $this->receiverAddress )->get()->first();
    }

    private function perform_transaction($request)
    {
        $this->receiverModel = $this->find_model( $this->receiverRoleID );

        $receiver = $this->find_receiver_from_its_model( $this->receiverModel , 'user_id', $this->receiverUserID );

        $sender = $this->senderModel;

        $transaction_data = $this->get_transaction_data( $request, $sender, $receiver );

        DB::transaction(function() use ($sender, $receiver, $transaction_data)
        {
            $sender->update([
                'balance' => (double)$this->senderBalance- (double)$this->sendingAmount
            ]);

            $receiver->update([
                'balance' => (double)$receiver->balance + (double)$this->sendingAmount
            ]);

            $transaction = Transaction::create($transaction_data);

            $this->transactionSuccess = true;

        });

        if ( $this->transactionSuccess ) {
            $this->event_notification_message(
                auth()->user()->id,
                $this->senderModel->full_name, 
                auth()->user()->avatar, 
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
        $message = "You have received ".$this->sendingAmount." Birr from ".ucwords($this->senderModel->full_name).".";
        return $message; 
    } 



    private function find_receiver_from_its_model( $model , $searchBy, $key )
    {
        return $model::where( $searchBy, $key )->get()->first();
    }

    private function get_transaction_data(Request $request, $sender, $receiver )
    {
        return [
            'sender_id'                             =>      $sender->user_id,
            'receiver_id'                           =>      $receiver->user_id,
            'sender_name'                           =>      $sender->full_name,
            'receiver_name'                         =>      $receiver->full_name,
            'amount'                                =>      $this->sendingAmount,
            'fee'                                   =>      0,
            'description'                           =>      $this->description,
            'transaction_type'                      =>      0,
            'status'                                =>      2,
            'sender_ip'                             =>      $request->ip(),
            'sender_address_from_google_map'        =>      null,
            'sender_coordinates_from_google_map'    =>      null,
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
            'balance' => (double)$this->senderBalance- (double)$this->sendingAmount ,
            'transactions' => $transactions
        ];

        return $updated_data;
    }

}

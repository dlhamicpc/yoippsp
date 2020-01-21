<?php

namespace App\Http\Controllers\API\InnerWebsite\Transaction;

use App\User;
use App\Models\InnerWebsite\Transaction;
use App\Models\InnerWebsite\Bank;
use App\Models\InnerWebsite\PersonalUser;
use App\Models\InnerWebsite\UserBankLink;
use App\Models\InnerWebsite\UserCardLink;
use App\Models\InnerWebsite\Deposit;
use App\Models\InnerWebsite\Withdraw;
use App\Models\InnerWebsite\YoippspBankAccountDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawTransactionController extends TransactionController
{
    
    /******************************************************************/
    /************************  Withdraw TRANSACTION  *******************/
    /******************************************************************/
    /******************************************************************/
    /******************************************************************/
    /******************************************************************/
    public function withdraw_transaction(Request $request)
    {
        $data = $this->validate_withdraw_transaction($request);
        
        //IF DATA IS VALID
        if( $this->perform_withdraw_transaction( $data ) ){
            //Upon Successful withdraw transaction
            return $this->update_front_end_data_after_withdraw();
        }
        else{
            return abort(500, 'UNKNOWN_ERROR');
        }

    }

    private function update_front_end_data_after_withdraw()
    {
        $user_id = auth()->user()->id;
        $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->latest()
                                    ->paginate(10);

        $updated_data = [
            'balance' => $this->senderModel->balance ,
            'transactions' => $transactions
        ];

        return $updated_data;
    }

    private function perform_withdraw_transaction( $data )
    {
       /* try { */
            $bankID = $data['link_info']->bank_id;
            $bank = $this->find_bank_detail( $bankID );
            $bankDatabaseConnection = $this->make_connection_with_bank_database( $bank->bank_name );

            $userBalance = $this->find_user_balance();
            $withdrawer = $this->senderModel;

            $withdrawerBankAccount = $this->get_withdrawer_account_from_bank( $bankDatabaseConnection, $data );
            $this->check_card_or_account_existance_in_external_bank_database( $withdrawerBankAccount, $data['link_info'] );
            $this->validate_withdrawer_bank_balance( $userBalance, $data['withdraw_amount'] );

            $yoippspBankDetail = $this->yoippsp_bank_detail( $bankID ); //here in yoippsp database
            $yoippspBankAccount =  $this->get_yoippsp_account_from_bank( $bankDatabaseConnection, $yoippspBankDetail ); // in the bank database

            

            DB::transaction(function() use ( $withdrawerBankAccount, $yoippspBankAccount, $data, $yoippspBankDetail, $bank, $bankID, $userBalance, $withdrawer )
            {
                $yoippspBankAccount->update([
                    'balance' => ( (double)$yoippspBankAccount->first()->balance - (double)$data['withdraw_amount'] )
                ]);
                
                $withdrawerBankAccount->update([
                    'balance' => ( (double)$withdrawerBankAccount->first()->balance + (double)$data['withdraw_amount'] )
                ]);

                $yoippspBankDetail->update([
                    'amount' => ( (double)$yoippspBankDetail->amount - (double)$data['withdraw_amount'] )
                ]);

                $withdrawer->update([
                    'balance' => ( (double)$userBalance - (double)$data['withdraw_amount'] )
                ]);

                $withdraw = Withdraw::create($this->get_withdraw_data_details( $bankID, $data ));

                $transaction = Transaction::create( $this->get_withdraw_transaction_data( $bank, $data ) );

                $this->transactionSuccess = true;

            });

            if ( $this->transactionSuccess ) {
                return true;
            }
            else{
                return false;
            }
            

        /* } catch (\Throwable $th) {
            abort(500, 'UNKNOWN_ERROR2');
        } */

    }


    private function get_withdraw_transaction_data( $bank, $data )
    {
        return [
            'sender_id'                             =>      $bank->user_id,
            'receiver_id'                           =>      auth()->user()->id,
            'sender_name'                           =>      $bank->bank_name,
            'receiver_name'                         =>      $bank->full_name,
            'amount'                                =>      $data['withdraw_amount'],
            'fee'                                   =>      0,
            'description'                           =>      'Withdraw to a Bank',
            'transaction_type'                      =>      1,
            'status'                                =>      2,
            'sender_ip'                             =>      request()->ip(),
            'sender_address_from_google_map'        =>      null,
            'sender_coordinates_from_google_map'    =>      null,
        ];
    }

    private function get_withdraw_data_details( $bankID, $data )
    {
        return [
            'user_id' => auth()->user()->id,
            'bank_id' => $bankID,
            'amount'  => $data['withdraw_amount'],
            'ip'      => request()->ip()
        ];
    }

    private function validate_withdraw_transaction(Request $request)
    {
        $data = $request->validate([
            'withdraw_amount' => ['bail', 'required', 'numeric', 'min:10'],
            'payment_method_withdraw' => ['bail', 'required', 'string'],
            'card_or_bank'  => ['bail', 'required', 'string']
        ]);

        if( $data['card_or_bank'] == 'bank' ) {
            $userBankLink = UserBankLink::where(

                ['account_number' => $data['payment_method_withdraw'] 

            ])->where(['approved' => 'yes'])->get()->first();
            
            $data['link_info'] = $userBankLink;
        }
        else if( $data['card_or_bank'] == 'card' ) {
            $userCardLink = UserCardLink::where(['card_number' => $data['payment_method_withdraw'] ])->get()->first();
            $data['link_info'] = $userCardLink;
        }
        else{
            abort(422, 'PAYMENT_METHOD_DOESNOT_EXIST');
        }

        return $data;
        
    }

    private function validate_withdrawer_bank_balance( $withdrawerBalance, $withdrawAmount )
    {
        if(  (double)$withdrawerBalance < (double)$withdrawAmount  ){
            abort(422, 'INSUFFICIENT_WALLET_BALANCE');
        }
    }

    private function yoippsp_bank_detail( $bankID )
    {
        return YoippspBankAccountDetail::where(['bank_id' => $bankID])->get()->first();
    }

    private function find_bank_detail( $bankID )
    {
        return Bank::find($bankID); 
    }

    private function make_connection_with_bank_database( $bankName )
    {
        try {
            return DB::connection( $this->get_bank_database_connection_name( $bankName ) );
        } catch (\Throwable $th) {
            abort(500, 'CANNOT_ESTABLISH_CONNECTION_WITH_BANK_DATABASE');
        }
        
    }

    private function get_bank_database_connection_name( $bankName )
    {
        $bankNameToLower = strtolower($bankName);
        $bankNameSlugged = join( '_', explode( ' ', $bankNameToLower ) );
        $bankDatabaseConnectionName = 'external_database_bank_'.$bankNameSlugged;

        return $bankDatabaseConnectionName;
    }

    private function determine_bank_or_card_link( $cardOrBank )
    {
        if ( $cardOrBank == 'card' ) {
            return 'card_number';
        }
        return 'account_number';
    }

    /**
     * $type = card or bank 
     * $data = user bank info
     */
    private function get_withdrawer_account_from_bank( $bankDatabaseConnection, $data )
    {
        return $bankDatabaseConnection->table('customers')
                            ->where( $this->determine_bank_or_card_link( $data['card_or_bank'] ) , $data['payment_method_withdraw'] );
    }

    private function get_yoippsp_account_from_bank( $bankDatabaseConnection, $yoippspBankDetail )
    {
        return $bankDatabaseConnection->table('customers')
                        ->where('account_number', $yoippspBankDetail->bank_account_number );  
    }

    private function get_withdrawer_bank_balance( $withdrawerBankAccount )
    {
        return $withdrawerBankAccount->first()->balance;
    }

    private function check_card_or_account_existance_in_external_bank_database( $collection, $linkInfo )
    {
        if( $collection->first() == null ){
            $this->make_card_or_bank_link_invalid( $linkInfo );
            abort(422, 'INVALID_LINKAGE');
        }
        $this->make_card_or_bank_link_valid( $linkInfo );
    }

    private function make_card_or_bank_link_invalid( $linkInfo )
    {
        $linkInfo->update([
            'valid' => false
        ]);
    }

    private function make_card_or_bank_link_valid( $linkInfo )
    {
        $linkInfo->update([
            'valid' => true
        ]);
    }

}

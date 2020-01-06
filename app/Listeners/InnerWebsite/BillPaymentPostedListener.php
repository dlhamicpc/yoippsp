<?php

namespace App\Listeners\InnerWebsite;

use App\Events\InnerWebsite\BillPaymentPostedEvent;
use App\Models\InnerWebsite\BillPaymentUserAndCustomer;
use App\Models\InnerWebsite\UserBillPaymentInformation;
use App\Events\InnerWebsite\NotificationMessageEvent;
use App\Models\InnerWebsite\UserBillPaymentLink;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class BillPaymentPostedListener
{
    use InteractsWithQueue;

    private $databaseConnection;
    private $allCustomerBillInformation;
    private $billPaymentUser;
    private $customers;
    private $customerLinkExists;
    private $billPaymentPosted;
    private $billPaymentCustomerWithUserID = array();


    /**
     * Handle the event.
     *
     * @param  BillPaymentPostedEvent  $event
     * @return void
     */
    public function handle(BillPaymentPostedEvent $event)
    {
        $this->billPaymentUser = auth()->user()->bill_payment_user;
        $this->billPaymentPosted = $event->billPaymentPosted;
        
        $this->make_connection_with_bill_payment_provider_database($event->databaseConnectionName);

        //$this->get_bill_post_from_bill_payment_database();

        $this->get_bill_payment_user_customer();

        $this->existingCustomerViaLink();

        $this->empty_bill_payment_user_and_customers_table();

        $this->fill_bill_payment_user_and_customers_table();

        $this->get_bill_post_from_bill_payment_database();

        $this->fill_user_bill_payment_information_table();

        
    }

    private function make_connection_with_bill_payment_provider_database( $billPaymentProviderConnectionName )
    {
        try {
            $this->databaseConnection = DB::connection( $billPaymentProviderConnectionName );
        } catch (\Throwable $th) {
            abort(500, 'CANNOT_ESTABLISH_CONNECTION_WITH_BILL_PAYMENT_PROVIDER_DATABASE');
        }
    }

    //external database
    private function get_bill_post_from_bill_payment_database()
    {
        $this->allCustomerBillInformation = $this->databaseConnection->table('bill_payment_post')->where([
            'month' => $this->billPaymentPosted->payment_of_month,
            'year' => $this->billPaymentPosted->payment_of_year
        ])->get();
    }

    //external database
    private function get_bill_payment_user_customer()
    {
        $this->customers = $this->databaseConnection->table('customers')->get();
    }

    private function  fill_bill_payment_user_and_customers_table()
    {
        foreach( $this->customers as $customer ){
            $customer_linked = $this->check_if_customer_is_linked( $customer->payment_identification );
            
            if( $customer_linked != null ){

                $billPaymentUserAndCustomer = new BillPaymentUserAndCustomer();
                $billPaymentUserAndCustomer->user_id = $customer_linked->user_id;
                $billPaymentUserAndCustomer->bill_payment_user_id = $customer_linked->bill_payment_id;
                $billPaymentUserAndCustomer->user_payment_identification = $customer_linked->user_payment_identification;
                $temp = $billPaymentUserAndCustomer->save();

                $this->billPaymentCustomerWithUserID[ $customer_linked->user_payment_identification ] = [
                    $customer_linked->id, $customer_linked->user_id 
                ];

            }
        }

        return 'success';
    }

    private function existingCustomerViaLink()
    {
        $this->customerLinkExists = UserBillPaymentLink::get();
    } 

    private function check_if_customer_is_linked( $payment_identification )
    {
        foreach( $this->customerLinkExists as $customer){
            if( $customer->user_payment_identification == $payment_identification 
                && 
                $customer->bill_payment_id == $this->billPaymentUser->id 
                ){
                return $customer;
            }
        }
        return false;

    }

    private function empty_bill_payment_user_and_customers_table()
    {
        try {
            BillPaymentUserAndCustomer::where([
                'bill_payment_user_id' => $this->billPaymentUser->id
            ])->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }

    
    private function fill_user_bill_payment_information_table()
    {
        $total_expected_amount = 0.0;
        foreach( $this->allCustomerBillInformation as $singleCustomerInformation ){
            $userBillPaymentInformation = new UserBillPaymentInformation();

            $temp = $this->billPaymentCustomerWithUserID[$singleCustomerInformation->payment_identification ];

            $userBillPaymentInformation->user_id = $temp[1];
            $userBillPaymentInformation->link_id = $temp[0];
            $userBillPaymentInformation->bill_payment_user_id = $this->billPaymentUser->id;
            $userBillPaymentInformation->amount = $singleCustomerInformation->amount;
            $userBillPaymentInformation->payment_of_year = $singleCustomerInformation->year;
            $userBillPaymentInformation->payment_of_month = $singleCustomerInformation->month;
            $userBillPaymentInformation->payment_status = 'Pending';
            $success = $userBillPaymentInformation->save();
            
            $total_expected_amount += $singleCustomerInformation->amount;

            if( $success ){
                $this->send_notification( $temp[1], $singleCustomerInformation->amount );
            }
            
        }
        $this->update_total_expected_amount_on_bill_payment_post_table( $total_expected_amount );
    }

    private function update_total_expected_amount_on_bill_payment_post_table( $total_expected_amount )
    {
        $this->billPaymentPosted->update([
            'total_expected_amount' => $total_expected_amount
        ]);
    }

    private function send_notification( $receiveID, $amount )
    {
        event( new NotificationMessageEvent(
            auth()->user()->id, 
            $this->billPaymentUser->bill_payment_name,
            auth()->user()->avatar, 
            $receiveID, 
            2, 
            $this->compose_message( $this->billPaymentUser->bill_payment_name, $amount )
        ));
    }

    private function compose_message( $senderName, $amount )
    {
        $message = 'Your monthly bill for using services from  '.ucwords($senderName);
        $message.= ' is '.$amount.' Birr. You have until '.$this->billPaymentPosted->payment_end_on.' to pay.';
        return $message; 
    } 

}

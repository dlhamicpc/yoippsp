<?php

namespace App\Http\Controllers;

use App\Models\NotificationMessage;
use App\Models\InnerWebsite\Transaction;
use App\Models\InnerWebsite\BillPaymentUser;
use App\Models\InnerWebsite\BillPaymentPost;
use App\Models\InnerWebsite\UserBillPaymentInformation;
use Illuminate\Http\Request;

class NotificationMessageController extends Controller
{

    public function fetch_notification_and_notify_online() 
    {
        $this->update_online();

        $notificationMessages = $this->fetch_notification( auth()->user()->id );

        $result =  $this->fetch_other_data_if_count_greater_than_0_else( $notificationMessages, auth()->user()->id );

        return $result;

    }

    private function update_online()
    {
        auth()->user()->update([
            'online' => 1
        ]);
    }


    private function fetch_notification( $user_id )
    {
        $notificationMessages =  NotificationMessage::where([ 'receiver_id' => $user_id ])->latest();
        $notificationMessagesCount = $notificationMessages->count();
        $notificationMessagesPaginated = $notificationMessages->paginate(10);
        $notificationMessagesNoPagination = $notificationMessages->get();

        return [
            $notificationMessagesNoPagination, $notificationMessagesPaginated, $notificationMessagesCount
        ];
    }


    private function fetch_other_data_if_count_greater_than_0_else( $notificationMessagesArray, $user_id )
    {
        $notificationMessageCount = $notificationMessagesArray[2];
        $notificationMessagesPaginated = $notificationMessagesArray[1];
        $notificationMessagesNoPagination = $notificationMessagesArray[0];
        $billPaymentNotification = $this->find_if_new_bill_payment_is_posted( $notificationMessagesNoPagination );

        if( count( $billPaymentNotification ) == 0 ){
            $billPaymentNotification == 'empty';
        }

        if( strpos(request()->server('HTTP_REFERER'),"notification_history") ) {
            $ids = $this->get_all_notifications_id( $notificationMessagesNoPagination );
            $this->soft_delete_read_notification( $ids );
        }

        if( $notificationMessageCount > 0 ){
            $userDetailsModel = $this->get_model();
            $userDetails = $userDetailsModel::where( 'user_id', $user_id )->get()->first();
            $transactions = Transaction::where( 'sender_id' , $user_id )
                                    ->orWhere( 'receiver_id', $user_id )
                                    ->latest()
                                    ->paginate(10);

            

            $updateData = [
                'notificationCount' => $notificationMessageCount,
                'notificationMessagesNoPagination' => $notificationMessagesNoPagination,
                'notificationMessagesPaginated' => $notificationMessagesPaginated,
                'balance' => $userDetails->balance,
                'userDetails' => $userDetails,
                'transactions' => $transactions,
                'billPaymentNotification' => $billPaymentNotification,
            ];

            return $updateData;
        }
        else{
            return '0';
        }
    }

    private function get_model()
    {
        $role_id = auth()->user()->role_id;

        switch ($role_id) {
            case 1:{
                return new \App\Models\InnerWebsite\YoippspAdminUser();
            }
            case 5:{
                return new \App\Models\InnerWebsite\PersonalUser();
            }
            case 6:{
                return new \App\Models\InnerWebsite\BillPaymentUser();
            }
            default:{
                abort(422, 'Invalid Request');
            }
        }

    }

    //return all ids
    private function get_all_notifications_id( $notificationMessages )
    {
        return $notificationMessages->pluck('id')->toArray();
    }

    private function soft_delete_read_notification( $ids )
    {
        return NotificationMessage::destroy($ids);
    }

    public function make_all_notification_read()
    {
        $result = $this->soft_delete_read_notification( $this->get_all_notifications_id( $notificationMessages ) );
    } 



    public function fetch_for_paginate()
    {
        return NotificationMessage::where([ 'receiver_id' => $user_id ])->latest()->paginate(10);
    }

    private function find_if_new_bill_payment_is_posted( $notificationMessagesNoPagination )
    {
        $notificationBill = array();
        foreach( $notificationMessagesNoPagination as $notification ) {

            if( $notification->type == 2 && auth()->user->role_id == 6 ){
                return [];
            }

            else if( $notification->type == 2 ){
                //dump($notification->receiver_id);
                $billPaymentProviderUser = $this->find_bill_payment_provider( $notification->sender_id );

                if( $billPaymentProviderUser != null ) {
                    //dd($billPaymentProviderUser->type);
                    $bill_payment_provider_type = $billPaymentProviderUser->type;
                    $billPaymentPost = $this->find_bill_payment_latest_post( $billPaymentProviderUser );

                    if( $billPaymentPost != null ) {
                        $userBillPaymentInformation = $this->find_user_bill_payment_information( 
                            $billPaymentProviderUser->id, $notification->receiver_id );

                        if( $userBillPaymentInformation != null && $userBillPaymentInformation->payment_status != 'Paid' ) {
                            $notificationBill[ 
                                $this->find_bill_payment_type_string( $bill_payment_provider_type ) 
                                ] = $userBillPaymentInformation;
                        }
                    }
                }
            }
        }
        //dd($notificationBill);
        return $notificationBill;
    }

    private function find_bill_payment_provider( $userID )
    {
        return BillPaymentUser::where('user_id', $userID)->get()->first();
    }

    private function find_bill_payment_latest_post( $billPaymentProviderUser )
    {
        return BillPaymentPost::where('bill_payment_user_id', $billPaymentProviderUser->id )->latest()->get()->first();

    }

    private function find_user_bill_payment_information( $billPaymentProviderID, $receiver_id )
    {
        return UserBillPaymentInformation::where([
            'bill_payment_user_id' => $billPaymentProviderID,
            'user_id' => $receiver_id
            ])->latest()->get()->first();
    }

    private function find_bill_payment_type_string( $type )
    {
        switch ( $type ) {
            case 0: return 'water';
            case 1: return 'electricity';
            case 2: return 'dstv';
        }
    }

}

<?php

namespace App\Events\InnerWebsite;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BillPaymentPostedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $billPaymentUser;
    public $databaseConnectionName;
    public $billPaymentPosted;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $billPaymentPosted )
    {
        $this->billPaymentPosted = $billPaymentPosted;
        $this->billPaymentUser = \App\Models\InnerWebsite\BillPaymentUser::find( $billPaymentPosted->bill_payment_user_id );
        $this->get_bill_payment_provider_database_connection_name( $this->billPaymentUser->bill_payment_name );
    } 


    private function get_bill_payment_provider_database_connection_name( $billPaymentProviderName )
    {
        $billPaymentProviderToLower = strtolower($billPaymentProviderName);
        $billPaymentProviderSlugged = join( '_', explode( ' ', $billPaymentProviderToLower ) );
        $this->databaseConnectionName = 'external_database_bill_payment_provider_'.$billPaymentProviderSlugged;
    }

}

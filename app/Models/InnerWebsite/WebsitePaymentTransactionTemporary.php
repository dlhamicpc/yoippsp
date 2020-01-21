<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsitePaymentTransactionTemporary extends Model
{
    protected $fillable = [
        'website_user_id', 'user_id', 'amount', 'status', 'website_user_public_key',
        'payer_ip', 'payer_identification', 'metadata'
    ];



    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}

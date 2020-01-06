<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class UserBillPaymentInformation extends Model
{
    protected $fillable = [
        'user_id', 'link_id', 'bill_payment_user_id', 'amount',
        'payment_of_year', 'payment_of_month', 'payment_status'
    ];

    //Defining Relationship
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    //Defining Relationship
    public function user_bill_payment_link()
    {
        return $this->belongsTo(\App\Models\UserBillPaymentLink::class);
    }
}

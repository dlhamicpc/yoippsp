<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class UserBillPaymentLink extends Model
{
    protected $fillable = [
        'user_id', 'bill_payment_id', 'type', 'user_payment_identification'
    ];


    //Defining Relationship
    public function user_bill_payment_information()
    {
        return $this->hasMany(\App\Models\UserBillPaymentInformation::class);
    }
}

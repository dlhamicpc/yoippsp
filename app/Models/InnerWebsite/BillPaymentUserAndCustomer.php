<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class BillPaymentUserAndCustomer extends Model
{
    protected $fillable = [
        'user_id', 'bill_payment_user_id', 'user_payment_identification'
    ];


    //Defining Relationship
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}

<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillPaymentTransaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'link_id', 'bill_payment_user_id', 
        'payment_info_id', 'transaction_id', 
        'bill_payment_type', 'content', 'description',
    ]; 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    //Defining Relationship
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}

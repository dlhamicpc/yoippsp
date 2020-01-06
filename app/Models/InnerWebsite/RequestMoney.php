<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class RequestMoney extends Model
{
    protected $fillable = [
        'sender_id', 'reveiver_id', 'sender_name', 'receiver_name', 
        'amount', 'description', 'payment_due_date'
    ];
}

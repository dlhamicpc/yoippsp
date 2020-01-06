<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class BillPaymentPost extends Model
{
    protected $fillable = [
        'payment_of_month', 'payment_of_year', 
        'payment_start_on', 'payment_end_on', 
        'total_collected_amount', 'total_expected_amount', 
        'bill_payment_user_id'
    ];


}

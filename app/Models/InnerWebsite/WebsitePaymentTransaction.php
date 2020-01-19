<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsitePaymentTransaction extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'website_user_id', 'wptt_id', 'transaction_id', 'metadata', 'website_type_id'
    ];




    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

}

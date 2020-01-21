<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
        'user_id', 'bank_id', 'amount', 'ip'
    ];

    public $timestamps = false;
}

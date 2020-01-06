<?php

namespace App\Models\OuterWebsite;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    public $fillable = [
        'email', 'ip', 'device_info', 'subscribed_at',
    ];

    public static $rules =[
        'email' => 'required|email|unique:subscribers,email,NULL,id,deleted_at,NULL'
    ];

    public static $messages = [
        'unique' => 'You have already subscribed!',
        'email' => 'Please enter a valid Email Address!',
        'string' => 'Lala', 
    ];



    

}

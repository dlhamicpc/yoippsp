<?php

namespace App\Models\OuterWebsite;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUsOuter extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    public $fillable = [
        'full_name', 'email', 'body', 'ip', 'device_info', 'sent_at',
    ];

    public static $rules =[
        'full_name' => 'required | string ',
        'contact_email' => 'required | email',
        'body' => 'required | string',
    ];

    public static $messages = [
         
    ];
}

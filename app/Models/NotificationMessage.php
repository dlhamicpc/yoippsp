<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sender_id', 'sender_name', 'receiver_id', 'message' ,'image', 'type',
    ];
    
}

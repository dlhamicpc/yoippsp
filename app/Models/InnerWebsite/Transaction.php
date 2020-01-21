<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{

    protected $fillable = [
        'sender_id', 'receiver_id', 'sender_name', 'receiver_name',
        'amount', 'description', 'status', 'transaction_type',
        'fee', 'sender_ip', 'sender_address_from_google_map', 
        'sender_coordinates_from_google_map',
    ]; 

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'sender_address_from_google_map', 
        'sender_coordinates_from_google_map',
        'sender_softdeletes', 'receiver_softdeletes',
    ];

    //Defining Relationship
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}

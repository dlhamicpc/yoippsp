<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class UserCardLink extends Model
{

    protected $fillable = [
        'bank_id', 'user_id', 'type', 'card_number', 
        'cvv', 'holder_name', 'expire_date', 'valid'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'deleted_at', 'updated_at',
    ];

    //Defining Relationship
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function bank()
    {
        return $this->belongsTo(\App\Models\InnerWebsite\Bank::class);
    }
}

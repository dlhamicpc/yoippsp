<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class UserBankLink extends Model
{

    protected $fillable = [
        'user_id', 'bank_id' ,'account_number', 'book_number', 'full_name', 'valid'
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

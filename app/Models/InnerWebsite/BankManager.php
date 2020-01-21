<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class BankManager extends Model
{
    protected $fillable = [
        'user_id', 'bank_id', 'name', 'father_name', 'bank_branch'
    ];

    //Defining Relationship
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    //Defining Relationship
    public function bank()
    {
        return $this->belongsTo(\App\Models\InnerWebsite\Bank::class);
    }

}

<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'deleted_at', 'updated_at',
    ];


    public function getFullNameAttribute()
    {
        return $this->admin_name .' '.$this->admin_father_name;
    }

    //Defining Relationship
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function userCardLink()
    {
        return $this->hasMany(\App\Models\InnerWebsite\userCardLink::class);
    }

    public function userBankLink()
    {
        return $this->hasMany(\App\Models\InnerWebsite\userBankLink::class);
    }

}

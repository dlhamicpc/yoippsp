<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{

    protected $fillable = [
        'admin_name', '	admin_father_name', 'admin_office_phone_number', 'admin_gender', 'admin_date_of_birth', 
        'bank_name', 'bank_logo', 'bank_headquarter_address', 'bank_headquarter_city', 
        'bank_headquarter_state', 'bank_headquarter_country', 'settings'
    ];

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

    public function bank_managers()
    {
        return $this->hasMany(\App\Models\InnerWebsite\BankManager::class);
    }
    

    public function userCardLink()
    {
        return $this->hasMany(\App\Models\InnerWebsite\UserCardLink::class);
    }

    public function userBankLink()
    {
        return $this->hasMany(\App\Models\InnerWebsite\UserBankLink::class);
    }

}

<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class BillPaymentUser extends Model
{
    protected $fillable = [
        'user_id' ,'admin_name', 'admin_father_name', 'admin_date_of_birth', 
        'city', 'state', 'country', 'headquarter_address', 'bill_payment_name',
        'company_name','headquarter_home_number', 'admin_office_phone_number', 'settings',
        'balance'
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
}

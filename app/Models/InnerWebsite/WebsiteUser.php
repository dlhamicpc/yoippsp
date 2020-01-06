<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class WebsiteUser extends Model
{

    protected $fillable = [
        'user_id', 'admin_name', 'admin_father_name', 'admin_date_of_birth', 
        'city', 'state', 'country', 'headquarter_address', 'website_name',
        'company_name','headquarter_home_number', 'admin_office_phone_number', 'settings',
        'balance', 'webhook_url', 'callback_url'
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

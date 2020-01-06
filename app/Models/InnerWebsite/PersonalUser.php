<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class PersonalUser extends Model
{

    protected $fillable = [
        'balance', 'name', 'father_name', 'address', 'home_number', 'user_id',
        'country', 'city', 'state', 'date_of_birth', 'settings', 'gender', 'age'
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
        return $this->name .' '.$this->father_name;
    }

    //Defining Relationship
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}

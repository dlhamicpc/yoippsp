<?php

namespace App\Models\InnerWebsite;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    public function api()
    {
        return $this->belongsTo(\App\User::class);
    }
}

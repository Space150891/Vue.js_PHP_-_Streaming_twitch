<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Streamer extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomAchievement extends Model
{
    use SoftDeletes;
    //
    public function streamer()
    {
        return $this->belongsTo('App\Models\Streamer');
    }
}

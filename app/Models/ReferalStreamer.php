<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferalStreamer extends Model
{
    protected $fillable = [
        'user_id',
        'streamer_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoutedStreamer extends Model
{
    public function streamer()
    {
        return $this->belongsTo('App\Models\Streamer', 'streamer_id');
    }
}

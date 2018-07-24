<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainStreamer extends Model
{
    public function promouted()
    {
        return $this->belongsTo('App\Models\PromoutedStreamer', 'promouted_streamer_id');
    }
}

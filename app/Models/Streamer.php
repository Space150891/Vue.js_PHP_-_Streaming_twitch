<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Activity, SubscribedStreamers};
use Illuminate\Support\Carbon;

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

    public function referals()
    {
        return $this->hasMany('App\Models\ReferalStreamer');
    }

    public function subscription()
    {
        return $subscription = SubscribedStreamers::where('streamer_id', $this->id)->whereDate('valid_until', '>', Carbon::today()->toDateTimeString());
    }

    public function getOnlineViewers()
    {
        $now = new Carbon;
        $now->subSeconds(config('ospp.activity.valid_pause'));
        $updateTime = $now->toDateTimeString();
        return Activity::where([
            ['streamer_id', '=', $this->id],
            ['updated_at', '>', $updateTime],
        ])->count();
    }

}

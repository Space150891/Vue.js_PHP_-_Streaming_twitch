<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscribedStreamers extends Model
{

    // protected $table = "subscriptions";

    public function user()
    {
        return $this->belongsTo('App\Models\Streamer');
    }

    public function monthPlan()
    {
        return $this->hasOne('App\Models\MonthPlan');
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo('App\Models\SubscriptionPlan');
    }
}

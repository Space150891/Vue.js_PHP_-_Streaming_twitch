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
        $subscription = SubscribedStreamers::where('streamer_id', $this->id)->whereDate('valid_until', '>', Carbon::today()->toDateTimeString())->first();
        return $subscription;
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

    public function calculatePoints()
    {
        $points = config('ospp.activity.level_points');
        $now = new Carbon;
        $now->subSeconds(config('ospp.activity.valid_pause'));
        $updateTime = $now->toDateTimeString();
        $tolalViewers = Activity::where([
            ['streamer_id', '=', $this->id],
            ['updated_at', '>', $updateTime]
        ])->count();
        $subscribed = SubscribedStreamers::where([
            ['streamer_id', '=', $this->id],
            ['valid_from', '<=', $updateTime],
            ['valid_until', '>=', $updateTime],
        ])->first();
        if ($subscribed) {
            $plan = SubscriptionPlan::find($subscribed->subscription_plan_id);
            $points += $plan->points;
            $bonusPoints = SubscriptionPoint::where('subscription_plan_id', $subscribed->subscription_plan_id)->get();
            foreach ($bonusPoints as $bonusPoint) {
                if ($bonusPoint->from_viewers >= $tolalViewers && $bonusPoint->to_viewers <= $tolalViewers) {
                    $points += $bonusPoint->points;
                }
            }
        }
        return $points;
    }

}

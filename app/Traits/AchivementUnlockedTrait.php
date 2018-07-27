<?php

namespace App\Traits;
use App\Models\{User, Notification};

trait AchivementUnlockedTrait
{
    public function givePoints($userId, $points)
    {
        $user = User::find($userId);
        $viewer = $user->viewer()->first();
        $viewer->level_points = $viewer->level_points + $points;
        $viewer->current_points = $viewer->current_points + $points;
        $viewer->save();
    }

    public function sendNotification($userId, $achivementMessage)
    {
        $user = User::find($userId);
        $notify = new Notification();
        $notify->user_id = $user->id;
        $notify->event_type = 'user_message';
        $notify->message = 'New Achivement! ' . $achivementMessage;
        $notify->save();
    }
}

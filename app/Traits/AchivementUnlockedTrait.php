<?php

namespace App\Traits;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

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
        $data = [
            'event_type'      => 'user_message',
            'message'         => 'New Achivement! ' . $achivementMessage,
            'user_name'       => $user->name,
            'timestamp'       => time(),
        ];
        Redis::command('RPUSH', ['messages:' . $data['user_name'], json_encode($data)]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCustomAchievement extends Model
{
    public function achievement()
    {
        return $this->belongsTo('App\Models\CustomAchievement', 'custom_achievement_id', 'id');
    }
}

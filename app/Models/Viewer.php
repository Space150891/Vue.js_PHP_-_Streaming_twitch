<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Viewer extends Model
{

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function referals()
    {
        return $this->hasMany('App\Models\ReferalViewer');
    }

    public function items()
    {
        return $this->hasMany('App\Models\ViewerItem');
    }

    public function buyedCaseTypes()
    {
        return $this->hasMany('App\Models\BuyedCaseType');
    }

    public function cards()
    {
        return $this->hasMany('App\Models\Card');
    }

    public function increaseLevel($points)
    {
        $this->level_points += $points;
        $this->current_points += $points;
    }

    public function getLevel()
    {
        $str = (string) $this->level_points;
        $first = (int) substr($str, 0, 1);
        $length = strlen($str);
        if ($length < 3) {
            return 0;
        }
        $level = ($length * 3) - 8;
        if ($first > 4) {
            return $level + 2;
        } elseif ($first > 1) {
            return $level + 1;
        }
        return $level;
    }
}

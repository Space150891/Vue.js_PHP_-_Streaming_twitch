<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewerPrize extends Model
{
    public function prize()
    {
        return $this->belongsTo('App\Models\StockPrize', 'prize_id', 'id');
    }
}

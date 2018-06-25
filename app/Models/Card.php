<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function items()
    {
        return $this->hasMany('App\Models\CardItem');
    }
}

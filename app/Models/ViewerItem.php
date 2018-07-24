<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewerItem extends Model
{
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}

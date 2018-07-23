<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    
    public function type()
    {
        return $this->belongsTo('App\Models\ItemType', 'item_type_id');
    }
}

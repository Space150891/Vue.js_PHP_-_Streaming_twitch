<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCase extends Model
{
    protected $table = "items_cases";
    
    public function item()
    {
        return $this->hasMany('App\Models\Item', 'id', 'item_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LootCase extends Model
{
    //

    protected $table="cases";

    public function items()
    {
        return $this->hasMany('App\Models\ItemCase', 'case_id');
    }
}

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
}

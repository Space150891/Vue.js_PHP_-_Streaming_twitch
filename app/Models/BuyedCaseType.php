<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyedCaseType extends Model
{
    public function case()
    {
        return $this->belongsTo('App\Models\CaseType', 'case_type_id');
    }
}

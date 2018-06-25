<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function type()
    {
        return $this->belongsTo('App\Models\ContactType', 'contact_type_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = "activities";
    protected $fillable = ["drops", "created_at", "updated_at", "viewer_id", "streamer_id"];
}

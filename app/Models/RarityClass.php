<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RarityClass extends Model
{
    public function tier()
    {
        switch ($this->name) {
            case 'common':
                return 'Tier 1';
            case 'uncommon':
                return 'Tier 2';
            case 'rare':
                return 'Tier 3';
            case 'epic':
                return 'Tier 4';
            case 'legendary':
                return 'Tier 5';
            default:
                return 'special';
        }
    }
}

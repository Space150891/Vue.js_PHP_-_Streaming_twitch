<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Donate100Achievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "donate 100";

    /*
     * A small description for the achievement
     */
    public $description = "Donate 100 USD";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 100;
}
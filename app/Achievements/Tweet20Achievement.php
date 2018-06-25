<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Tweet20Achievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "tweet 20";

    /*
     * A small description for the achievement
     */
    public $description = "Tweet 20 times";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 20;
}
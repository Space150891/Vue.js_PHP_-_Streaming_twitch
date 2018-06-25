<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Tweet50Achievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "tweet 50";

    /*
     * A small description for the achievement
     */
    public $description = "Tweet 50 times";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 50;
}
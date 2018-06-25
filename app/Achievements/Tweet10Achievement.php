<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Tweet10Achievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "tweet 10";

    /*
     * A small description for the achievement
     */
    public $description = "Tweet 10 times";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 10;
}
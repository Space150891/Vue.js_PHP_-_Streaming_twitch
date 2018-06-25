<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FirstTweetAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "first tweet";

    /*
     * A small description for the achievement
     */
    public $description = "You make first tweet";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
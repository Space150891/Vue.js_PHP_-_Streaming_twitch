<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FirstWinAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "first win";

    /*
     * A small description for the achievement
     */
    public $description = "Your first win";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
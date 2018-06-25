<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FirstPriceWinAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "first price win";

    /*
     * A small description for the achievement
     */
    public $description = "Your first price win";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FirstNonPriceWinAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "first item win";

    /*
     * A small description for the achievement
     */
    public $description = "Your first item win";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
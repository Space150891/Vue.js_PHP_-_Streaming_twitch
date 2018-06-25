<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FirstDonateAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "first donate";

    /*
     * A small description for the achievement
     */
    public $description = "First donate";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
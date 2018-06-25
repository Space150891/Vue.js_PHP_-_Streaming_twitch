<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FirstLoginAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "first login";

    /*
     * A small description for the achievement
     */
    public $description = "First Login";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
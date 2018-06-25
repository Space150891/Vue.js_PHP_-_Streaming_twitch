<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Login10daysAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "login 10 days";

    /*
     * A small description for the achievement
     */
    public $description = "Login 10 days";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 10;
}
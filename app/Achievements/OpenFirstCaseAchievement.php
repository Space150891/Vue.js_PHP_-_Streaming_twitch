<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class OpenFirstCaseAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "open first case";

    /*
     * A small description for the achievement
     */
    public $description = "Opened first case";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
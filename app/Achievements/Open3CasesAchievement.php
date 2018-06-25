<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Open3CasesAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "open 3 cases";

    /*
     * A small description for the achievement
     */
    public $description = "Opened 3 cases";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 3;
}
<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Open2CasesAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "open 2 cases";

    /*
     * A small description for the achievement
     */
    public $description = "Opened 2 cases";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 2;
}
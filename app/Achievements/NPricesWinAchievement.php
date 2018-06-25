<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class NPricesWinAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "N prices win";

    /*
     * A small description for the achievement
     */
    public $description = "Win 100 prises";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 100;
}
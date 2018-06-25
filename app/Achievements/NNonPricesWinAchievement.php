<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class NNonPricesWinAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "N items win";

    /*
     * A small description for the achievement
     */
    public $description = "Win 100 items";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 100;
}
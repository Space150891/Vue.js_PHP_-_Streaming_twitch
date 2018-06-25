<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class BuyFirstDiamondsAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "first diamond";

    /*
     * A small description for the achievement
     */
    public $description = "Buy first diamonds";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class BuyFirstDiamondsAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "buy 100 diamonds";

    /*
     * A small description for the achievement
     */
    public $description = "Buyed 100 diamonds";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 100;
}
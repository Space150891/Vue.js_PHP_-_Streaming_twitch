<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class BuyFirstCaseAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "buy first case";

    /*
     * A small description for the achievement
     */
    public $description = "Buyed first case";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
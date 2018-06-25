<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Refer100ViewersAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "Refer 100 viewers";

    /*
     * A small description for the achievement
     */
    public $description = "Refer 100 viewers";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 100;
}
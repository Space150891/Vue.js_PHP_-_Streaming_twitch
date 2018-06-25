<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FirstReferViewerAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "first refer viewer";

    /*
     * A small description for the achievement
     */
    public $description = "First refer viewer";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
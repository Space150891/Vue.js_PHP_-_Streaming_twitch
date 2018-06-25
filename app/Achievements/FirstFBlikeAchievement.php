<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FirstFBlikeAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "first FB like";

    /*
     * A small description for the achievement
     */
    public $description = "You make first facebook like";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
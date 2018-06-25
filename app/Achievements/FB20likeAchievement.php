<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FB20likeAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "FB 20 likes";

    /*
     * A small description for the achievement
     */
    public $description = "You make 20 facebook likes";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 20;
}
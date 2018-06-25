<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FB50likeAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "FB 50 likes";

    /*
     * A small description for the achievement
     */
    public $description = "You make 50 facebook likes";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 50;
}
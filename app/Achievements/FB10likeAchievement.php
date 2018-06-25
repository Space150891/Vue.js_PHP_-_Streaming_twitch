<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FB10likeAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "FB 10 likes";

    /*
     * A small description for the achievement
     */
    public $description = "You make 10 facebook likes";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 10;
}
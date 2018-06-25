<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class FirstStreamerSubscribeAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "first streamer subscribe";

    /*
     * A small description for the achievement
     */
    public $description = "First subscribe to streamer";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
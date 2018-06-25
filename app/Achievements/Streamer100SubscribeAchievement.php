<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class Streamer100SubscribeAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "subscribe to 100 streamers";

    /*
     * A small description for the achievement
     */
    public $description = "Subscribe to 100 streamers";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 100;
}
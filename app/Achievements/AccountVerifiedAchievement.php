<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;

class AccountVerifiedAchievement extends Achievement
{
    /*
     * The achievement name
     */
    public $name = "account verified";

    /*
     * A small description for the achievement
     */
    public $description = "Your account verified";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;
}
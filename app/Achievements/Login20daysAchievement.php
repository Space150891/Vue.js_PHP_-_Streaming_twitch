<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;
use App\Traits\AchivementUnlockedTrait;

class Login20daysAchievement extends Achievement
{
    use AchivementUnlockedTrait;
    /*
     * The achievement name
     */
    public $name = "login 20 days";

    /*
     * A small description for the achievement
     */
    public $description = "Login 20 days";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 20;

    public $levelPoints = 10;

    public function whenUnlocked($progress)
    {
        $this->givePoints($progress->achiever_id, $this->levelPoints);
        $this->sendNotification($progress->achiever_id, $this->description);
    }
}
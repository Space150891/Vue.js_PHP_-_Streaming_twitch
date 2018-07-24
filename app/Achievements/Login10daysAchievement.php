<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;
use App\Traits\AchivementUnlockedTrait;

class Login10daysAchievement extends Achievement
{
    use AchivementUnlockedTrait;
    /*
     * The achievement name
     */
    public $name = "login 10 days";

    /*
     * A small description for the achievement
     */
    public $description = "Login 10 days";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 10;

    public $levelPoints = 10;

    public function whenUnlocked($progress)
    {
        $this->givePoints($progress->achiever_id, $this->levelPoints);
        $this->sendNotification($progress->achiever_id, $this->description);
    }
}
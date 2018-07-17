<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;
use App\Traits\AchivementUnlockedTrait;

class FirstPriceWinAchievement extends Achievement
{
    use AchivementUnlockedTrait;
    /*
     * The achievement name
     */
    public $name = "first price win";

    /*
     * A small description for the achievement
     */
    public $description = "Your first price win";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1;

    public $levelPoints = 10;

    public function whenUnlocked($progress)
    {
        $this->givePoints($progress->achiever_id, $this->levelPoints);
        $this->sendNotification($progress->achiever_id, $this->description);
    }
}
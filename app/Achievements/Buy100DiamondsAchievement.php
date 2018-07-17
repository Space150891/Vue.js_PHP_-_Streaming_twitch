<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;
use App\Traits\AchivementUnlockedTrait;

class Buy100DiamondsAchievement extends Achievement
{
    use AchivementUnlockedTrait;
    /*
     * The achievement name
     */
    public $name = "buy 100 diamonds";

    /*
     * A small description for the achievement
     */
    public $description = "Buyed 100 diamonds";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 100;

    public $levelPoints = 10;

    public function whenUnlocked($progress)
    {
        $this->givePoints($progress->achiever_id, $this->levelPoints);
        $this->sendNotification($progress->achiever_id, $this->description);
    }
}
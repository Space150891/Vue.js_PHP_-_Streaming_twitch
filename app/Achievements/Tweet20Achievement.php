<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;
use App\Traits\AchivementUnlockedTrait;

class Tweet20Achievement extends Achievement
{
    use AchivementUnlockedTrait;
    /*
     * The achievement name
     */
    public $name = "tweet 20";

    /*
     * A small description for the achievement
     */
    public $description = "Tweet 20 times";
    
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
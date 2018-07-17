<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;
use App\Traits\AchivementUnlockedTrait;

class FB10likeAchievement extends Achievement
{
    use AchivementUnlockedTrait;
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

    public $levelPoints = 10;

    public function whenUnlocked($progress)
    {
        $this->givePoints($progress->achiever_id, $this->levelPoints);
        $this->sendNotification($progress->achiever_id, $this->description);
    }
}
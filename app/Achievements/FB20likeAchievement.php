<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;
use App\Traits\AchivementUnlockedTrait;

class FB20likeAchievement extends Achievement
{
    use AchivementUnlockedTrait;
    /*
     * The achievement name
     */
    public $name = "FB 20 likes";

    /*
     * A small description for the achievement
     */
    public $description = "You make 20 facebook likes";
    
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
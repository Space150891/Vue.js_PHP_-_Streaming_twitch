<?php

namespace App\Achievements;

use Gstt\Achievements\Achievement;
use App\Traits\AchivementUnlockedTrait;

class FB50likeAchievement extends Achievement
{
    use AchivementUnlockedTrait;
    /*
     * The achievement name
     */
    public $name = "FB 50 likes";

    /*
     * A small description for the achievement
     */
    public $description = "You make 50 facebook likes";
    
    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 50;

    public $levelPoints = 10;

    public function whenUnlocked($progress)
    {
        $this->givePoints($progress->achiever_id, $this->levelPoints);
        $this->sendNotification($progress->achiever_id, $this->description);
    }
}
<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{Card, CustomAchievement, UserCustomAchievement, Achievement, AchievementProgres};

class AchivementsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    public function list()
    {
        $user = auth()->user();
        $achievements = AchievementProgres::where('user_id', $user->id)->whereNotNull('unlocked_at')->get();
        foreach ($achievements as &$achievement) {
            $ach = Achievement::find($achievement->achievement_id);
            $achievement->image = $ach->image;
            $achievement->description = $ach->description;
            
        }
        $customs = [];
        $customs = UserCustomAchievement::where('user_id', $user->id)->get();
        for ($i = 0; $i < count($customs); $i++) {
            $achievement = $customs[$i]->achievement()->first();
            $streamer = $achievement->streamer()->first();
            $user = $streamer->user()->first();
            $customs[$i]->image = $user->avatar;
            $customs[$i]->text = $achievement->text;
        }
        $inProgress = AchievementProgres::where('user_id', $user->id)->whereNull('unlocked_at')->get();
        foreach ($inProgress as &$achievement) {
            $ach = Achievement::find($achievement->achievement_id);
            $achievement->image = $ach->image;
            $achievement->description = $ach->description;
            $achievement->total = $ach->steps;
        }
        return response()->json(['data' => [
            'achivements'           => $achievements,
            'customs'               => $customs,
            'in_progress'           => $inProgress,
        ]]);
    }

    public function card()
    {
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        // get all achievements
        //$achievements  = $user->unlockedAchievements();
        $achievements = AchievementProgres::where('user_id', $user->id)->whereNotNull('unlocked_at')->get();
        foreach ($achievements as &$achievement) {
            $ach = Achievement::find($achievement->achievement_id);
            $achievement->image = $ach->image;
            $achievement->description = $ach->description;
            $achievement->id = $ach->id;
        }
        $customs = UserCustomAchievement::where('user_id', $user->id)->get();
        // get achievements in cards
        $cards = Card::where('viewer_id', $viewer->id)->get();
        $cardAchievementsIds = [];
        foreach ($cards as $card) {
            $cardAchievementsIds[] = [
                'id'    => $card->achivement_id,
                'type'  => $card->a_type,
            ];
        }
        // select achivements not in cards
        $list = [];
        foreach ($achievements as $achievement) {
            $find = false;
            foreach ($cardAchievementsIds as $cardAchievementsId) {
                if ($cardAchievementsId['id'] == $achievement->achievement_id && is_null($cardAchievementsId['type'])) {
                    $find = true;
                }
            }
            if ($find === false) {
                $ach = Achievement::find($achievement->achievement_id);
                $achievement->name = $ach->description;
                $list[] = $achievement;
            }
        }
        // select custom achievements not in cards
        foreach ($customs as $custom) {
            $find = false;
            foreach ($cardAchievementsIds as $cardAchievementsId) {
                if ($cardAchievementsId['id'] == $custom->custom_achievement_id && $cardAchievementsId['type'] == "custom") {
                    $find = true;
                }
            }
            if ($find === false) {
                $customAchievement = CustomAchievement::find($custom['id']);
                $details = new \stdClass();;
                $details->id = "c" . $custom['id'];
                $details->name = $customAchievement->text;
                $details->unlocked_at = $customAchievement->updated_at;
                $list[] = $details;
            }
        }
        return response()->json(['data' => [
            'achivements' => $list,
        ]]);
    }

    public function addProgress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'achivement_name'   => 'required|min:5',
            'points'            => 'numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);

        }
        $user = auth()->user();
        $points = $request->has('points') ? $request->points : 1;
        $achivementName = trim($request->achivement_name);
        $error = false;
        switch ($achivementName) {
            case 'Tweet10Achievement':
                if (!$this->alreadyToday($achivementName)) {
                    $user->addAchievement($achivementName);
                } else {
                    $error = 'you already twitch today';
                }
                break;
            case 'Tweet20Achievement':
                if (!$this->alreadyToday($achivementName)) {
                    $user->addAchievement($achivementName);
                } else {
                    $error = 'you already twitch today';
                }
            break;
                case 'Tweet50Achievement':
                if (!$this->alreadyToday($achivementName)) {
                    $user->addAchievement($achivementName);
                } else {
                    $error = 'you already twitch today';
                }
                break;
            case 'FB10likeAchievement':
                if (!$this->alreadyToday($achivementName)) {
                    $user->addAchievement($achivementName);
                } else {
                    $error = 'you already twitch today';
                }
                break;
            case 'FB20likeAchievement':
                if (!$this->alreadyToday($achivementName)) {
                    $user->addAchievement($achivementName);
                } else {
                    $error = 'you already twitch today';
                }
            break;
                case 'FB50likeAchievement':
                if (!$this->alreadyToday($achivementName)) {
                    $user->addAchievement($achivementName);
                } else {
                    $error = 'you already twitch today';
                }
                break;
            default:
                $user->addAchievement($achivementName, $points);
                break;
        }
        if ($error) {
            return response()->json([
                'error' => [
                    $error,
                ],
            ]);    
        }
        return response()->json([
            'message' => [
                "achivement`s progress added",
            ],
        ]);
    }

    private function alreadyToday($achivementClass)
    {
        \Log::info($achivementClass);
        $user = auth()->user();
        $achievement = Achievement::where('class_name', $achivementClass)->first();
        $achievementProgres = AchievementProgres::where([
            ['user_id', '=', $user->id],
            ['achievement_id', '=', $achievement->id],
        ])->first();
        if (!$achievementProgres) {
            return false;
        }
        $now = new Carbon;
        return ($achievementProgres->updated_at->toDateString() === $now->toDateString());
    }
     
}

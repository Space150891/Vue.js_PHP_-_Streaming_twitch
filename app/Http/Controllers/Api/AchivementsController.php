<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{Notification, Card, CustomAchievement, UserCustomAchievement, Streamer};

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
        $achievements  = $user->unlockedAchievements();
        $list = [];
        foreach ($achievements as $achievement) {
            $details = \DB::table('achievement_details')->find($achievement->achievement_id);
            $details->unlocked_at = $achievement->unlocked_at;
            $list[] = $details;
        }
        $customs = [];
        $customs = UserCustomAchievement::where('user_id', $user->id)->get();
        for ($i = 0; $i <count($customs); $i++) {
            $achievement = $customs[$i]->achievement()->first();
            $streamer = $achievement->streamer()->first();
            $user = $streamer->user()->first();
            $customs[$i]->image = $user->avatar;
            $customs[$i]->text = $achievement->text;
        }
        return response()->json(['data' => [
            'achivements' => $list,
            'customs'      => $customs,
        ]]);
    }

    public function card()
    {
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        // get all achievements
        $achievements  = $user->unlockedAchievements();
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
                $details = \DB::table('achievement_details')->find($achievement->achievement_id);
                $details->unlocked_at = $achievement->unlocked_at;
                $list[] = $details;
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
                $achivement = $this->getClass($achivementName);
                if (!$this->alreadyToday($achivementName)) {
                    $user->addProgress($achivement, 1);
                } else {
                    $error = 'you already twitch today';
                }
                break;
            case 'Tweet20Achievement':
                $achivement = $this->getClass($achivementName);
                if (!$this->alreadyToday($achivementName)) {
                    $user->addProgress($achivement, 1);
                } else {
                    $error = 'you already twitch today';
                }
            break;
                case 'Tweet50Achievement':
                $achivement = $this->getClass($achivementName);
                if (!$this->alreadyToday($achivementName)) {
                    $user->addProgress($achivement, 1);
                } else {
                    $error = 'you already twitch today';
                }
                break;
            case 'FB10likeAchievement':
                $achivement = $this->getClass($achivementName);
                if (!$this->alreadyToday($achivementName)) {
                    $user->addProgress($achivement, 1);
                } else {
                    $error = 'you already twitch today';
                }
                break;
            case 'FB20likeAchievement':
                $achivement = $this->getClass($achivementName);
                if (!$this->alreadyToday($achivementName)) {
                    $user->addProgress($achivement, 1);
                } else {
                    $error = 'you already twitch today';
                }
            break;
                case 'FB50likeAchievement':
                $achivement = $this->getClass($achivementName);
                if (!$this->alreadyToday($achivementName)) {
                    $user->addProgress($achivement, 1);
                } else {
                    $error = 'you already twitch today';
                }
                break;
            default:
                $achivement = $this->getClass($achivementName);
                $user->addProgress($achivement, $points);
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

    private function alreadyToday($achivementName)
    {
        if ($this->isFirst($achivementName)) {
            return false;
        }
        $user = auth()->user();
        $class = $this->getClass($achivementName);
        $updated   = $user->achievements($class)->first()->updated_at->toDateString();
        $now = new Carbon;
        $today = $now->toDateString();
        return ($today === $updated);
    }

    private function getClass($achivementName)
    {
        $class = "\App\Achievements\\" . $achivementName;
        return new $class;
    }

    private function isFirst($achivementName)
    {
        $class = "App\Achievements\\" . $achivementName;
        $count = \DB::table('achievement_details')->where('class_name', $class)->count();
        return ($count === 0);
    }
 
}

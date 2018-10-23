<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{Card, CustomAchievement, UserCustomAchievement, Achievement, AchievementProgres, RarityClass};

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
                'errors' => $validator->errors()->all(),
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

    public function inventory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page'          => 'required|numeric|min:1',
            'on_page'       => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $user = auth()->user();
        $return = [];
        $onPage = $request->on_page;
        $page = $request->page;
        $offset = $onPage * ($page - 1);
        $totalBasic = AchievementProgres::where('user_id', $user->id)->count();
        $totalCustom = UserCustomAchievement::where('user_id', $user->id)->count();
        $count = $totalBasic + $totalCustom;
        $pages = ceil($count / $onPage);
        $achievementProgres = AchievementProgres::where('user_id', $user->id)
                        ->orderBy('unlocked_at', 'DESC')
                        ->skip($offset)->take($onPage)->get();
        foreach ($achievementProgres as $progres) {
            $data = [];
            $achievement = Achievement::find($progres->achievement_id);
            $data['name'] = $achievement->name;
            $data['description'] = $achievement->description;
            $data['total_steps'] = $achievement->steps;
            $data['done_steps'] = $progres->steps;
            $data['unlocked_at'] = is_null($progres->unlocked_at) ? null : convertDate($progres->unlocked_at);
            $data['type'] = 'basic';
            $data['image']  =  $achievement->image;
            $data['points'] = $achievement->level_points;
            $data['diamonds'] = $achievement->diamonds;
            $data['case_rarity'] = $this->getRarityById($achievement->case_rarity_id);
            $data['frame_rarity'] = $this->getRarityById($achievement->frame_rarity_id);
            $data['hero_rarity'] = $this->getRarityById($achievement->hero_rarity_id);
            $return[] = $data;
        }
        $resTotal = count($return);
        if ($resTotal < $onPage) {
            $customProgres = UserCustomAchievement::where('user_id', $user->id)
            ->skip($offset - $totalBasic)->take($onPage - $resTotal)->get();
            foreach ($customProgres as $progres) {
                $data = [];
                $custom = CustomAchievement::find($progres->custom_achievement_id);
                $data['description'] = $custom->text;
                $data['unlocked_at'] = convertDate($progres->created_at);
                $data['type'] = 'custom';
                $return[] = $data;
            }
        }
        return response()->json([
            'data' => [
                'achievements' => $return,
                'page'  => $page,
                'pages' => ceil($count / $onPage),
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

    private function getRarityById($rarityId)
    {
        if ($rarityId > 0) {
            $rarityClass = RarityClass::find($rarityId);
            return ucfirst($rarityClass->name);
        } else {
            return 'not';
        }
    }
     
}

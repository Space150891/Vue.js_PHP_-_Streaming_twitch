<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\Notification;

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
        return response()->json(['data' => [
            'achivements' => $list,
        ]]);
    }

    public function addProgress(Request $request)
    {

    }
 
}

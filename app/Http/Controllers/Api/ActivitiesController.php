<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;
use App\Models\{Viewer, Streamer, Activity};

use App\Models\Game;

class ActivitiesController extends Controller
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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channel'       => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $streamer = Streamer::where('name', $request->channel)->first();
        if (!$streamer) {
            return response()->json([
                'errors' => 'streamer not found',
            ]);
        }
        $validPause = config('ospp.activity.valid_pause');
        $levelPoints = config('ospp.activity.level_points');
        $dropFull = config('ospp.activity.dromp_limit');
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $now = new Carbon();
        $time = $now->toDateTimeString();
        $activity = Activity::where([
            ['viewer_id', '=', $viewer->id],
            ['streamer_id', '=', $streamer->id],
        ])->first();
        if ($activity) {
            if ($this->getTimer($activity->updated_at, $time) < $validPause) {
                $activity->updated_at = $time;
                $activity->drops = $activity->drops + 1;
            } else {
                $activity->drops = 0;
            }
            $activity->updated_at = $time;
        } else {
            $activity = new Activity();
            $activity->viewer_id = $viewer->id;
            $activity->streamer_id = $streamer->id;
        }
        if ($activity->drops > $dropFull) {
            $viewer->level_points = $viewer->level_points + $levelPoints;
            $viewer->current_points = $viewer->current_points + $levelPoints;
            $viewer->save();
            $activity->drops = 0;
        }
        $activity->save();
        return response()->json([
            'message' => 'status updated',
            'data'    => [
                'name'      => $viewer->name,
                'points'    => $viewer->current_points,
                'diamonds'  => $viewer->diamonds,
                'level'     => $viewer->getLevel(),
            ],
        ]);
    }

    private function getTimer($startDate, $endDate) {
        return strtotime($endDate) - strtotime($startDate);
    }
 
}

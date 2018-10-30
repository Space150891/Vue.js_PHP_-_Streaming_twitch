<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;
use App\Models\{
    Activity,
    ActiveStreamer,
    Afiliate,
    PromoutedStreamer,
    Streamer,
    SubscribedStreamers,
    SubscriptionPlan,
    SubscriptionPoint,
    Viewer,
    User
};

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
        $this->middleware('auth:api', ['except' => ['streamInfo']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channels'       => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $streamers = [];
        $channels = explode(',', $request->channels);
        foreach ($channels as $channel) {
            $streamer = Streamer::where('name', $channel)->first();
            if (!$streamer) {
                return response()->json([
                    'errors' => 'streamer not found',
                ]);
            }
            $active = ActiveStreamer::where('streamer_id', $streamer->id)->first();
            if (!$active) {
                return response()->json([
                    'errors' => 'streamer offline',
                ]);
            }
            $streamers[] = $streamer;
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $now = new Carbon();
        $updatedTime = $now->toDateTimeString();
        $points = 0;
        foreach ($streamers as $streamer) {
            $active = $this->checkViewerOnline($viewer->id, $streamer->id);
            if ($active) {
                $active->updated_at = $updatedTime;
                $active->save();
            } else {
                // new activity
                $activity = Activity::where([
                    ['viewer_id', '=', $viewer->id],
                    ['streamer_id', '=', $streamer->id],
                ])->first();
                if ($activity) {
                    $now = new Carbon;
                    $activity->created_at = $now->toDateTimeString();
                    $activity->updated_at = $now->toDateTimeString();
                } else {
                    $activity = new Activity();
                    $activity->viewer_id = $viewerId;
                    $activity->streamer_id = $streamerId;
                }
                $activity->save();
            }
        }
        $allowStreams = Activity::where([
            ['viewer_id', '=', $viewer->id],
        ])->orderBy('created_at', 'DESC')->limit(count($channels))->get()->toArray();
        $allowStreams = array_map(function($item){
            return $item['streamer_id'];
        }, $allowStreams);
        foreach ($streamers as $streamer) {
            if (in_array($streamer->id, $allowStreams)) {
                $points += $this->calculatePoints($streamer->id);
            }
        }
        $viewer->addPoints([
            'points'    => $points,
            'title'     => 'Stream watching',
            'description'   => 'watching stream in Direct stream',
        ]);
        $viewer->save();
        $this->giveAfiliates();
        // 
        return response()->json([
            'data' => [
                'points'   => $viewer->level_points,
            ]
        ]);
    }

    public function streamInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channel'       => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $channel = $request->channel;
        $streamer = Streamer::where('name', $channel)->first();
        if (!$streamer) {
            return response()->json([
                'errors' => 'streamer not found',
            ]);
        }
        return response()->json([
            'data' => [
                'points'    => $this->calculatePoints($streamer->id),
                'viewers'   => $streamer->getOnlineViewers(),
            ]
        ]);
    }

    private function calculatePoints($streamerId)
    {
        $points = config('ospp.activity.level_points');
        $now = new Carbon;
        $now->subSeconds(config('ospp.activity.valid_pause'));
        $updateTime = $now->toDateTimeString();
        $tolalViewers = Activity::where([
            ['streamer_id', '=', $streamerId],
            ['updated_at', '>', $updateTime]
        ])->count();
        $subscribed = SubscribedStreamers::where([
            ['streamer_id', '=', $streamerId],
            ['valid_from', '<=', $updateTime],
            ['valid_until', '>=', $updateTime],
        ])->first();
        if ($subscribed) {
            $plan = SubscriptionPlan::find($subscribed->subscription_plan_id);
            $points += $plan->points;
            $bonusPoints = SubscriptionPoint::where('subscription_plan_id', $subscribed->subscription_plan_id)->get();
            foreach ($bonusPoints as $bonusPoint) {
                if ($bonusPoint->from_viewers >= $tolalViewers && $bonusPoint->to_viewers <= $tolalViewers) {
                    $points += $bonusPoint->points;
                }
            }
        }
        $promoted = PromoutedStreamer::where('streamer_id', $streamerId)->first();
        if ($promoted) {
            $points += $promoted->points;
        }
        return $points;
    }

    private function giveAfiliates()
    {
        $user = auth()->user();
        $afiliate = Afiliate::where('afiliate_id', $user->id)->whereNotNull('confirm_at')->first();
        if ($afiliate) {
            $userReferal = User::find($afiliate->user_id);
            $viewerReferal = $userReferal->viewer()->first();
            $viewerReferal->addPoints([
                'points'    => 1,
                'title'     => 'Referals',
                'description'   => 'Referal user watching streams',
            ]);
            $viewerReferal->save();
        }
    }

    private function checkViewerOnline($viewerId, $streamerId)
    {
        $now = new Carbon;
        $now->subSeconds(config('ospp.activity.valid_pause') - config('ospp.activity.period'));
        $minTime = $now->toDateTimeString();
        $now = new Carbon;
        $now->subSeconds(config('ospp.activity.period'));
        $maxTime = $now->toDateTimeString();
        return Activity::where([
            ['viewer_id',   '=', $viewerId],
            ['streamer_id', '=', $streamerId],
            ['updated_at',  '<=', $minTime],
            ['updated_at',  '>', $maxTime],
        ])->first();
    }

    private function newActivity($viewerId, $streamerId)
    {

        $activity = Activity::where([
            ['viewer_id', '=', $viewerId],
            ['streamer_id', '=', $streamerId],
        ])->first();
        if ($activity) {
            $now = new Carbon;
            $activity->updated_at = $now->toDateTimeString();
        } else {
            $activity = new Activity();
            $activity->viewer_id = $viewerId;
            $activity->streamer_id = $streamerId;
        }
        $activity->save();
    }

}

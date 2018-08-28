<?php

namespace App\Http\Controllers;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Models\{Streamer, User, ActiveStreamer, Activity, DailyWinner, Viewer, ViewerPrize, StockPrize, SubscribedStreamers, SubscriptionPlan};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WSController extends Controller implements MessageComponentInterface {

    private $clients = [];

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['onOpen', 'onClose', 'onMessage', 'onError']]);
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients[$conn->resourceId] = ['streamer_id' => null, 'viewer_id' => null];
        $data = [
            'action'    =>  'connected to WS...'
        ];
        $conn->send(json_encode($data));
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $msg = json_decode($msg, true);
        $this->clients[$from->resourceId]['role'] = $msg['role'];
        // viewer login
        if (is_null($this->clients[$from->resourceId]['streamer_id']) && $msg['role'] == 'streamer') {
            $streamer = Streamer::where('stream_token', $msg['token'])->first();
            if (!$streamer) {
                $data = [
                    'error'    =>  'wrong stream token'
                ];
                $from->send(json_encode($data));
                $from->close();
            } else {
                $this->clients[$from->resourceId]['streamer_id'] = $streamer->id;
                $data = [
                    'action'    =>  'started stream from ' . $streamer->name
                ];
                $from->send(json_encode($data));
                $active = ActiveStreamer::where('streamer_id', $streamer->id)->first();
                if (!$active) {
                    $active = new ActiveStreamer();
                    $active->streamer_id = $streamer->id;
                    $active->streamer_name = $streamer->name;
                    $active->save();
                }
            }
        }
        // streamer login
        if (is_null($this->clients[$from->resourceId]['viewer_id']) && $msg['role'] == 'viewer') {
            $user = auth()->setToken($msg['token'])->user();
            $viewer = $user->viewer()->first();
            $streams = $msg['streams'];
            foreach ($streams as $stream) {
                $streamer = Streamer::where('name', $stream)->first();
                $daily = DailyWinner::where([
                    ['viewer_id', '=', $viewer->id],
                    ['streamer_id', '=', $streamer->id],
                ])->first();
                if (!$daily) {
                    $daily = new DailyWinner();
                    $daily->viewer_id = $viewer->id;
                    $daily->streamer_id = $streamer->id;
                    $daily->save();
                }
                $activity = Activity::where([
                    ['viewer_id', '=', $viewer->id],
                    ['streamer_id', '=', $streamer->id],
                ])->first();
                if (!$activity) {
                    $activity = new Activity();
                    $activity->viewer_id = $viewer->id;
                    $activity->streamer_id = $streamer->id;
                    $activity->save();
                }
            }
            $this->clients[$from->resourceId]['viewer_id'] = $viewer->id;
            $this->clients[$from->resourceId]['streams'] = $msg['streams'];
        }
        // add points to viewer
        if (!is_null($this->clients[$from->resourceId]['viewer_id']) && isset($msg['action']) && $msg['action'] == 'add_points') {
            $activity = Activity::where([
                ['viewer_id', '=', $this->clients[$from->resourceId]['viewer_id']],
            ])->get();
            $viewer = Viewer::find($this->clients[$from->resourceId]['viewer_id']);
            $now = new Carbon;
            $updateTime = $now->toDateTimeString();
            $points = 0;
            foreach ($activity as $act) {
                $time = time() - strtotime($act->updated_at);
                $tolalViewers = Activity::where('streamer_id', $act->streamer_id)->count();
                if ($tolalViewers <= 100) {
                    $points = 100;
                } elseif ($tolalViewers <= 300) {
                    $points = 40;
                } elseif ($tolalViewers <= 500) {
                    $points = 20;
                }  elseif ($tolalViewers <= 1000) {
                    $points = 10;
                }  else {
                    $points = 11;
                }
                $subscribed = SubscribedStreamers::where([
                    ['streamer_id', '=', $act->streamer_id],
                    ['valid_from', '<=', $updateTime],
                    ['valid_until', '>=', $updateTime],
                ])->first();
                if ($subscribed) {
                    $plan = SubscriptionPlan::find($subscribed->subscription_plan_id);
                    if ($plan->name == 'basic') {
                        $points += 10;
                    } elseif ($plan->name == 'advanced') {
                        $points += 100;
                    } elseif ($plan->name == 'golden') {
                        $points += 1000;
                    }
                }
                if ($time >= 60 - 5) {
                    $viewer->level_points =  $viewer->level_points + $points;
                    $viewer->current_points =  $viewer->current_points + $points;
                    $viewer->save();
                }
                $act->updated_at = $updateTime;
                $act->save();
                $data = [
                    'points' => $points
                ];
                $from->send(json_encode($data));
            }
        }
        // check win prize
        if (!is_null($this->clients[$from->resourceId]['streamer_id']) && isset($msg['action']) && $msg['action'] == 'check') {
            $now = new Carbon;
            $now->subSeconds(env("WS_STREAM_ALERT_PERIOD") - 3);
            // $updateTime = $now->timestamp;
            $updateTime = $now->toDateTimeString();
            $viewerPrize = ViewerPrize::where('created_at', '>', $updateTime)->orderBy('created_at', 'desc')->first();
            $data = [
                'update time ' => $updateTime
            ];
            $from->send(json_encode($data));
            if ($viewerPrize) {
                $viewer = Viewer::find($viewerPrize->viewer_id);
                $prize = StockPrize::find($viewerPrize->prize_id);
                $alert = [
                    'viewer'    => $viewer->name,
                    'prize'     => $prize->name,
                    'image'     => $prize->image,
                    'action'    => 'win',
                ];
                $from->send(json_encode($alert));
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        if (!is_null($this->clients[$conn->resourceId]['streamer_id']) && $this->clients[$conn->resourceId]['role'] == 'streamer') {
            $active = ActiveStreamer::where('streamer_id', $this->clients[$conn->resourceId]['streamer_id'])->first();
            $active->delete();
            unset($this->clients[$conn->resourceId]);
        }
        if (!is_null($this->clients[$conn->resourceId]['viewer_id']) && $this->clients[$conn->resourceId]['role'] == 'viewer') {
            $streams = $this->clients[$conn->resourceId]['streams'];
            foreach ($streams as $stream) {
                $streamer = Streamer::where('name', $stream)->first();
                Activity::where([
                    ['viewer_id', '=', $this->clients[$conn->resourceId]['viewer_id']],
                    ['streamer_id', '=', $streamer->id],
                ])->delete();
            }
            unset($this->clients[$conn->resourceId]);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        \Log::info($e->getMessage());
    }

}
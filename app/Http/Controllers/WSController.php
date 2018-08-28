<?php

namespace App\Http\Controllers;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Models\{Streamer, User, ActiveStreamer, Activity, DailyWinner, Viewer, ViewerPrize, StockPrize};
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
        // $conn->send('connected to WS...');
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $msg = json_decode($msg, true);
        $this->clients[$from->resourceId]['role'] = $msg['role'];
        // viewer login
        if (is_null($this->clients[$from->resourceId]['streamer_id']) && $msg['role'] == 'streamer') {
            $streamer = Streamer::where('stream_token', $msg['token'])->first();
            if (!$streamer) {
                $from->send('wrong stream token');
                $from->close();
            } else {
                $this->clients[$from->resourceId]['streamer_id'] = $streamer->id;
                // $from->send('started stream from ' . $streamer->name);
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
            foreach ($activity as $act) {
                $time = time() - strtotime($act->updated_at);
                if ($time >= 10 * 60 - 5) {
                    $viewer->level_points =  $viewer->level_points + 10;
                    $viewer->current_points =  $viewer->current_points + 10;
                    $viewer->save();
                }
                $act->updated_at = $updateTime;
                $act->save();
            }
        }
        // check win prize
        if (!is_null($this->clients[$from->resourceId]['streamer_id']) && isset($msg['action']) && $msg['action'] == 'check') {
            $now = new Carbon;
            $now->subSeconds(env("WS_STREAM_ALERT_PERIOD") - 3);
            // $updateTime = $now->timestamp;
            $updateTime = $now->toDateTimeString();
            $viewerPrize = ViewerPrize::where('created_at', '>', $updateTime)->orderBy('created_at', 'desc')->first();
            // $from->send('update time ' . $updateTime);
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
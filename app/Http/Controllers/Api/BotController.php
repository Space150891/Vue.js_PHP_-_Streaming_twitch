<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;

use App\Models\{User, Activity, Viewer, Streamer, ActiveStreamer};

class BotController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getEvent', 'activeChannels']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEvent(Request $request)
    {
        $botSecret = config('ospp.bot.secret_key');
        $validator = Validator::make($request->all(), [
            'secretKey' => 'required|min:1|max:256',
            'type'      => 'required|min:1|max:256',
            'viewers'   => 'required',
            'channel'   => 'required|min:1|max:256',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        if ($request->secretKey !== $botSecret) {
            return response()->json([
                'errors' => ['secret key is wrong'],
            ]);
        }
        $streamer = Streamer::where('name', $request->channel)->first();
        if ($request->secretKey !== $botSecret) {
            return response()->json([
                'errors' => ['channel name not found'],
            ]);
        }
        $validPause = config('ospp.activity.valid_pause');
        $now = new Carbon();
        $now->subSeconds($validPause);
        $time = $now->toDateTimeString();
        $activity = Activity::where([
            ['updated_at', '>', $time],
            ['streamer_id', '=', $streamer->id]
        ])->get();
        $viewers = [];
        foreach ($activity as $active) {
            $viewer = Viewer::find($active->viewer_id);
            $viewers[] = $viewer->name;
        }
        $data = [
            'viewers'   => $viewers,
            'channel'   => $request->channel,
        ];
        return response()->json([
            'data' => $data,
        ]);
    }

    public function activeChannels(Request $request)
    {
        $botSecret = config('ospp.bot.secret_key');
        $validator = Validator::make($request->all(), [
            'secretKey' => 'required|min:1|max:256',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        if ($request->secretKey !== $botSecret) {
            return response()->json([
                'errors' => ['secret key is wrong'],
            ]);
        }
        $activs = ActiveStreamer::all();
        $data = [];
        foreach ($activs as $active) {
            if (!in_array($active->streamer_name, $data)) {
                $data[] = $active->streamer_name;
            }
        }
        return response()->json([
            'data' => [
                'streams'   =>  $data,
            ],
        ]);
    }
 
}

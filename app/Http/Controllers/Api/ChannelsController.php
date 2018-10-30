<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{Channel, Streamer, Activity};

class ChannelsController extends Controller
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
        $streamer = $user->streamer()->first();
        $channels = Channel::where('streamer_id', $streamer->id)->get();
        return response()->json(['data' => [
            'channels' => $channels,
        ]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'name'                  => 'required|max:255',
                'twitch_id'             => 'required|numeric|min:1'
            ],
            [
                'name.required'       => 'channel name required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }

        $user = auth()->user();
        $streamer = $user->streamer()->first();

        $channel = Channel::create([
            'name'             => $request->input('name'),
            'streamer_id'      => $streamer->id,
        ]);

        $channel->save();
        
        return response()->json([
            'message' => 'new channel created successful',
            'data' => [
                'id' => $channel->id,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $channel = Channel::find($id);
        if (!$channel) {
            return response()->json([
                'errors' => ['channel did not find'],
            ]);
        }
        $data = [
            'id'          => $channel->id,
            'name'        => $channel->name,
            'twitch_id'   => $channel->name,
            'created_at'  => $channel->created_at,
            'updated_at'  => $channel->updated_at,
        ];
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required',
            'name'     => 'required|max:255|unique:users',
            'twitch_id'             => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $id = $request->id;
        $channel = Channel::find($id);
        if (!$channel) {
            return response()->json([
                'errors' => ['channel did not find'],
            ]);
        }
        
        return response()->json([
            'message' => 'channel update successful',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $id = $request->id;
        $channel = Channel::find($id);
        if (!$channel) {
            return response()->json([
                'errors' => ['channel did not find'],
            ]);
        }

        $channel->delete();
        return response()->json([
            'message' => 'channel delete successful',
        ]);
        
    }

    public function randomChannels(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total'       => 'required|in:1,2,4',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $channels = [];
        $need = $request->total;
        //
        $selected = [];
        $groups = [];
        $allStreamers = Streamer::query()
        ->select('streamers.name', 'streamers.id', 'activities.viewer_id')
        ->Leftjoin('activities', 'activities.streamer_id', '=', 'streamers.id')
        ->get();
        $StreamersSums = [];
        foreach ($allStreamers as $streamer) {
            if (isset($StreamersSums[$streamer->name])) {
                if ($streamer->viewer_id > 0) {
                    $StreamersSums[$streamer->name]++;
                }
            } else {
                if ($streamer->viewer_id > 0) {
                    $StreamersSums[$streamer->name] = 1;
                } else {
                    $StreamersSums[$streamer->name] = 0;
                }
                
            }
        }
        foreach ($StreamersSums as $k => $v) {
            if (isset($groups[$v])) {
                $groups[$v][] = $k;
            } else {
                $groups[$v] = [$k];
            }
        }
        $channels = [];
        ksort($groups);
        foreach ($groups as $k => $group) {
            $needMore = $need - count($channels);
            if ($needMore === 0) {
                break;
            }
            if (count($group) <= $needMore) {
                $channels = array_merge($channels, $group);
            } else {
                do {
                    $num = round(rand(0, count($group) - 1));
                    if (!in_array($group[$num], $channels)) {
                        $channels[] = $group[$num];
                    }
                } while ($need - count($channels) > 0);
            }
        }

        return response()->json([
            'data' => [
                'channels'  => $channels,
            ],
        ]);
    }
 
}

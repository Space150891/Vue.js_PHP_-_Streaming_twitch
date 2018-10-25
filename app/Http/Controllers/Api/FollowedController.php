<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{
    ActiveStreamer,
    Streamer,
    SignedViewer,
    User,
    Viewer
};

class FollowedController extends Controller
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $followedUser = User::where('name', $request->name)->first();
        if (!$followedUser) {
            return response()->json([
                'errors' => ['user not found'],
            ]);
        }
        $followedStreamer = $followedUser->streamer()->first();
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $already = SignedViewer::where([
            ['viewer_id', '=', $viewer->id],
            ['streamer_id', '=', $followedStreamer->id],
        ])->first();
        if ($already) {
            return response()->json([
                'message' => 'user already in followings',
            ]);
        }
        $signed = new SignedViewer();
        $signed->viewer_id = $viewer->id;
        $signed->streamer_id = $followedStreamer->id;
        $signed->save();
        return response()->json([
            'message' => 'successful add user to followings',
        ]);
    }

    public function get(Request $request)
    {
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $followed = SignedViewer::where('viewer_id', $viewer->id)->get();
        $online = [];
        $offline = [];
        foreach ($followed as $f) {
            $streamer = Streamer::find($f->streamer_id);
            $isActive = ActiveStreamer::where('streamer_id', $streamer->id)->first();
            if ($isActive) {
                $online[] = [
                    'id'       =>  $streamer->id,
                    'name'     =>  $streamer->name,
                    'game'     =>  $streamer->game,
                    'viewers'  =>  $streamer->getOnlineViewers(),
                ];
            } else {
                $offline[] = [
                    'id'       =>  $streamer->id,
                    'game'     =>  $streamer->game,
                    'name'     =>  $streamer->name,
                ];
            }
        }
        return response()->json(['data' => [
            'online' => $online,
            'offline' => $offline,
        ]]);

    }

    
    
}

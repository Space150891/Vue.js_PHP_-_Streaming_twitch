<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{PromoutedStreamer, Streamer, User};

class PromotedStreamersManagementController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['list']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }


    public function show(Request $request)
    {
        return response()->json([
            'data' => PromoutedStreamer::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'id'   => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        if (!Streamer::find($request->id)) {
            return response()->json([
                'errors' => ['streamer id not found'],
            ]);
        }
        if (PromoutedStreamer::where('streamer_id', $request->id)->first()) {
            return response()->json([
                'errors' => ['this streamer already promoted'],
            ]);
        }
        $promotedStreamer = new  PromoutedStreamer();
        $promotedStreamer->streamer_id = $request->id;
        $promotedStreamer->save();
        return response()->json([
            'message' => ['successful added streamer to promoted streamers'],
        ]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'id'   => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $promotedStreamer = PromoutedStreamer::find($request->id);
        if (!$promotedStreamer) {
            return response()->json([
                'errors' => ['this streamer not promoted' . $request->id],
            ]);
        }
        $promotedStreamer->delete();
        return response()->json([
            'message' => ['successful deleted streamer from promoted streamers'],
        ]);
    }

    public function list(Request $request)
    {
        $promoted = PromoutedStreamer::all();
        for ($i = 0; $i < count($promoted); $i++) {
            $streamer = $promoted[$i]->streamer()->first();
            $user= $streamer->user()->first();
            // $promoted[$i]->avatar = $user->avatar;
            $promoted[$i]->avatar = $streamer->avatar;
            $promoted[$i]->user_id = $user->id;
            $promoted[$i]->name = $streamer->name;
            $promoted[$i]->nikname = $user->first_name;
            $promoted[$i]->streamer_id = $streamer->id;
            $promoted[$i]->twitch_id = $streamer->twitch_id;
        }
        return response()->json([
            'data' => [
                'promoted' => $promoted,
            ],
        ]);
    }
 
}

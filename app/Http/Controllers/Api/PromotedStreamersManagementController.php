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
                'errors' => $validator->errors()->all(),
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
        $maxPosition = PromoutedStreamer::max('position');
        $promotedStreamer = new  PromoutedStreamer();
        $promotedStreamer->streamer_id = $request->id;
        $promotedStreamer->position = $maxPosition + 1;
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
                'errors' => $validator->errors()->all(),
            ]);
        }
        $promotedStreamer = PromoutedStreamer::find($request->id);
        if (!$promotedStreamer) {
            return response()->json([
                'errors' => ['this streamer not promoted' . $request->id],
            ]);
        }
        $deletingPosition = $promotedStreamer->position;
        $promotedStreamer->delete();
        $maxPosition = PromoutedStreamer::max('position');
        if ($deletingPosition < $maxPosition) {
            $downStreamers = PromoutedStreamer::where('position', '>', $deletingPosition)->get();
            for ($i = 0; $i < count($downStreamers); $i++) {
                $downStreamers[$i]->position = $downStreamers[$i]->position - 1;
                $downStreamers[$i]->save();
            }
        }
        return response()->json([
            'message' => ['successful deleted streamer from promoted streamers'],
        ]);
    }

    public function list(Request $request)
    {
        $promoted = PromoutedStreamer::orderBy('position', 'asc')->get();
        for ($i = 0; $i < count($promoted); $i++) {
            $streamer = $promoted[$i]->streamer()->first();
            $user= $streamer->user()->first();
            $promoted[$i]->avatar = $user->avatar;
            $promoted[$i]->user_id = $user->id;
            $promoted[$i]->name = $streamer->name;
            $promoted[$i]->game = $streamer->game;
            $promoted[$i]->nikname = $user->first_name;
            $promoted[$i]->streamer_id = $streamer->id;
            $promoted[$i]->twitch_id = $streamer->twitch_id;
            $promoted[$i]->viewers = $streamer->getOnlineViewers();
        }
        return response()->json([
            'data' => [
                'promoted' => $promoted,
            ],
        ]);
    }

    public function up(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'id'   => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $promotedStreamer = PromoutedStreamer::find($request->id);
        if (!$promotedStreamer) {
            return response()->json([
                'errors' => ['this streamer not promoted' . $request->id],
            ]);
        }
        $switchStreamer = PromoutedStreamer::where('position', $promotedStreamer->position - 1)->first();
        if ($switchStreamer) {
            $promotedStreamer->position = $promotedStreamer->position - 1;
            $switchStreamer->position = $switchStreamer->position + 1;
            $promotedStreamer->save();
            $switchStreamer->save();
        }
        return response()->json([
            'message' => ['successful up streamer in promoted streamers list'],
        ]);
    }

    public function down(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'id'   => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $promotedStreamer = PromoutedStreamer::find($request->id);
        if (!$promotedStreamer) {
            return response()->json([
                'errors' => ['this streamer not promoted' . $request->id],
            ]);
        }
        $switchStreamer = PromoutedStreamer::where('position', $promotedStreamer->position + 1)->first();
        if ($switchStreamer) {
            $promotedStreamer->position = $promotedStreamer->position + 1;
            $switchStreamer->position = $switchStreamer->position - 1;
            $promotedStreamer->save();
            $switchStreamer->save();
        }
        return response()->json([
            'message' => ['successful up streamer in promoted streamers list'],
        ]);
    }
 
}

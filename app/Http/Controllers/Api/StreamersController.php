<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\Streamer;
use App\Models\User;

class StreamersController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getListByGame']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) //// 
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $id = $request->id;
        $streamer = Streamer::find($id);

        if (!$streamer) {
            return response()->json([
                'errors' => ['streamer id not found'],
            ]);
        }
        $streamer->user = $streamer->user()->first();
        $contacts = $streamer->contacts()->get();
        for ($i = 0; $i < count($contacts); $i++) {
            $type = $contacts[$i]->type()->first();
            $contacts[$i]->type = $type['name'];
        }
        $streamer->contacts = $contacts;
        return response()->json([
            'data' => $streamer,
        ]);
    }

    public function list(Request $request)
    {
        $streamers = Streamer::all();
        return response()->json([
            'data' => [
                'streamers' => $streamers,
            ],
        ]);
    }

    public function current(Request $request)
    {
        $user = auth()->user();
        $streamer = $user->streamer()->first();
        return response()->json([
            'data' => [
                'id'    => $streamer->id,
            ],
        ]);
    }

    public function getListByGame(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_name'       => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $streamers = Streamer::where('game', strtolower($request->game_name))->get();
        return response()->json([
            'data' => [
                'streamers' => $streamers,
            ],
        ]);

    }
 
}

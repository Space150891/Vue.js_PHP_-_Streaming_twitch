<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\ReferalStreamer;
use App\Models\Streamer;
use App\Models\User;

class ReferalStreamersController extends Controller
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

    public function me(Request $request) // information about current user viewer
    {
        $user = auth()->user();
        $streamer = $user->streamer()->first();
        $referals = $streamer->referals()->get();
        $list = [];
        for ($i=0; $i < count($referals); $i++) { 
            $user = $referals[$i]->user()->first();
            $list[] = [
                'name'          => $user['name'],
                'created_at'    => (string)$referals[$i]->created_at,
            ];
        }
        return response()->json([
            'data' => [
                'list'  => $list,
                'sum'   => count($referals),
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
    public function show(Request $request) // show some viewer referal
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $streamer = Streamer::find($request->id);
        if (!$streamer) {
            return response()->json([
                'errors' => ['streamer id not found'],
            ]);
        }
        
        $referals = $streamer->referals()->get();
        $list = [];
        for ($i=0; $i < count($referals); $i++) {
            $user = $referals[$i]->user()->first();
            $list[] = [
                'name'          => $user['name'],
                'created_at'    => (string)$referals[$i]->created_at,
            ];
        }
        return response()->json([
            'data' => [
                'list'  => $list,
                'sum'   => count($referals),
            ]
        ]);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $viewer = Streamer::find($request->id);
        if (!$viewer) {
            return response()->json([
                'errors' => ['streamer id not found'],
            ]);
        }
        $user = auth()->user();
        $userStreamer = $user->streamer->first();
        if ($userStreamer->id == $request->id) {
            return response()->json([
                'errors' => ['can not refering yourself'],
            ]);
        }
        if (ReferalStreamer::where([
                ['user_id', '=', $user->id],
                ['streamer_id', '=', $request->id],
            ])->first()) {
                return response()->json([
                    'errors' => ['you already refered this streamer'],
                ]);
        }
        ReferalStreamer::create([
            'streamer_id' => $request->id,
            'user_id'   => $user->id,
        ]);
        return response()->json([
            'message' => 'referals added',
        ]);
    }
 
}

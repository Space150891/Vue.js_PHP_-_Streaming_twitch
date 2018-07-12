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
    public function show(Request $request) //// 
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
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
 
}

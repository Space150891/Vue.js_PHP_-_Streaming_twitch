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
                    'viewers'  =>  $streamer->getOnlineViewers(),
                ];
            } else {
                $offline[] = [
                    'id'       =>  $streamer->id,
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

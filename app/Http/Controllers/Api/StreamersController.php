<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{Streamer, User, PromoutedStreamer};

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
            'name'       => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $streamer = Streamer::where('name', $request->name)->first();

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

    public function pagination(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page'       => 'required|numeric|min:1',
            'on_page'       => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $total = Streamer::count();
        $pages = ceil($total / $request->on_page);
        // $streamers = Streamer::skip(($request->page - 1) * $request->on_page)->take($request->on_page)->get();
        $streamers = Streamer::select('streamers.id', 'streamers.name', 'streamers.game', 'streamers.twitch_id', 'promouted_streamers.streamer_id', 'promouted_streamers.id as promoted_id')
                            ->leftJoin('promouted_streamers', 'promouted_streamers.streamer_id', '=', 'streamers.id')
                            ->orderBy('streamers.id')
                            ->skip(($request->page - 1) * $request->on_page)
                            ->take($request->on_page)->get();
        return response()->json([
            'data' => [
                'streamers' => $streamers,
                'pages'     => $pages,
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
        for ($i = 0; $i < count($streamers); $i++) {
            $user = $streamers[$i]->user()->first();
            $streamers[$i]->avatar = $user->avatar;
        }
        return response()->json([
            'data' => [
                'streamers' => $streamers,
            ],
        ]);

    }
 
}

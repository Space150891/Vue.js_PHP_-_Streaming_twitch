<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{User, Viewer, Streamer, SignedViewer};
use App\Achievements\{FirstStreamerSubscribeAchievement, Streamer100SubscribeAchievement};

class SignedViewersController extends Controller
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
                'name'   =>  'required|min:1',
            ]
        );
        $user = auth()->user();
        $viewer = $user->viewer()->first();

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

        $hasStreamer = SignedViewer::where([
            ['viewer_id', '=', $viewer->id],
            ['streamer_id', '=', $streamer->id],
        ])->first();
        
        if ($hasStreamer) {
            return response()->json([
                'errors' => ['streamer already added'],
            ]);
        }

        $signedViewer = new SignedViewer();
        $signedViewer->viewer_id = $viewer->id;
        $signedViewer->streamer_id = $streamer->id;
        $signedViewer->save();
        $user->addProgress(new FirstStreamerSubscribeAchievement(), 1);
        $user->addProgress(new Streamer100SubscribeAchievement(), 1);
        return response()->json([
            'message' => 'streamer added successful',
            'data' => [
                'id' => $signedViewer->id,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myViewersList(Request $request)
    {
        $user = auth()->user();
        $streamer = $user->streamer()->first();

        $viewers = SignedViewer::query()
                            ->select('signed_viewers.id', 'viewers.name', 'signed_viewers.viewer_id', 'viewers.user_id')
                            ->where('signed_viewers.streamer_id', '=', $streamer->id)
                            ->join('viewers', 'viewers.id', '=', 'signed_viewers.viewer_id')
                            ->get();

        return response()->json([
            'data' => [
                'viewers'   => $viewers,
            ],
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myStreamersList(Request $request)
    {
        $user = auth()->user();
        $viewer = $user->viewer()->first();

        $streamers = SignedViewer::query()
                            ->select('signed_viewers.id', 'streamers.name', 'signed_viewers.streamer_id', 'streamers.user_id')
                            ->where('signed_viewers.viewer_id', '=', $viewer->id)
                            ->join('streamers', 'streamers.id', '=', 'signed_viewers.streamer_id')
                            ->get();

        return response()->json([
            'data' => [
                'streamers'   => $streamers,
            ],
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
                'errors' => $validator->errors(),
            ]);
        }
        \Log::info('delete id=' . $request->id);
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $signedViewer = SignedViewer::where([
            ['viewer_id', '=', $viewer->id],
            ['streamer_id', '=', $request->id],
        ])->first();

        if (!$signedViewer) {
            return response()->json([
                'errors' => ['You are not signed on this streamer'],
            ]);
        }
        $signedViewer->delete();
        return response()->json([
            'message' => 'streamer removed from sign list',
        ]);
    }
}

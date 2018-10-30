<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\Models\{Activity, ActiveStreamer, Streamer, User, PromoutedStreamer};

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
                'errors' => $validator->errors()->all(),
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
                'errors' => $validator->errors()->all(),
            ]);
        }
        $total = Streamer::count();
        $pages = ceil($total / $request->on_page);
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
                'id'            => $streamer->id,
                'user_id'       => $user->id,
                'donate_front'  => $streamer->donate_front,
                'donate_back'   => $streamer->donate_back,
                'donate_text'   => $streamer->donate_text,
                'paypal'        => $streamer->paypal,
                'avatar'        => $user->avatar,
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
                'errors' => $validator->errors()->all(),
            ]);
        }
        $streamers = Streamer::where('game', $request->game_name)->get();
        $onlineStreamers = [];
        foreach ($streamers as $streamer) {
            $now = new Carbon;
            $now->subSeconds(config('ospp.activity.valid_pause'));
            $updateTime = $now->toDateTimeString();
            $active = ActiveStreamer::where([
                ['streamer_id', '=', $streamer->id],
                // ['updated_at', '>', $updateTime],
            ])->first();
            $active = env('TEST_MODE') ? true : $active;
            if ($active) {
                $online = $streamer;
                $user = $streamer->user()->first();
                $online->avatar = $user->avatar;
                $online->viewers_count = $streamer->getOnlineViewers();
                $online->points = $streamer->calculatePoints();
                $onlineStreamers[] = $online;
            }
        }
        return response()->json([
            'data' => [
                'streamers' => $onlineStreamers,
            ],
        ]);

    }

    public function saveCustomDonatePage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'donate_text'       => 'required',
            'paypal'            => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $user = auth()->user();
        $streamer = $user->streamer()->first();
        $streamer->donate_text = $request->donate_text;
        $streamer->paypal = $request->paypal;
        $streamer->save();
        return response()->json([
            'message' => 'donate page settings updated',
        ]);
    }

    public function uploadDonateImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'       => 'string|in:front,back',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        if (!$request->hasFile('image')) {
            return response()->json([
                'errors' => ['there is not image file'],
            ]);
        }
        $user = auth()->user();
        $streamer = $user->streamer()->first();
        $file = $request->file('image');
        $extention = strtolower($file->extension());
        $destination = 'public/donations';
        $fileName = $this->generateFileName($destination, $extention);
        Storage::putFileAs($destination, $file, $fileName);
        $savedName = 'donations/' . $fileName;
        if ($request->type == 'back') {
            $this->deleteFile($streamer->donate_back);
            $streamer->donate_back = $savedName;
        } else {
            $this->deleteFile($streamer->donate_front);
            $streamer->donate_front = $savedName;
        }
        $streamer->save();
        return response()->json([
            'data' => [
                'file'  =>  $savedName,
            ],
        ]);
    }

    public function saveSeToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'se_token'       => 'required|min:150',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $user = auth()->user();
        $streamer = $user->streamer()->first();
        $streamer->streamelements_access = $request->se_token;
        $streamer->save();
        return response()->json([
            'message' => 'streamelements token saved',
        ]);
    }

    private function deleteFile($path) {
        if (!empty($path)) {
            Storage::delete('public/' . $path);
        }
    }
 
    private function generateFileName($path, $ext) {
        do {
            $name = 'image_' . uniqid() . '_' . $ext;
        } while(Storage::exists($path . '/' . $name));
        return $name;
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;
use GuzzleHttp\Client as Guzzle;

use App\Models\{Viewer, User, Notification, Card, Item, ViewerItem, HistoryPoint, SignedViewer, Streamer};

class ViewersController extends Controller
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
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $id = $request->id;
        $viewer = Viewer::find($id);

        if (!$viewer) {
            return response()->json([
                'errors' => ['viewer id not found'],
            ]);
        }
        $viewer->user = $viewer->user()->first();
        return response()->json([
            'data' => $viewer,
        ]);
    }

    public function current(Request $request)
    {
        $now = new Carbon();
        $time = $now->toDateTimeString();
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $currentStreamer = $user->streamer()->first();
        $notications = Notification::where([
            ['user_id', '=', $user->id],
            ['event_type', '=', 'user_message'],
        ])->whereNull('view_at')->get();
        $messages = [];
        foreach ($notications as $notification) {
            $messages[] = $notification->message;
            $notification->view_at = $time;
            $notification->save();
        }
        $card = false;
        $now = new Carbon;
        $now->subSeconds(60);
        $updateTime = $now->toDateTimeString();
        $historyPoints = HistoryPoint::where('viewer_id', $viewer->id)->where('created_at', '>', $updateTime)->get();
        $lastPoints = (integer)HistoryPoint::where('viewer_id', $viewer->id)->where('created_at', '>', $updateTime)->sum('points');
        $following = SignedViewer::where('viewer_id', $viewer->id)->get();
        foreach ($following as &$followed) {
            $followingStreamer = Streamer::find($followed->streamer_id);
            $followingUser = $followingStreamer->user()->first();
            $followed->name = $followingStreamer->name;
            $followed->avatar = $followingUser->avatar;
            $followed->subscription = $followingUser->isSubscribed();
        }
        $followers = SignedViewer::where('streamer_id', $currentStreamer->id)->get();
        foreach ($followers as &$follow) {
            $followViewer = Viewer::find($follow->viewer_id);
            $followUser = $followViewer->user()->first();
            $follow->name = $followViewer->name;
            $follow->avatar = $followUser->avatar;
            $follow->subscription = $followUser->isSubscribed();
        }
        return response()->json([
            'data' => [
                'name'              => $viewer->name,
                'bio'               => $user->bio,
                'points'            => $viewer->current_points,
                'diamonds'          => $viewer->diamonds,
                'level'             => $viewer->getLevel(),
                'messages'          => $messages,
                'card'              => $card,
                'user_id'           => $user->id,
                'history_points'    => $historyPoints,
                'last_points'       => $lastPoints,
                'contacts'  => [
                    'country_id'        => $viewer->country_id,
                    'city'              => $viewer->city,
                    'zip_code'          => $viewer->zip_code,
                    'local_address'     => $viewer->local_address,
                    'full_name'         => $viewer->full_name,
                    'adress_details'    => $viewer->adress_details,
                    'state'             => $viewer->state,
                    'phone'             => $viewer->phone,
                    'verified'          => $viewer->phone_verified == 1 ? true : false,
                ],
                'social'    => [
                    'twitch'   =>  $viewer->social_twitch,
                    'twitter'   =>  $viewer->social_twitter,
                    'instagram'   =>  $viewer->social_instagram,
                    'youtube'   =>  $viewer->social_youtube,
                ],
                'following' => $following,
                'follower' => $followers,
                'back'      => $currentStreamer->donate_back,
            ],
        ]);
    }

    public function redeem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'captcha'       => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        //
        $client = new Guzzle();
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params'=>
                [
                    'secret'    =>  env('GOOGLE_RECAPTCHA_SECRET'),
                    'response'  =>  $request->captcha,
                 ]
            ]
        );
    
        $body = json_decode((string)$response->getBody());
        //
        if (!$body->success) {
            return response()->json([
                'errors' => ['recaptcha error'],
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $viewer->addPoints([
            'points'    => 10,
            'title'     => 'Stream',
            'description'   => 'watching roulette',
        ]);
        $viewer->save();
        return response()->json([
            'message' => 'points redeemed',
        ]);
    }

    public function updateViewerContacts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $viewer->name = $request->name;
        $viewer->local_address = $request->local_address;
        $viewer->adress_details = $request->adress_details;
        $viewer->full_name = $request->full_name;
        $viewer->city = $request->city;
        $viewer->zip_code = $request->zip_code;
        $viewer->phone = $request->phone;
        $viewer->state = $request->state;
        $viewer->country_id = $request->country_id;
        if ($request->has('social_twitch') && preg_match('/\/twitch.tv\/.{0,100}/', $request->social_twitch) === 1) {
            $viewer->social_twitch = $request->social_twitch;
        }
        if ($request->has('social_twitter') && preg_match('/\/twitter.com\/.{0,100}/', $request->social_twitter) === 1) {
            $viewer->social_twitter = $request->social_twitter;
        }
        if ($request->has('social_instagram') && preg_match('/\/instagram.com\/.{0,100}/', $request->social_instagram) === 1) {
            $viewer->social_instagram = $request->social_instagram;
        }
        if ($request->has('social_youtube') && preg_match('/\/youtube.com\/user\/.{0,100}/', $request->social_youtube) === 1) {
            $viewer->social_youtube = $request->social_youtube;
        }
        $viewer->save();
        return response()->json([
            'message' => 'viewer contact updated',
        ]);
    }
 
}

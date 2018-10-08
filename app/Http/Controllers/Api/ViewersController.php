<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;
use GuzzleHttp\Client as Guzzle;

use App\Models\{Viewer, User, Notification, Card, Item, ViewerItem, HistoryPoint};

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
                'errors' => $validator->errors(),
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
        return response()->json([
            'data' => [
                'name'      => $viewer->name,
                'points'    => $viewer->current_points,
                'diamonds'  => $viewer->diamonds,
                'level'     => $viewer->getLevel(),
                'messages'  => $messages,
                'card'      => $card,
                'user_id'   => $user->id,
                'history_points' => $historyPoints,
                'last_points' => $lastPoints,
                'contacts'  => [
                    'country'       => $viewer->country,
                    'city'          => $viewer->city,
                    'zip_code'      => $viewer->zip_code,
                    'local_address' => $viewer->local_address,
                ],
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
                'errors' => $validator->errors(),
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
                'error' => 'recaptcha error',
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
            'country'       => 'required|min:1',
            'city'          => 'required|min:1',
            'zip_code'      => 'required|min:1',
            'local_address' => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $viewer->country = $request->country;
        $viewer->city = $request->city;
        $viewer->zip_code = $request->zip_code;
        $viewer->local_address = $request->local_address;
        $viewer->save();
        return response()->json([
            'message' => 'viewer contact updated',
        ]);
    }
 
}

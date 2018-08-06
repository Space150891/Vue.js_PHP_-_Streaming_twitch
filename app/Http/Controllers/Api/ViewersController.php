<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;

use App\Models\{Viewer, User, Notification, Card, Item};

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
        if ($viewer->promoted_gamecard_id) {
            $currentCard = Card::find($viewer->promoted_gamecard_id);
            $card = new \stdClass();
            $card->id = $currentCard->id;
            $frame = Item::find($currentCard->frame_id);
            $card->frame = $frame->image;
            $hero = Item::find($currentCard->hero_id);
            $card->hero = $hero->image;
            $achievement = \DB::table('achievement_details')->find($currentCard->achivement_id);
            $card->achievement = $achievement->description;
        }
        return response()->json([
            'data' => [
                'name'      => $viewer->name,
                'points'    => $viewer->current_points,
                'diamonds'  => $viewer->diamonds,
                'level'     => $viewer->getLevel(),
                'messages'  => $messages,
                'card'      => $card,
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
        \Log::info('captcha=' . $request->captcha);
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $viewer->current_points = $viewer->current_points >10 ? $viewer->current_points - 10 : 0;
        $viewer->save();
        return response()->json([
            'message' => 'points redeemed',
        ]);
    }
 
}

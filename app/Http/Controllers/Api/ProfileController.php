<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{User, Card, Item, ViewerPrize, StockPrize, ViewerItem};

class ProfileController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['get']]);
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
        $validator = Validator::make($request->all(), [
            'name'       => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = User::where('name', $request->name)->first();
        if (!$user) {
            return response()->json([
                'errors' => ['user id not found'],
            ]);
        }
        $streamer = $user->streamer()->first();
        $viewer = $user->viewer()->first();
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
                'streamer_id' => $streamer->id,
                'avatar'    =>  $user->avatar,
                'username'  => $user->first_name ? $user->first_name :  $user->name,
                'nikname'   => $user->name,
                'bio'       => $user->bio,
                'email'     => '',
                'paypal'    => $streamer->paypal,
                'card'      => $card,
            ],
        ]);
    }

    public function getCurrent(Request $request)
    {
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $card = false;
        if ($viewer->promoted_gamecard_id) {
            $currentCard = Card::find($viewer->promoted_gamecard_id);
            $card = new \stdClass();
            $card->id = $currentCard->id;
            $viewerFrame = ViewerItem::find($currentCard->frame_id);
            $frame = Item::find($viewerFrame->item_id);
            $card->frame = $frame->image;
            $viewerHero = ViewerItem::find($currentCard->hero_id);
            $hero = Item::find($viewerHero->item_id);
            $card->hero = $hero->image;
            $achievement = \DB::table('achievement_details')->find($currentCard->achivement_id);
            $card->achievement = $achievement->description;
        }
        $dataPrizes = [];
        $viewerPrizes = ViewerPrize::where('viewer_id', $viewer->id)->get();
        foreach ($viewerPrizes as $viewerPrize) {
            $prize = $viewerPrize->prize()->first();
            $prize->id = $viewerPrize->id;
            $dataPrizes[] = $prize;
        }
        return response()->json([
            'data' => [
                'id'        => $user->id,
                'avatar'    =>  $user->avatar,
                'username'  =>  $user->first_name,
                'nikname'   => $user->name,
                'bio'       => $user->bio,
                'email'     => $user->email,
                'paypal'    => '',
                'card'      => $card,
                'verified'  => $viewer->phone_verified ? true : false,
                'phone'     => $viewer->phone ? $viewer->phone : '',
                'prizes'    => $dataPrizes,
            ],
        ]);
    }
 
}

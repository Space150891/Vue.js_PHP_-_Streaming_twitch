<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{Viewer, Item, Card, CardItem, ViewerItem, CustomAchievement, Achievement};

class CardsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $cards = [];
        foreach ($viewer->cards()->get() as $card) {
            $c = new \stdClass();
            $c->id = $card->id;
            $viewerItemFrame = ViewerItem::find($card->frame_id);
            $frame = Item::find($viewerItemFrame->item_id);
            $c->frame = $frame->image;
            $viewerItemHero = ViewerItem::find($card->hero_id);
            $hero = Item::find($viewerItemHero->item_id);
            $c->hero = $hero->image;
            if ($card->a_type == "custom") {
                $achievement = CustomAchievement::find($card->achivement_id);
                $c->achievement = $achievement->text;
            } else {
                $achievement = Achievement::find($card->achivement_id);
                // \DB::table('achievement_details')->find($card->achivement_id);
                $c->achievement = $achievement->description;
            }
            $c->promoted = ($viewer->promoted_gamecard_id == $c->id) ? true : false;
            $cards[] = $c;
        }
        
        return response()->json([
            'data' => ['cards' => $cards]
        ]);
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
        $validator = Validator::make($request->all(), [
            'frame_id'      => 'required|numeric',
            'hero_id'       => 'required|numeric',
            'achivement_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $totalCards = Card::where([
            ['viewer_id', '=', $viewer->id],
        ])->count();
        if ($totalCards >= config('ospp.cards.max')) {
            return response()->json([
                'errors' => ['You can not add onother card. Maximum reached.'],
            ]);
        }
        $card = new Card();
        $card->viewer_id = $viewer->id;
        $card->frame_id = $request->frame_id;
        $card->hero_id = $request->hero_id;
        if (strpos((string) $request->achivement_id, "c") === 0) {
            $card->achivement_id = (int)substr((string)$request->achivement_id, 1);
            $card->a_type = "custom";
        } else {
            $card->achivement_id = $request->achivement_id;
        }
        $card->save();
        if ($totalCards == 0) {
            $viewer->promoted_gamecard_id = $card->id;
            $viewer->save();
        }
        return response()->json([
            'message' => 'card successful created',
            'data' => [
                'id'  => $card->id,
            ]
        ]);
    }

    public function itemAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id'       => 'required|numeric',
            'card_id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $viewerItem = ViewerItem::find($request->item_id);
        if (!$viewerItem) {
            return response()->json([
                'errors' => ['You do not have this item.'],
            ]);
        }
        $find = CardItem::query()
                ->where('viewer_id', '=', $viewer->id)
                ->where('item_id', '=', $request->item_id)
                ->first();
        if ($find) {
            return response()->json([
                'errors' => ['this item already used'],
            ]);
        }
        if (!Card::find($request->card_id)) {
            return response()->json([
                'errors' => ['card id not exist'],
            ]);
        }
        $cardItems = CardItem::where([
            ['card_id', '=', $request->card_id]
        ])->first();
        if ($cardItems) {
            $addingCard = Item::find($request->item_id);    
            foreach ($cardItems as $cardItem) {
                $item = $cardItem->item()->first();
                if ($item->item_type_id == $addingCard->item_type_id) {
                    $cardItem->delete();
                }
            }
        }
        $addItem = new CardItem();
        $addItem->card_id = $request->card_id;
        $addItem->item_id = $request->item_id;
        $addItem->save();
        return response()->json([
            'message' => 'item successful added',
        ]);
    }

    public function itemsList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $card = Card::find($request->card_id);
        if (!$card || $card->viewer_id != $viewer->id) {
            return response()->json([
                'errors' => ['card id not exist'],
            ]);
        }
        return response()->json([
            'data' => $this->getCardItems($card->id),
        ]);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $card = Card::find($request->card_id);
        if (!$card || $card->viewer_id != $viewer->id) {
            return response()->json([
                'errors' => ['card id not exist'],
            ]);
        }
        return response()->json([
            'data' => [
                'card'  => $card,
                'items' =>  $this->getCardItems($card->id),
            ]
        ]);
    }

    public function itemDestroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id'       => 'required|numeric',
            'card_id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        if (!Card::where([
            'id'   =>  $request->card_id,
            'viewer_id' =>  $viewer->id,
        ])->first()) {
            return response()->json([
                'errors' => ['You do not have this card'],
            ]);
        }
        $item = CardItem::where([
            'card_id'   =>  $request->card_id,
            'item_id'   =>  $request->item_id,
        ])->first();
        if (!$item) {
            return response()->json([
                'errors' => ['You do not have this item.'],
            ]);
        }
        $item->delete();
        return response()->json([
            'message' => ['item successful deleted'],
        ]);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $card = Card::where([
            'id'   =>  $request->card_id,
            'viewer_id' =>  $viewer->id,
        ])->first();
        if (!$card) {
            return response()->json([
                'errors' => ['You do not have this card'],
            ]);
        }
        $card->delete();
        $total = Card::where('viewer_id', $viewer->id)->count();
        
        if ($total == 0) {
            $viewer->promoted_gamecard_id = null;
            $viewer->save();
        } elseif ($request->card_id == $viewer->promoted_gamecard_id) {
            $firstCard = Card::where('viewer_id', $viewer->id)->first();
            $viewer->promoted_gamecard_id = $firstCard->id;
            $viewer->save();
        }
        return response()->json([
            'message' => ['card successful deleted'],
        ]);
    }

    public function main(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $card = Card::where([
            'id'   =>  $request->card_id,
            'viewer_id' =>  $viewer->id,
        ])->first();
        if (!$card) {
            return response()->json([
                'errors' => ['You do not have this card'],
            ]);
        }
        $viewer->promoted_gamecard_id = $card->id;
        $viewer->save();
        return response()->json([
            'message' => ['set main card successful'],
        ]);
    }

    private function getCardItems($cardId)
    {
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        if (!Card::where([
            'id'   =>  $cardId,
            'viewer_id' =>  $viewer->id,
        ])->first()) {
            return [];
        }
        $cardItems = CardItem::query()
                    ->select('items.title', 'items.id', 'items.description', 'items.image', 'items.icon', 'item_types.name as type')
                    ->where('card_items.card_id', $cardId)
                    ->join('items', 'items.id', '=', 'card_items.item_id')
                    ->join('item_types', 'items.item_type_id', '=', 'item_types.id')
                    ->get();
        return $cardItems;
    }

}

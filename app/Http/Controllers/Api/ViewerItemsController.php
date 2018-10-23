<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{Viewer, Item, ItemType, ViewerItem, Card, ViewerPrize, StockPrize};

class ViewerItemsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['lastPrizes']]);
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
        $viewerItems = $viewer->items()->get();
        $items = [];
        $cards = Card::where('viewer_id', $viewer->id)->get();
        $cardItemsIds = [];
        foreach ($cards as $card) {
            $cardItemsIds[] = $card->frame_id;
            $cardItemsIds[] = $card->hero_id;
        }
        foreach ($viewerItems as $viewerItem) {
            if (!in_array($viewerItem->id, $cardItemsIds)) {
                $item = $viewerItem->item()->first();
                $item->type = $item->type()->first()->name;
                $item_id = $item->id;
                $item->id = $viewerItem->id;
                $item->item_id = $item_id;
                $items[] = $item;
            }
        }
        return response()->json(['data' => [
            'items' => $items,
        ]]);
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
                'id'   =>  'required|numeric|min:1',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        if (!Item::find($request->id)) {
            return response()->json([
                'errors' => ['item id not found'],
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $item = new ViewerItem();
        $item->viewer_id = $viewer->id;
        $item->item_id = $request->id;
        $item->save();
        
        return response()->json([
            'message' => 'item added to viewer',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'id'   =>  'required|numeric|min:1',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $viewerItem = ViewerItem::where([
            ['viewer_id', '=', $viewer->id],
            ['item_id', '=', $request->id],
        ])->first();
        if (!$viewerItem) {
            return response()->json([
                'errors' => ['item id not found '],
            ]);
        }
        $item = $viewerItem->item()->first();

        return response()->json([
            'data' => $item,
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
            'id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $viewerItem = ViewerItem::where([
            ['viewer_id', '=', $viewer->id],
            ['item_id', '=', $request->id],
        ])->first();
        if (!$viewerItem) {
            return response()->json([
                'errors' => ['item id not found'],
            ]);
        }
        $viewerItem->delete();
        return response()->json([
            'message' => 'item delete successful',
        ]);
    }

    public function lastPrizes(Request $request)
    {
        $count = 4;
        $viewerPrizes = ViewerPrize::orderBy('created_at', 'desc')->limit($count)->get();
        $prizes = [];
        for ($i = 0; $i < count($viewerPrizes); $i++) {
            $prize = [];
            $stockPrize = StockPrize::find($viewerPrizes[$i]->prize_id);
            $prize['id']  = $i;
            $prize['name'] = $stockPrize->name;
            $prize['description'] = $stockPrize->description;
            $prize['image'] = $stockPrize->image;
            $prize['viewer'] = $viewerPrizes[$i]->viewer_id;
            $prize['cost']  = $stockPrize->cost;
            $viewer = Viewer::find($prize['viewer']);
            $prize['viewer'] = $viewer->name;
            $prizes[] = $prize;
        }
        return response()->json([
            'data' => [
                'prizes'    =>  $prizes,
            ],
        ]);
    }

    public function inventoryFrames(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page'          => 'required|numeric|min:1',
            'on_page'       => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $data = $this->paginateItems($request->page, $request->on_page, 'frame');
        return response()->json([
            'data' => [
                'frames' => $data['items'],
                'page'  => $request->page,
                'pages' => $data['pages'],
            ],
        ]);
    }

    public function inventoryHeroes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page'          => 'required|numeric|min:1',
            'on_page'       => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $data = $this->paginateItems($request->page, $request->on_page, 'hero');
        return response()->json([
            'data' => [
                'heroes' => $data['items'],
                'page'  => $request->page,
                'pages' => $data['pages'],
            ],
        ]);
    }

    private function paginateItems($page, $onPage, $type)
    {
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $offset = $onPage * ($page - 1);
        $itemType = ItemType::where('name', $type)->first();
        $viewerItems = ViewerItem::query()
                        ->select('items.title', 'viewer_items.id', 'items.description', 'items.image', 'rarity_classes.name as rarity')
                        ->join('items', 'items.id', '=', 'viewer_items.item_id')
                        ->join('item_types', 'items.item_type_id', '=', 'item_types.id')
                        ->join('rarity_classes', 'rarity_classes.id', '=', 'items.rarity_class_id')
                        ->where('items.item_type_id', $itemType->id)
                        ->skip($offset)->take($onPage)->get();
        foreach ($viewerItems as &$viewerItem) {
            $viewerItem->class = ucfirst($viewerItem->rarity);
        }
        $count =  ViewerItem::query()
        ->select('viewer_items.id')
        ->join('items', 'items.id', '=', 'viewer_items.item_id')
        ->join('item_types', 'items.item_type_id', '=', 'item_types.id')
        ->where('items.item_type_id', $itemType->id)
        ->count();
        return [
            'items' =>  $viewerItems,
            'pages' =>  ceil($count / $onPage),
        ];
    }

}

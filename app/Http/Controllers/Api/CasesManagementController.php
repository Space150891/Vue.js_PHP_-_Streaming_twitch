<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
// use jeremykenedy\LaravelRoles\Models\Role;

use App\Models\{CaseType, LootCase, ItemCase, Item, ItemType, Raritie, Notification, StockPrize, ViewerItem, ViewerPrize, BuyedCaseType};

class CasesManagementController extends Controller
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
        $cases = LootCase::all();
        for ($i = 0; $i < count($cases); $i++) {
            // $lootItems = $cases[$i]->items()->get();
            // $caseItems = [];
            // foreach ($lootItems as $lootItem) {
            //     $caseItems[] = $lootItem->item()->first();
            // }
            // $cases[$i]->items = $caseItems;
            $type = $cases[$i]->type()->first();
            $cases[$i]->type = $type->name;
        }
        return response()->json(['data' => [
            'cases' => $cases,
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
                'name'              => 'required|max:255',
                'case_type_id'      => 'required|numeric',
                'items.*.item_id'    => 'numeric|min:1',
                'items.*.rarity_id'  => 'numeric|min:1',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        if (!CaseType::find($request->case_type_id)) {
            return response()->json([
                'errors' => ['invalid case type id'],
            ]);
        }
        if ($request->has('items')) {
            foreach ($request->items as $itemReq) {
                if (!Item::find($itemReq['item_id'])) {
                    return response()->json([
                        'errors' => ['invalid item id'],
                    ]);
                }
                if (!Raritie::find($itemReq['rarity_id'])) {
                    return response()->json([
                        'errors' => ['invalid raritie id'],
                    ]);
                }
            }
        }
        $case = new LootCase();
        $case->name = $request->name;
        $case->case_type_id = $request->case_type_id;
        $case->save();
        if ($request->has('items')) {
            foreach ($request->items as $itemReq) {
                $itemCase = new ItemCase();
                $itemCase->item_id = $itemReq['item_id'];
                $itemCase->rarity_id = $itemReq['rarity_id'];
                $itemCase->case_id = $case->id;
                $itemCase->save();
            }
        }

        return response()->json([
            'message' => 'new case created successful',
            'data' => [
                'id' => $case->id,
            ]
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
        $id = $request->id;
        $case = LootCase::find($id);

        if (!$case) {
            return response()->json([
                'errors' => ['case id not found'],
            ]);
        }
        $lootItems = $case->items()->get();
        $caseItems = [];
        foreach ($lootItems as $lootItem) {
            $caseItems[] =  $lootItem->item()->first();
        }
        $case->items = $caseItems;
        return response()->json([
            'data' => $case,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'id'       => 'required|numeric',
                'name'              => 'required|max:255',
                'case_type_id'      => 'required|numeric',
                'items.*.item_id'    => 'numeric|min:1',
                'items.*.rarity_id'  => 'numeric|min:1',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $case = LootCase::find($request->id);
        if (!$case) {
            return response()->json([
                'errors' => ['invalid case id'],
            ]);
        }
        if (!CaseType::find($request->case_type_id)) {
            return response()->json([
                'errors' => ['invalid case type id'],
            ]);
        }
        if ($request->has('items')) {
            foreach ($request->items as $itemReq) {
                if (!Item::find($itemReq['item_id'])) {
                    return response()->json([
                        'errors' => ['invalid item id'],
                    ]);
                }
                if (!Raritie::find($itemReq['rarity_id'])) {
                    return response()->json([
                        'errors' => ['invalid raritie id'],
                    ]);
                }
            }
        }
        $case->name = $request->name;
        $case->case_type_id = $request->case_type_id;
        $case->save();
        if ($request->has('items')) {
            $case->items()->delete();
            foreach ($request->items as $itemReq) {
                $itemCase = new ItemCase();
                $itemCase->item_id = $itemReq['item_id'];
                $itemCase->rarity_id = $itemReq['rarity_id'];
                $itemCase->case_id = $case->id;
                $itemCase->save();
            }
        }

        return response()->json([
            'message' => 'case updated successful',
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
                'errors' => $validator->errors(),
            ]);
        }
        $case = LootCase::find($request->id);
        if (!$case) {
            return response()->json([
                'errors' => ['case id not found'],
            ]);
        }
        $case->items()->delete();
        $case->delete();
        return response()->json([
            'message' => 'case delete successful',
        ]);
    }

    public function itemsList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $case = LootCase::find($request->id);
        if (!$case) {
            return response()->json([
                'errors' => ['case id not found'],
            ]);
        }
        $caseItems = ItemCase::query()
                    ->select('items_cases.id', 'items_cases.item_id', 'items_cases.rarity_id', 'items.title', 'items.icon', 'rarities.name as rarity', 'item_types.name as type')
                    ->where('items_cases.case_id', '=', $request->id)
                    ->join('items', 'items.id', '=', 'items_cases.item_id')
                    ->join('rarities', 'rarities.id', '=', 'items_cases.rarity_id')
                    ->join('item_types', 'item_types.id', '=', 'items.item_type_id')
                    ->get();
        return response()->json([
            'data' => [
                'items' => $caseItems,
            ],
        ]);
    }

    public function deleteItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        // $item = $case->items()->where('item_id', $request->item_id)->first();
        $item = ItemCase::find($request->id);
        if (!$item) {
            return response()->json([
                'errors' => ['item id not found'],
            ]);
        }
        $item->delete();
        return response()->json([
            'message' => 'item remove successful',
        ]);
    }

    public function addItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'case_id'       => 'required|numeric',
            'item_id'       => 'required|numeric',
            'rarity_id'     => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $case = LootCase::find($request->case_id);
        if (!$case) {
            return response()->json([
                'errors' => ['case id not found'],
            ]);
        }
        $item = Item::find($request->item_id);
        if (!$item) {
            return response()->json([
                'errors' => ['item id not found'],
            ]);
        }
        $rarity = Raritie::find($request->rarity_id);
        if (!$rarity) {
            return response()->json([
                'errors' => ['rarity id not found'],
            ]);
        }
        $itemCase = new ItemCase();
        $itemCase->case_id = $request->case_id;
        $itemCase->item_id = $request->item_id;
        $itemCase->rarity_id = $request->rarity_id;
        $itemCase->save();
        return response()->json([
            'message' => 'item added successful',
        ]);
    }

    public function buy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
            'valute'       => 'required|in:diamonds,coins',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $caseType = CaseType::find($request->id);
        if (!$caseType) {
            return response()->json([
                'errors' => ['case type id not found'],
            ]);
        }
        $cases = LootCase::where('case_type_id', $caseType->id)->get();
        if (count($cases) == 0) {
            return response()->json([
                'errors' => ['cases not found'],
            ]);
        }
        $case = $cases[round(rand(0, count($cases) - 1))];
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $winItems = [];
        $notify = new Notification();
        $notify->user_id = $user->id;
        $prizes = [];
        if ($request->valute == 'coins') {
            if ($viewer->current_points >= $caseType->price) {
                $viewer->current_points = $viewer->current_points - $caseType->price;
                $notify->event_type = 'user_message';
                $notify->message = 'Buyed new case! ' . $caseType->name;
                $winItems = $this->win($case);
                $prizes = $this->getItems($viewer->id, $winItems);
                $this->storeBuyedType($viewer->id, $caseType->id);
            } else {
                $notify->event_type = 'user_message';
                $notify->message = 'You no not have money for ' . $caseType->name;
            }
        }
        if ($request->valute == 'diamonds') {
            if ($viewer->diamonds >= $caseType->diamonds) {
                $viewer->diamonds = $viewer->diamonds - $caseType->diamonds;
                $notify->event_type = 'user_message';
                $notify->message = 'Buyed new case! ' . $caseType->name;
                $winItems = $this->win($case);
                $prizes = $this->getItems($viewer->id, $winItems);
                $this->storeBuyedType($viewer->id, $caseType->id);
            } else {
                $notify->event_type = 'user_message';
                $notify->message = 'You no not have diamonds for ' . $caseType->name;
            }
        }
        $notify->save();
        $viewer->save();
        return response()->json([
            'message' => $notify->message,
            'items'   => $this->removePrizes($winItems),
            'prizes'  => $prizes,
        ]);
    }

    private function getItems($viewerId, $items)
    {
        $prizes = [];
        foreach ($items as $item) {
            $itemType = ItemType::find($item->item_type_id );
            if ($itemType->name == "prize") {
                $prize = $this->prizeSelect($item->worth);
                if ($prize) {
                    $viewerPrize = new ViewerPrize();
                    $viewerPrize->viewer_id = $viewerId;
                    $viewerPrize->prize_id = $prize->id;
                    $viewerPrize->save();
                    $prize->amount--;
                    $prize->save();
                    $prizes[] = $prize;
                }
            } else {
                $viewerItem = new ViewerItem();
                $viewerItem->viewer_id = $viewerId;
                $viewerItem->item_id = $item->id;
                $viewerItem->save();
            }
        }
        return $prizes;
    }

    private function win($case)
    {
        $winingItems = [];
        $caseItems = ItemCase::where('case_id', $case->id)->get();
        foreach ($caseItems as $item) {
            if ($this->chance($item->rarity_id)) {
                $winingItems[] = Item::find($item->item_id);
            }
        }
        return $winingItems;
    }

    private function chance($rarityId)
    {
        $rarity = Raritie::find($rarityId);
        $chance = round(rand(0, 100));
        return  $rarity->percent > $chance;
    }

    private function prizeSelect($price)
    {
        $prize = StockPrize::where([
            ['cost', '>=', $price],
            ['amount', '>', 0],
        ])->orderBy('cost', 'asc')->first();
        if (!$prize) {
            $prize = StockPrize::where([
                ['amount', '>', 0],
            ])->orderBy('cost', 'desc')->first();
        }
        if (!$prize) {
            return false;
        }
        return $prize;
    }

    private function removePrizes($items)
    {
        $newItems = [];
        foreach ($items as $item) {
            $itemType = ItemType::find($item->item_type_id);
            if ($itemType->name !== 'prize') {
                $newItems[] = $item;
            }
        }
        return $newItems;
    }

    private function storeBuyedType($viewerId, $caseTypeId){
        $buyedCase = BuyedCaseType::where([
            ['viewer_id', '=', $viewerId],
            ['case_type_id', '=', $caseTypeId]
        ])->first();
        if (!$buyedCase) {
            $buyedCase = new BuyedCaseType();
            $buyedCase->viewer_id = $viewerId;
            $buyedCase->case_type_id = $caseTypeId;
            $buyedCase->total = 1;
        }
        $buyedCase->total++;
        $buyedCase->save();
    }

}


// $prize->amount--;
// $prize->save();
// $viewerPrize = new ViewerPrize();
// $viewerPrize->viewer_id = 
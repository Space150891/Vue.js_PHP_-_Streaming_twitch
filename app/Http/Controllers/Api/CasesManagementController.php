<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Validator;
// use jeremykenedy\LaravelRoles\Models\Role;

use App\Models\{
    User,
    CaseType,
    LootCase,
    ItemCase,
    Item,
    ItemType,
    Raritie,
    Notification,
    StockPrize,
    ViewerItem,
    ViewerPrize,
    BuyedCaseType,
    ViewerCase,
    Viewer,
    Achievement,
    AchievementProgres,
    RarityClass,
    HistoryBox,
    HistoryBoxItemType
};
use App\Achievements\{
    BuyFirstCaseAchievement,
    OpenFirstCaseAchievement,
    Open2CasesAchievement,
    Open3CasesAchievement,
    Open5CasesAchievement,
    FirstWinAchievement,
    FirstNonPriceWinAchievement,
    FirstPriceWinAchievement,
    NNonPricesWinAchievement,
    NPricesWinAchievement
};

class CasesManagementController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['lastList', 'lastOne']]);
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
                'errors' => $validator->errors()->all(),
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
        $validator = Validator::make($request->all(), [
            'viewer_case_id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $viewerCase = ViewerCase::find($request->viewer_case_id);
        if (!$viewerCase || !is_null($viewerCase->opened_at)) {
            return response()->json([
                'errors' => ['case type id not found'],
            ]);
        }
        $caseType = CaseType::find($viewerCase->case_id);
        return response()->json([
            'data' => [
                'all'   => [
                    'box'       => $this->getRarityClassById($caseType->rarity_class_id),
                    'box_image' => $caseType->image,
                    'hero'      => $this->getRarityClassById($caseType->hero_rarity_id),
                    'frame'     => $this->getRarityClassById($caseType->frame_rarity_id),
                    'prize'     => $caseType->prize_cost,
                    'points'    => $caseType->points_count,
                    'diamonds'  => $caseType->diamonds_count,
                ]
            ],
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
                'errors' => $validator->errors()->all(),
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
                'errors' => $validator->errors()->all(),
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
                'errors' => $validator->errors()->all(),
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
                'errors' => $validator->errors()->all(),
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
                'errors' => $validator->errors()->all(),
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
                'errors' => $validator->errors()->all(),
            ]);
        }
        $caseType = CaseType::find($request->id);
        if (!$caseType) {
            return response()->json([
                'errors' => ['case type id not found'],
            ]);
        }
        
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $notify = new Notification();
        $notify->title = 'Non enoght money';
        $notify->user_id = $user->id;
        if ($request->valute == 'coins') {
            if ($viewer->current_points >= $caseType->price) {
                $viewer->current_points = $viewer->current_points - $caseType->price;
                $notify->event_type = 'user_message';
                $notify->title = 'Buy case';
                $notify->message = 'Buyed new case! ' . $caseType->name;
                $viewerCase = new ViewerCase();
                $viewerCase->viewer_id = $viewer->id;
                $viewerCase->case_id = $caseType->id;
                $viewerCase->origin = "From StreamCase Store";
                $viewerCase->save();
            } else {
                $notify->event_type = 'user_message';
                $notify->message = 'You no not have money for ' . $caseType->name;
            }
        }
        if ($request->valute == 'diamonds') {
            if ($viewer->diamonds >= $caseType->diamonds) {
                $viewer->diamonds = $viewer->diamonds - $caseType->diamonds;
                $notify->title = 'Buy case';
                $notify->event_type = 'user_message';
                $notify->message = 'Buyed new case! ' . $caseType->name;
                $viewerCase = new ViewerCase();
                $viewerCase->viewer_id = $viewer->id;
                $viewerCase->case_id = $caseType->id;
                $viewerCase->origin = "From StreamCase Store";
                $viewerCase->save();
                $this->storeBuyedType($user, $caseType->id);
            } else {
                $notify->event_type = 'user_message';
                $notify->message = 'You no not have diamonds for ' . $caseType->name;
            }
        }
        $notify->save();
        $viewer->save();
        
        return response()->json([
            'message' => $notify->message,
        ]);
    }

    public function open(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'viewer_case_id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $viewerCase = ViewerCase::find($request->viewer_case_id);
        if (!$viewerCase || !is_null($viewerCase->opened_at)) {
            return response()->json([
                'errors' => ['case type id not found'],
            ]);
        }
        $viewerCase->opened_at = date('Y-m-d H:i:s');
        $viewerCase->save(); //uncoment after testing
        $user = auth()->user();
        $viewer = Viewer::find($viewerCase->viewer_id);
        $caseType = CaseType::find($viewerCase->case_id);
        $rarityClass = RarityClass::find($caseType->rarity_class_id)->first();
        if ($rarityClass) {
            switch ($rarityClass->name) {
                case 'common':
                    $user->addAchievement('OpenFirstCase1');
                    break;
                case 'uncommon':
                    $user->addAchievement('OpenFirstCase2');
                    break;
                case 'rare':
                    $user->addAchievement('OpenFirstCase3');
                    break;
                case 'epic':
                    $user->addAchievement('OpenFirstCase4');
                    break;
                case 'legendary':
                    $user->addAchievement('OpenFirstCase5');
                    break;
            }
            if (
                $user->hasAchievement('OpenFirstCase1')
                && $user->hasAchievement('OpenFirstCase2')
                && $user->hasAchievement('OpenFirstCase3')
                && $user->hasAchievement('OpenFirstCase4')
                && $user->hasAchievement('OpenFirstCase5')
            ){
                $user->addAchievement('OpenFirstCaseAll');
            }
        }
        $total = 0;
        $win = [];
        $win['hero'] = [
            'from'  => 0,
            'to'    => $caseType->hero_percent,
        ];
        $total += $caseType->hero_percent;
        $win['frame'] = [
            'from'  => $total + 1,
            'to'    => $total + $caseType->frame_percent,
        ];
        $total += $caseType->frame_percent;
        $win['prize'] = [
            'from'  => $total + 1,
            'to'    => $total + $caseType->prize_percent,
        ];
        $total += $caseType->prize_percent;
        $win['points'] = [
            'from'  => $total + 1,
            'to'    => $total + $caseType->points_percent,
        ];
        $total += $caseType->points_percent;
        $win['diamonds'] = [
            'from'  => $total + 1,
            'to'    => $total + $caseType->diamonds_percent,
        ];
        $total += $caseType->diamonds_percent;
        $win['nothing'] = [
            'from'  => $total + 1,
            'to'    => 100,
        ];
        $chance = rand(0, 100);
        foreach ($win as $k => $v) {
            if ($chance >= $v['from'] && $chance <= $v['to']) {
                $winner = $k;
            }
        }
        $prize = ['type' => $winner];
        $historyBoxItemType = HistoryBoxItemType::where('name', $winner)->first();
        switch ($winner) {
            case 'hero':
                $allItems = Item::where('rarity_class_id', $caseType->hero_rarity_id)->get();
                if (count($allItems) > 0) {
                    $chance = rand(0, count($allItems) - 1);
                    $item = $allItems[$chance];
                    $viewerItem = new ViewerItem();
                    $viewerItem->viewer_id = $viewer->id;
                    $viewerItem->item_id = $item->id;
                    $viewerItem->save();
                    $prize['image'] = $item->image;
                    $prize['icon'] = $item->icon;
                    $history = new HistoryBox();
                    $history->viewer_box_id = $viewerCase->id;
                    $history->viewer_id = $viewer->id;
                    $history->box_type_id = $caseType->id;
                    $history->item_type_id = $historyBoxItemType->id;
                    $history->item_id = $item->id;
                    $history->save(); //uncoment after testing
                } else {
                    $prize['type'] = 'nothing';
                    $this->winFailure($viewer->id, $caseType->id, $viewerCase->id);
                }
                break;
            case 'frame':
                $allItems = Item::where('rarity_class_id', $caseType->frame_rarity_id)->get();
                if (count($allItems) > 0) {
                    $chance = rand(0, count($allItems) - 1);
                    $item = $allItems[$chance];
                    $viewerItem = new ViewerItem();
                    $viewerItem->viewer_id = $viewer->id;
                    $viewerItem->item_id = $item->id;
                    $viewerItem->save();
                    $prize['image'] = $item->image;
                    $prize['icon'] = $item->icon;
                    $history = new HistoryBox();
                    $history->viewer_box_id = $viewerCase->id;
                    $history->viewer_id = $viewer->id;
                    $history->box_type_id = $caseType->id;
                    $history->item_type_id = $historyBoxItemType->id;
                    $history->item_id = $item->id;
                    $history->save(); //uncoment after testing
                } else {
                    $prize['type'] = 'nothing';
                    $this->winFailure($viewer->id, $caseType->id, $viewerCase->id);
                }
                
                break;
            case 'prize':
                $stockPrize = StockPrize::where([
                    ['cost', '>=', $caseType->prize_cost],
                    ['amount', '>', 0],
                ])->orderBy('cost', 'asc')->first();
                if (!$stockPrize) {
                    $stockPrize = StockPrize::where([
                        ['amount', '>', 0],
                    ])->orderBy('cost', 'desc')->first();
                }
                if (!$stockPrize) {
                    $prize['type'] = 'nothing';
                    $this->winFailure($viewer->id, $caseType->id, $viewerCase->id);
                } else {
                    $prize['image'] = $stockPrize->image;
                    $history = new HistoryBox();
                    $history->viewer_box_id = $viewerCase->id;
                    $history->viewer_id = $viewer->id;
                    $history->box_type_id = $caseType->id;
                    $history->item_type_id = $historyBoxItemType->id;
                    $history->item_id = $stockPrize->id;
                    $history->save(); //uncoment after testing
                }
                break;
            case 'points':
                $viewer->addPoints([
                    'points'        => $caseType->points_count,
                    'title'         => 'open stream box',
                    'description'   => $caseType->description,
                ]);
                $viewer->save();
                $prize['count'] = $caseType->points_count;
                $history = new HistoryBox();
                $history->viewer_box_id = $viewerCase->id;
                $history->viewer_id = $viewer->id;
                $history->box_type_id = $caseType->id;
                $history->item_type_id = $historyBoxItemType->id;
                $history->details = $caseType->points_count;
                $history->save(); //uncoment after testing
                break;
            case 'diamonds':
                $viewer->diamonds += $caseType->diamonds_count;
                $viewer->save();
                $prize['count'] = $caseType->diamonds_count;
                $history = new HistoryBox();
                $history->viewer_box_id = $viewerCase->id;
                $history->viewer_id = $viewer->id;
                $history->box_type_id = $caseType->id;
                $history->item_type_id = $historyBoxItemType->id;
                $history->details = $caseType->diamonds_count;
                $history->save(); //uncoment after testing
                break;
            case 'nothing':
                $this->winFailure($viewer->id, $caseType->id, $viewerCase->id);
                break;
        }
        return response()->json([
            'data' => [
                'win'   => $prize,
                // 'all'   => [
                //     'box'       => $this->getRarityClassById($caseType->rarity_class_id),
                //     'box_image' => $caseType->image,
                //     'hero'      => $this->getRarityClassById($caseType->hero_rarity_id),
                //     'frame'     => $this->getRarityClassById($caseType->frame_rarity_id),
                //     'prize'     => $caseType->prize_cost,
                //     'points'    => $caseType->points_count,
                //     'diamonds'  => $caseType->diamonds_count,
                // ]
            ],
        ]);
    }

    public function lastList(Request $request)
    {
        $needCount = 10;
        $count = 0;
        $data = [];
        $itemType = HistoryBoxItemType::where('name', 'prize')->first();
        $cases = HistoryBox::where('item_type_id', $itemType->id)->latest()->limit($needCount)->get();
        $count = count($cases);
        $data = $cases;
        if ($count < $needCount) {
            $itemType = HistoryBoxItemType::where('name', 'hero')->first();
            $cases = HistoryBox::where('item_type_id', $itemType->id)->latest()->limit($needCount - $count)->get();
            $count += count($cases);
            $data = $this->merge($data, $cases);
        }
        if ($count < $needCount) {
            $itemType = HistoryBoxItemType::where('name', 'frame')->first();
            $cases = HistoryBox::where('item_type_id', $itemType->id)->latest()->limit($needCount - $count)->get();
            $count += count($cases);
            $data = $this->merge($data, $cases);
        }
        if ($count < $needCount) {
            $itemType = HistoryBoxItemType::where('name', 'diamonds')->first();
            $cases = HistoryBox::where('item_type_id', $itemType->id)->latest()->limit($needCount - $count)->get();
            $count += count($cases);
            $data = $this->merge($data, $cases);
        }
        if ($count < $needCount) {
            $itemType = HistoryBoxItemType::where('name', 'points')->first();
            $cases = HistoryBox::where('item_type_id', $itemType->id)->latest()->limit($needCount - $count)->get();
            $count += count($cases);
            $data = $this->merge($data, $cases);
        }
        $boxes = [];
        foreach ($data as $d) {
            $boxes[] = $d->getDetails();
        }
        return response()->json([
            'data' => [
                'cases'   => $boxes,
            ],
        ]);
    }

    public function lastOne(Request $request)
    {
        $now = new Carbon();
        $now->subSeconds(5);
        $time = $now->toDateTimeString();
        $itemType = HistoryBoxItemType::where('name', 'prize')->first();
        $case = HistoryBox::where('item_type_id', $itemType->id)->where('updated_at', '>=', $time)->first();
        if (!$case) {
            $itemType = HistoryBoxItemType::where('name', 'hero')->first();
            $case = HistoryBox::where('item_type_id', $itemType->id)->where('updated_at', '>=', $time)->first();
        }
        if (!$case) {
            $itemType = HistoryBoxItemType::where('name', 'frame')->first();
            $case = HistoryBox::where('item_type_id', $itemType->id)->where('updated_at', '>=', $time)->first();
        }
        if (!$case) {
            $itemType = HistoryBoxItemType::where('name', 'diamonds')->first();
            $case = HistoryBox::where('item_type_id', $itemType->id)->where('updated_at', '>=', $time)->first();
        }
        if (!$case) {
            $itemType = HistoryBoxItemType::where('name', 'points')->first();
            $case = HistoryBox::where('item_type_id', $itemType->id)->where('updated_at', '>=', $time)->first();
        }
        $box = false;
        if ($case) {
            $box = $case->getDetails();
        }
        return response()->json([
            'data' => [
                'cases'   => $box,
            ],
        ]);
    }

    public function inventory(Request $request)
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
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $offset = $request->on_page * ($request->page - 1);
        $viewerCases = ViewerCase::where('viewer_id', $viewer->id)->orderBy('opened_at', 'ASC')->skip($offset)->take($request->on_page)->get();
        foreach ($viewerCases as &$viewerCase) {
            $caseType = CaseType::find($viewerCase->case_id);
            $rarityClass = RarityClass::find($caseType->rarity_class_id);
            $viewerCase->name = ucfirst($rarityClass->name);
            $viewerCase->image = $caseType->image;
            if (!is_null($viewerCase->opened_at)) {
                $historyBox = HistoryBox::where('viewer_box_id', $viewerCase->id)->first();
                $viewerCase->history = $historyBox->getDetails();
            }
        }
        return response()->json([
            'data' => [
                'cases' => $viewerCases,
                'page'  => $request->page,
                'pages' => ceil(ViewerCase::where('viewer_id', $viewer->id)->count() / $request->on_page),
            ],
        ]);
    }


    private function winFailure($viewerId, $boxTypeId, $viewerCaseId)
    {
        $historyBoxItemType = HistoryBoxItemType::where('name', 'nothing')->first();
        $history = new HistoryBox();
        $history->viewer_box_id = $viewerCaseId;
        $history->viewer_id = $viewerId;
        $history->box_type_id = $boxTypeId;
        $history->item_type_id = $historyBoxItemType->id;
        $history->save();
    }
    
    private function merge($array1, $array2)
    {
        $data = [];
        foreach ($array1 as $ar1) {
            $data[] = $ar1;
        }
        foreach ($array2 as $ar2) {
            $data[] = $ar2;
        }
        return $data;
    }

    private function getRarityClassById($rarityId)
    {
        $rarity = RarityClass::find($rarityId);
        if (!$rarity) {
            return 'none';
        }
        return ucfirst($rarity->name);
    }
}

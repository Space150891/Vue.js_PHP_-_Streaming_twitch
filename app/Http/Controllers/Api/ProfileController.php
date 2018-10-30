<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;
use App\Models\{
    Achievement,
    BuyedCaseType,
    Card,
    CaseType,
    CustomAchievement,
    Item,
    HistoryPoint,
    HistoryBox,
    Notification,
    StockPrize,
    RarityClass,
    User,
    ViewerPrize,
    ViewerItem,
    ViewerCase
};

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
                'errors' => $validator->errors()->all(),
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
        $hideFields = json_decode($viewer->hide_fields, true);
        $card = false;
        $fields = [];
        if (!in_array('current_points', $hideFields)) {
            $fields[] = [
                'name'      => 'current_points',
                'alias'     => 'Current points',
                'value'     => $viewer->current_points
            ];
        }
        if (!in_array('diamonds', $hideFields)) {
            $fields[] = [
                'name'      => 'diamonds',
                'alias'     => 'Diamonds',
                'value'     => $viewer->diamonds
            ];
        }
        if (!in_array('spend_points', $hideFields)) {
            $fields[] = [
                'name'      => 'spend_points',
                'alias'     => 'Spend Points',
                'value'     => $viewer->level_points - $viewer->current_points,
            ];
        }
        if (!in_array('total_buyed_cases', $hideFields)) {
            $fields[] = [
                'name'      => 'total_buyed_cases',
                'alias'     => 'Total buyed cases',
                'value'     => BuyedCaseType::where('viewer_id', $viewer->id)->sum('total'),
            ];
        }
        if (!in_array('buyed_case_types', $hideFields)) {
            $caseTypes = BuyedCaseType::where('viewer_id', $viewer->id)->get();
            $caseText = '';
            $first = true;
            foreach ($caseTypes as $caseType) {
                $case = CaseType::find($caseType->case_type_id);
                if (!$first) {
                    $caseText .= ', ';
                }
                $caseText .= $case->name . ' x ' . $caseType->total;
                $first = false;
            }
            $fields[] = [
                'name'      => 'buyed_case_types',
                'alias'     => 'Buyed Cases Types',
                'value'     => $caseText,
            ];
        }
        if (!in_array('won_prizes_count', $hideFields)) {
            $fields[] = [
                'name'      => 'won_prizes_count',
                'alias'     => 'Won real prizes (count)',
                'value'     => ViewerPrize::where('viewer_id', $viewer->id)->count(),
            ];
        }
        if (!in_array('won_prizes_sum', $hideFields)) {
            $prizes = ViewerPrize::where('viewer_id', $viewer->id)->get();
            $sumPrizes = 0;
            foreach ($prizes as $prize) {
                $real = StockPrize::find($prize->prize_id);
                $sumPrizes += $real->cost;
            }
            $fields[] = [
                'name'      => 'won_prizes_sum',
                'alias'     => 'Won real prizes ($)',
                'value'     => $sumPrizes,
            ];
        }
        if (!in_array('inventory', $hideFields)) {
            $fieldItems = [];
            $viewerItems = ViewerItem::where('viewer_id', $viewer->id)->get();
            foreach ($viewerItems as $viewerItem) {
                $item = $viewerItem->item()->first();
                $fieldItems[] = [
                    'id'     => $viewerItem->id,
                    'title'  => $item->title,
                    'icon'   => $item->icon,
                ];
            }
            $fields[] = [
                'name'      => 'inventory',
                'alias'     => 'Inventory (total items)',
                'value'     => ViewerItem::where('viewer_id', $viewer->id)->count(),
                'data'      => $fieldItems,
            ];
        }
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
            if ($currentCard->a_type == "custom") {
                $achievement = CustomAchievement::find($currentCard->achivement_id);
                $card->achievement = $achievement->text;
            } else {
                $achievement = Achievement::find($currentCard->achivement_id);
                $card->achievement = $achievement->description;
            }
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
                'fields'    => $fields,
            ],
        ]);
    }

    public function getCurrent(Request $request)
    {
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $streamer = $user->streamer()->first();
        $card = false;
        // if ($viewer->promoted_gamecard_id) {
        //     $currentCard = Card::find($viewer->promoted_gamecard_id);
        //     $card = new \stdClass();
        //     $card->id = $currentCard->id;
        //     $viewerFrame = ViewerItem::find($currentCard->frame_id);
        //     $frame = Item::find($viewerFrame->item_id);
        //     $card->frame = $frame->image;
        //     $viewerHero = ViewerItem::find($currentCard->hero_id);
        //     $hero = Item::find($viewerHero->item_id);
        //     $card->hero = $hero->image;
        //     if ($currentCard->a_type == "custom") {
        //         $achievement = CustomAchievement::find($currentCard->achivement_id);
        //         $card->achievement = $achievement->text;
        //     } else {
        //         $achievement = Achievement::find($currentCard->achivement_id);
        //         $card->achievement = $achievement->description;
        //     }
        // }
        $dataPrizes = [];
        $viewerPrizes = ViewerPrize::where('viewer_id', $viewer->id)->get();
        foreach ($viewerPrizes as $viewerPrize) {
            $prize = $viewerPrize->prize()->first();
            $prize->id = $viewerPrize->id;
            $dataPrizes[] = $prize;
        }
        $caseTypes = BuyedCaseType::where('viewer_id', $viewer->id)->get();
        $caseText = '';
        $first = true;
        foreach ($caseTypes as $caseType) {
            $case = CaseType::find($caseType->case_type_id);
            if (!$first) {
                $caseText .= ', ';
            }
            $caseText .= $case->name . ' x ' . $caseType->total;
            $first = false;
        }
        $prizes = ViewerPrize::where('viewer_id', $viewer->id)->get();
        $sumPrizes = 0;
        foreach ($prizes as $prize) {
            $real = StockPrize::find($prize->prize_id);
            $sumPrizes += $real->cost;
        }
        if (!$streamer->stream_token) {
            $streamer->stream_token = $this->genCode();
            $streamer->save();
        }
        //
        $closedCases = ViewerCase::where('viewer_id', $viewer->id)->whereNull('opened_at')->get();
        $openedCases = ViewerCase::where('viewer_id', $viewer->id)->whereNotNull('opened_at')->get();
        foreach ($closedCases as &$viewerCase) {
            $caseType = CaseType::find($viewerCase->case_id);
            $rarityClass = RarityClass::find($caseType->rarity_class_id);
            $viewerCase->name = $rarityClass->name;
            $viewerCase->image = $caseType->image;
        }
        foreach ($openedCases as &$viewerCase) {
            $caseType = CaseType::find($viewerCase->case_id);
            $rarityClass = RarityClass::find($caseType->rarity_class_id);
            $viewerCase->name = $rarityClass->name;
            $viewerCase->image = $caseType->image;
            $historyBox = HistoryBox::where('viewer_box_id', $viewerCase->id)->first();
            $viewerCase->history = $historyBox->getDetails();
        }
        $now = new Carbon;
        $now->subSeconds(60);
        $updateTime = $now->toDateTimeString();
        // \Log::info('check updated >' . $updateTime);
        $historyPoints = HistoryPoint::where('viewer_id', $viewer->id)->where('created_at', '>', $updateTime)->get();
        $lastPoints = (integer)HistoryPoint::where('viewer_id', $viewer->id)->where('created_at', '>', $updateTime)->sum('points');
        $notifications = Notification::where([
            ['user_id', '=', $user->id],
            ['event_type', '=', 'user_message'],
        ])->whereNull('view_at')->get();
        foreach ($notifications as $notification) {
            $notification->view_at = $updateTime;
            $notification->save();
        }
        $boxTypes = CaseType::all();
        $aviableBoxes = [];
        foreach ($boxTypes as $boxType) {
            $rarityClass = RarityClass::find($boxType->rarity_class_id);
            if ($rarityClass->special == 0) {
                $boxType->rarity_class = ucfirst($rarityClass->name);
                $aviableBoxes[] = $boxType;
            }
        }
        return response()->json([
            'data' => [
                'id'            => $user->id,
                'avatar'        =>  $user->avatar,
                'username'      =>  $user->first_name,
                'nikname'       => $user->name,
                'bio'           => $user->bio,
                'email'         => $user->email,
                'paypal'        => '',
                'card'          => $card,
                'verified'      => $viewer->phone_verified ? true : false,
                'phone'         => $viewer->phone ? $viewer->phone : '',
                'prizes'        => $dataPrizes,
                'hide_fields'   => $viewer->hide_fields ? $viewer->hide_fields : [],
                'stream_token'  => $streamer->stream_token,
                'prize_alert'   => $streamer->prize_alert,
                'streamlabs'    => is_null($streamer->streamlabs_access) ? false : true,
                'streamelements'    => is_null($streamer->streamelements_access) ? false : true,
                'subscription'    => $user->isSubscribed(),
                'history_points' => $historyPoints,
                'last_points' => $lastPoints,
                'points'        => $viewer->current_points,
                'diamonds'      => $viewer->diamonds,
                'notifications' => $notifications,
                'level'     => $viewer->getLevel(),
                'case_types'    => $aviableBoxes,
                'fields'        => [
                    [
                        'name'      => 'current_points',
                        'alias'     => 'Current points',
                        'value'     => $viewer->current_points
                    ],
                    [
                        'name'      => 'diamonds',
                        'alias'     => 'Diamonds',
                        'value'     => $viewer->diamonds
                    ],
                    [
                        'name'      => 'spend_points',
                        'alias'     => 'Spend Points',
                        'value'     => $viewer->level_points - $viewer->current_points,
                    ],
                    [
                        'name'      => 'total_buyed_cases',
                        'alias'     => 'Total buyed cases',
                        'value'     => BuyedCaseType::where('viewer_id', $viewer->id)->sum('total'),
                    ],
                    [
                        'name'      => 'buyed_case_types',
                        'alias'     => 'Buyed Cases Types',
                        'value'     => $caseText,
                    ],
                    [
                        'name'      => 'won_prizes_count',
                        'alias'     => 'Won real prizes (count)',
                        'value'     => ViewerPrize::where('viewer_id', $viewer->id)->count(),
                    ],
                    [
                        'name'      => 'won_prizes_sum',
                        'alias'     => 'Won real prizes ($)',
                        'value'     => $sumPrizes,
                    ],
                    [
                        'name'      => 'inventory',
                        'alias'     => 'Inventory',
                        'value'     => ViewerItem::where('viewer_id', $viewer->id)->count(),
                    ],
                ],
                'cases' => [
                    'opened'    =>  $openedCases,
                    'closed'    =>  $closedCases,
                ],
            ],
        ]);
    }

    public function hideField(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'field'       => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $hiddenFields = $viewer->hide_fields ? json_decode($viewer->hide_fields, true) : [];
        if (!in_array($request->field, $hiddenFields)) {
            $hiddenFields[] = $request->field;
        }
        $viewer->hide_fields = json_encode($hiddenFields);
        $viewer->save();
        return response()->json([
            'message' => 'field added to hidden',
        ]);
    }

    public function showField(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'field'       => 'required|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $field = $request->field;
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $hiddenFields = $viewer->hide_fields ? json_decode($viewer->hide_fields, true) : [];
        if (in_array($field, $hiddenFields)) {
            $pos = array_search($field, $hiddenFields);
            array_splice($hiddenFields, $pos, 1);
        }
        $viewer->hide_fields = json_encode($hiddenFields);
        $viewer->save();
        return response()->json([
            'message' => 'field removed from hidden',
        ]);
    }

    public function savePrizeAlert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prize_alert'       => 'required|in:30,60,120,300,600',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $user = auth()->user();
        $streamer = $user->streamer()->first();
        $streamer->prize_alert = $request->prize_alert;
        $streamer->save();
        return response()->json([
            'message' => 'prize alert saved',
        ]);
    }

    private function genCode()
    {
        $length = 50;
        $symbols = '/\d|\w/';
        $code = '';
        do {
            $char = str_random(1);
            $code .= preg_match($symbols, $char) === 1 ? $char : '';
        } while(strlen($code) < $length);
        return $code;
    }
    
}

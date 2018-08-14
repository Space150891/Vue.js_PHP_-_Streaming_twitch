<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{
    User,
    Card,
    Item,
    ViewerPrize,
    StockPrize,
    ViewerItem,
    BuyedCaseType,
    CaseType,
    CustomAchievement
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
                $achievement = \DB::table('achievement_details')->find($currentCard->achivement_id);
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
            if ($currentCard->a_type == "custom") {
                $achievement = CustomAchievement::find($currentCard->achivement_id);
                $card->achievement = $achievement->text;
            } else {
                $achievement = \DB::table('achievement_details')->find($currentCard->achivement_id);
                $card->achievement = $achievement->description;
            }
        }
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
                'errors' => $validator->errors(),
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
                'errors' => $validator->errors(),
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
    
}

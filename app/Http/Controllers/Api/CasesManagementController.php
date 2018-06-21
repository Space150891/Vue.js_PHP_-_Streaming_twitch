<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
// use jeremykenedy\LaravelRoles\Models\Role;

use App\Models\CaseType;
use App\Models\LootCase;
use App\Models\ItemCase;
use App\Models\Item;
use App\Models\Raritie;

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
            $lootItems = $cases[$i]->items()->get();
            $caseItems = [];
            foreach ($lootItems as $lootItem) {
                $caseItems[] = $lootItem->item()->first();
            }
            $cases[$i]->items = $caseItems;
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
    public function show(Request $request) //// 
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
            return back()->withErrors($validator)->withInput();
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

    public function deleteItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'case_id'       => 'required|numeric',
            'item_id'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $case = LootCase::find($request->case_id);
        if (!$case) {
            return response()->json([
                'errors' => ['case id not found'],
            ]);
        }
        $item = $case->items()->where('item_id', $request->item_id)->first();
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
            return back()->withErrors($validator)->withInput();
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
}

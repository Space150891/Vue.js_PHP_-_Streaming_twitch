<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use jeremykenedy\LaravelRoles\Models\Role;

use App\Models\ItemType;

class ItemTypesManagementController extends Controller
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
        $itemTypes = ItemType::all();
        return response()->json(['data' => [
            'item_types' => $itemTypes,
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
                'name'  => 'required|max:255|unique:item_types',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $itemType = new ItemType();
        $itemType->name = $request->name;
        $itemType->save();

        return response()->json([
            'message' => 'new item type created successful',
            'data' => [
                'id' => $itemType->id,
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
        $itemType = ItemType::find($id);

        if (!$itemType) {
            return response()->json([
                'errors' => ['item type id not found'],
            ]);
        }

        return response()->json([
            'data' => $itemType,
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
        $validator = Validator::make($request->all(), [
            'id'       => 'required|numeric',
            'name'     => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $itemType = ItemType::find($request->id);

        if (!$itemType) {
            return response()->json([
                'errors' => ['item type id not found'],
            ]);
        }
        
        return response()->json([
            'message' => 'item type update successful',
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

        $itemType = ItemType::find($request->id);

        if (!$itemType) {
            return response()->json([
                'errors' => ['item type id not found'],
            ]);
        }

        $itemType->delete();

        return response()->json([
            'message' => 'item type delete successful',
        ]);
    }
}

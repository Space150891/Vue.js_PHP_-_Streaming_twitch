<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{Viewer, Item, ViewerItem};

class ViewerItemsController extends Controller
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
        $viewerItems = $viewer->items()->get();
        $items = [];
        foreach ($viewerItems as $vieverItem) {
            $items[] = $vieverItem->item()->first();
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
                'errors' => $validator->errors(),
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
                'errors' => $validator->errors(),
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
            return back()->withErrors($validator)->withInput();
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
}

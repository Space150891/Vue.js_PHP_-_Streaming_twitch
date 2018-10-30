<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Support\Facades\Storage;

use App\Models\{Item, ItemType, RarityClass};

class itemsManagementController extends Controller
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
        $items = Item::all();
        for ($i = 0; $i < count($items); $i++) {
            $items[$i]->type = $items[$i]->type()->first()->name;
            $rarityClass = RarityClass::find($items[$i]->rarity_class_id);
            $items[$i]->rarity_class = $rarityClass ? $rarityClass->name : 'not defined';
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
                'title'          => 'required|max:255',
                'item_type_id'   => 'required|numeric',
                'rarity_class_id'=> 'required|numeric',
                'description'    => 'max:255',
                'worth'          => 'numeric',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }

        if (!ItemType::find($request->item_type_id)) {
            return response()->json([
                'errors' => ['item type id not exist'],
            ]);
        }

        $item = new Item();
        $item->title = $request->title;
        $item->item_type_id = $request->item_type_id;
        $item->rarity_class_id = $request->rarity_class_id;
        $item->description = $request->description;
        $item->worth = $request->worth;
        $item->icon = $request->icon;   // upload ?
        $item->save();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extention = strtolower($file->extension());
            $fileName = 'image_' . $item->id . '_' . $extention;
            $destination = 'public/items/images';
            Storage::putFileAs($destination, $file, $fileName);
            $item->image = 'items/images/' . $fileName;
            $item->save();
        }
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $extention = strtolower($file->extension());
            $fileName = 'icon_' . $item->id . '_' . $extention;
            $destination = 'public/items/icons';
            Storage::putFileAs($destination, $file, $fileName);
            $item->icon = 'items/icons/' . $fileName;
            $item->save();
        }

        return response()->json([
            'message' => 'new item created successful',
            'data' => [
                'id' => $item->id,
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
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'errors' => ['item id not found'],
            ]);
        }

        return response()->json([
            'data' => $item,
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
            'id'             => 'required|numeric',
            'title'          => 'required|max:255',
            'item_type_id'   => 'required|numeric',
            'rarity_class_id'=> 'required|numeric',
            'description'    => 'max:255',
            'worth'          => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }

        $item = Item::find($request->id);

        if (!$item) {
            return response()->json([
                'errors' => ['item id not found'],
            ]);
        }
        $item->title = $request->title;
        $item->item_type_id = $request->item_type_id;
        $item->rarity_class_id = $request->rarity_class_id;
        $item->description = $request->description;
        $item->worth = $request->worth;
        $item->save();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extention = strtolower($file->extension());
            $fileName = 'image_' . $item->id . '.' . $extention;
            $destination = 'public/items/images';
            Storage::putFileAs($destination, $file, $fileName);
            $item->image = 'items/images/' . $fileName;
            $item->save();
        }
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $extention = strtolower($file->extension());
            $fileName = 'icon_' . $item->id . '.' . $extention;
            $destination = 'public/items/icons';
            Storage::putFileAs($destination, $file, $fileName);
            $item->icon = 'items/icons/' . $fileName;
            $item->save();
        }

        return response()->json([
            'message' => 'item update successful',
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

        $item = Item::find($request->id);

        if (!$item) {
            return response()->json([
                'errors' => ['item id not found'],
            ]);
        }
        // if ($item->image) {
        //     Storage::delete('public/' . $item->image);
        // }
        // if ($item->icon) {
        //     Storage::delete('public/' . $item->icon);
        // }
        $item->delete();

        return response()->json([
            'message' => 'item delete successful',
        ]);
    }

    private function generateFileName($ext) {
        do {
            $name = 'prize_' . uniqid() . '.' . $ext;
        } while(Storage::exists('public/stock/' . $name));
        return $name;
    }

}

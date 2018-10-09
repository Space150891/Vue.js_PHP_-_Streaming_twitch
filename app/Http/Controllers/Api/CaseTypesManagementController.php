<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\{CaseType, RarityClass};

class CaseTypesManagementController extends Controller
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
        $caseTypes = CaseType::all();

        $rarityClasses = RarityClass::all();
        $classes = [];
        foreach ($rarityClasses as $rarityClass) {
            $classes[$rarityClass->id] = $rarityClass->name . ($rarityClass->special == 1 ? ' special' : '');
        }
        $classes[0] = 'not defined';
        foreach ($caseTypes as &$caseType) {
            $caseType->rarity_class = $classes[$caseType->rarity_class_id];
        }
        return response()->json(['data' => [
            'caseTypes' => $caseTypes,
        ]]);
    }

    public function front()
    {
        $caseTypes = CaseType::all();

        $rarityClasses = RarityClass::where('special', 0)->get();
        $classes = [];
        foreach ($rarityClasses as $rarityClass) {
            $classes[$rarityClass->id] = $rarityClass->name . ($rarityClass->special == 1 ? ' special' : '');
        }
        $data = [];
        foreach ($caseTypes as &$caseType) {
            if (isset($classes[$caseType->rarity_class_id])) {
                $caseType->rarity_class = $classes[$caseType->rarity_class_id];
                $data[] = $caseType;
            }
        }
        return response()->json(['data' => [
            'caseTypes' => $data,
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
                'description'   => 'required|max:255|unique:case_types',
                'price'         => 'required|numeric',
                'diamonds'      => 'required|numeric',
                'rarity_class_id' => 'required|numeric',
                'hero_rarity_id' => 'required|numeric|min:0',
                'frame_rarity_id' => 'required|numeric|min:0',
                'prize_cost' => 'required|numeric|min:0',
                'points_count' => 'required|numeric|min:0',
                'diamonds_count' => 'required|numeric|min:0',
                'hero_percent' => 'required|numeric|min:0|max:99',
                'frame_percent' => 'required|numeric|min:0|max:99',
                'prize_percent' => 'required|numeric|min:0|max:99',
                'points_percent' => 'required|numeric|min:0|max:99',
                'diamonds_percent' => 'required|numeric|min:0|max:99',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $caseType = new CaseType();
        $caseType->description = $request->description;
        $caseType->price = $request->price;
        $caseType->diamonds = $request->diamonds;
        $caseType->rarity_class_id = $request->rarity_class_id;
        $caseType->hero_rarity_id = $request->hero_rarity_id;
        $caseType->frame_rarity_id = $request->frame_rarity_id;
        $caseType->prize_cost = $request->prize_cost;
        $caseType->points_count = $request->points_count;
        $caseType->diamonds_count = $request->diamonds_count;
        $caseType->hero_percent = $request->hero_percent;
        $caseType->frame_percent = $request->frame_percent;
        $caseType->prize_percent = $request->prize_percent;
        $caseType->points_percent = $request->points_percent;
        $caseType->diamonds_percent = $request->diamonds_percent;
        $caseType->save();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extention = strtolower($file->extension());
            $fileName = 'image_' . $caseType->id . '.' . $extention;
            $destination = 'public/case_types/';
            Storage::putFileAs($destination, $file, $fileName);
            $caseType->image = 'case_types/' . $fileName;
            $caseType->save();
        }

        return response()->json([
            'message' => 'new case type created successful',
            'data' => [
                'id' => $caseType->id,
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
        $caseType = CaseType::find($id);

        if (!$caseType) {
            return response()->json([
                'errors' => ['case type id not found'],
            ]);
        }

        return response()->json([
            'data' => $caseType,
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
            'id'            => 'required|numeric',
            'description'   => 'required|max:255',
            'price'         => 'required|numeric|min:1',
            'diamonds'      => 'required|numeric|min:1',
            'rarity_class_id' => 'required|numeric|min:0',
            'hero_rarity_id' => 'required|numeric|min:0',
            'frame_rarity_id' => 'required|numeric|min:0',
            'prize_cost' => 'required|numeric|min:0',
            'points_count' => 'required|numeric|min:0',
            'diamonds_count' => 'required|numeric|min:0',
            'hero_percent' => 'required|numeric|min:0|max:99',
            'frame_percent' => 'required|numeric|min:0|max:99',
            'prize_percent' => 'required|numeric|min:0|max:99',
            'points_percent' => 'required|numeric|min:0|max:99',
            'diamonds_percent' => 'required|numeric|min:0|max:99',
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

        $caseType->description = $request->description;
        $caseType->price = $request->price;
        $caseType->diamonds = $request->diamonds;
        $caseType->rarity_class_id = $request->rarity_class_id;
        $caseType->hero_rarity_id = $request->hero_rarity_id;
        $caseType->frame_rarity_id = $request->frame_rarity_id;
        $caseType->prize_cost = $request->prize_cost;
        $caseType->points_count = $request->points_count;
        $caseType->diamonds_count = $request->diamonds_count;
        $caseType->hero_percent = $request->hero_percent;
        $caseType->frame_percent = $request->frame_percent;
        $caseType->prize_percent = $request->prize_percent;
        $caseType->points_percent = $request->points_percent;
        $caseType->diamonds_percent = $request->diamonds_percent;
        $caseType->save();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extention = strtolower($file->extension());
            $fileName = 'image_' . $caseType->id . '_' . $extention;
            $destination = 'public/case_types/';
            Storage::putFileAs($destination, $file, $fileName);
            $caseType->image = 'case_types/' . $fileName;
            $caseType->save();
        }
        
        return response()->json([
            'message' => 'case type update successful',
        ]);
    }


    public function lastBoxes(Request $request)
    {
        $count = 15;
        
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
        $caseType = CaseType::find($request->id);
        if (!$caseType) {
            return response()->json([
                'errors' => ['case type id not found'],
            ]);
        }

        $caseType->delete();
        return response()->json([
            'message' => 'case type delete successful',
        ]);
    }

    private function generateFileName($ext) {
        do {
            $name = 'prize_' . uniqid() . '_' . $ext;
        } while(Storage::exists('public/stock/' . $name));
        return $name;
    }
}

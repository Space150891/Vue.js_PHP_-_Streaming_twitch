<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\{Achievement, RarityClass};

class AchivementsManagementController extends Controller
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

    public function list()
    {
        $rarityClasses = RarityClass::all();
        $classes = [];
        $classes[0] = 'no';
        foreach ($rarityClasses as $rarityClass) {
            $classes[$rarityClass->id] = $rarityClass->name;
        }
        $achievements  = Achievement::all();
        foreach ($achievements as &$achievement) {
            $achievement->card = $classes[$achievement->card_rarity_id];
            $achievement->case = $classes[$achievement->case_rarity_id];
            $achievement->frame = $classes[$achievement->frame_rarity_id];
            $achievement->hero = $classes[$achievement->hero_rarity_id];
        }
        
        return response()->json(['data' => [
            'achievements' => $achievements,
        ]]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'                => 'required|min:1',
            'name'              => 'required',
            'description'       => 'required',
            'steps'             => 'required|numeric',
            'level_points'      => 'required|numeric',
            'diamonds'          => 'required|numeric',
            'case_rarity_id'    => 'required|numeric',
            'card_rarity_id'    => 'required|numeric',
            'frame_rarity_id'   => 'required|numeric',
            'hero_rarity_id'    => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $achievement  = Achievement::find($request->id);
        if (!$achievement) {
            return response()->json([
                'errors' => ['achievement not found'],
            ]);
        }
        $achievement->name = $request->name;
        $achievement->description = $request->description;
        $achievement->steps = $request->steps;
        $achievement->level_points = $request->level_points;
        $achievement->diamonds = $request->diamonds;
        $achievement->case_rarity_id = $request->case_rarity_id;
        $achievement->card_rarity_id = $request->card_rarity_id;
        $achievement->frame_rarity_id = $request->frame_rarity_id;
        $achievement->hero_rarity_id = $request->hero_rarity_id;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extention = strtolower($file->extension());
            $fileName = 'image_' . $achievement->id . '_' . $extention;
            $destination = 'public/achievements';
            Storage::putFileAs($destination, $file, $fileName);
            $achievement->image = 'achievements/' . $fileName;
        }
        $achievement->save();
        return response()->json([
            'message' => 'achievement saved',
        ]);
    }
 
}

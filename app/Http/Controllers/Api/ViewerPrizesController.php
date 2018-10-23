<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{
    User,
    Viewer,
    ViewerPrize,
    StockPrize,
    RarityClass
};

class ViewerPrizesController extends Controller
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
        $viewerPrizes = ViewerPrize::where('viewer_id', $viewer->id)->skip($offset)->take($request->on_page)->get();
        foreach ($viewerPrizes as &$viewerPrize) {
            $prize = StockPrize::find($viewerPrize->prize_id);
            $rarityClass = RarityClass::find($prize->rarity_class_id);
            $viewerPrize->class = ucfirst($rarityClass->tier());
            $viewerPrize->name = $prize->name;
            $viewerPrize->description = $prize->description;
            $viewerPrize->cost = $prize->cost;
            $viewerPrize->image = $prize->image;
        }
        return response()->json([
            'data' => [
                'prizes' => $viewerPrizes,
                'page'  => $request->page,
                'pages' => ceil(ViewerPrize::where('viewer_id', $viewer->id)->count() / $request->on_page),
            ],
        ]);
    }

}

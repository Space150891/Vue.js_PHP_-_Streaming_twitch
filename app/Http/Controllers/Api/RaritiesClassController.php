<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\RarityClass;

class RaritiesClassController extends Controller
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
        $rarities = RarityClass::where('special', 0)->get();
        return response()->json(['data' => [
            'rarity_classes' => $rarities,
        ]]);
    }

    public function all()
    {
        $rarities = RarityClass::all();
        return response()->json(['data' => [
            'rarity_classes' => $rarities,
        ]]);
    }

}

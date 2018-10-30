<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PrizeType;

class PrizeTypesController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    public function index()
    {
        $prizeTypes = PrizeType::all();
        return response()->json([
            'data' => 
            [
                'prize_types'   => $prizeTypes
            ],
        ]);
    }

}

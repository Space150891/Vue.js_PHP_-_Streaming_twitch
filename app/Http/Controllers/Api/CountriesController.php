<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;

class CountriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    public function index()
    {
        $countries = Country::all();
        return response()->json([
            'data' => [
                'countries' => $countries,
            ],
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\Game;

class GamesController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['list']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    public function list()
    {
        $games = Game::all();
        return response()->json(['data' => [
            'games' => $games,
        ]]);
    }
 
}

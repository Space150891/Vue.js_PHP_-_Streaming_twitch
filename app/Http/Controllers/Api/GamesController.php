<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;

use App\Models\{Game, Activity, Streamer};

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
        foreach ($games as &$game) {
            $streamersByGame = Streamer::where('game', $game->name)->get();
            $streamersCount = 0;
            $viewersCount = 0;
            foreach ($streamersByGame as $streamer) {
                $now = new Carbon;
                $now->subSeconds(config('ospp.activity.valid_pause'));
                $updateTime = $now->toDateTimeString();
                $active = Activity::where([
                    ['streamer_id', '=', $streamer->id],
                    ['updated_at', '>', $updateTime],
                ])->count();
                $streamersCount += $active > 0 ? 1 : 0;
                $viewersCount += $active;
            }
            $game->streamers = $streamersCount;
            $game->viewers = $viewersCount;
        }
        return response()->json(['data' => [
            'games' => $games,
        ]]);
    }
 
}

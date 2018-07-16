<?php

use Illuminate\Database\Seeder;
use App\Models\{Game};
use GuzzleHttp\Client as Guzzle;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientId = config('services.twitch.client_id');
        $guzzle = new Guzzle([ 'headers' => [ 
            'Client-ID' => $clientId,
            'Accept'    => 'application/vnd.twitchtv.v5+json',
            ] ]);
        $result = $guzzle->request('GET', 'https://api.twitch.tv/helix/games/top?first=100');
        $games = json_decode((string) $result->getBody(), true);
        foreach ($games['data'] as $game) {
            $oldGame = Game::where('name', $game['name'])->first();
            if ($oldGame) {
                echo "Game " . $game['name'] . "is already in DB \n";
                continue;
            }
            $url = $game["box_art_url"];
            $url = str_replace("{width}", 136, $url);
            $url = str_replace("{height}", 190, $url);
            $newGame = new Game();
            $newGame->twitch_id = $game['id'];
            $newGame->name = $game['name'];
            $newGame->avatar = $url;
            $newGame->save();
            echo "GAME= " . $game['name'] . " id=" . $game['id'] . " avatar=" . $url . "\n";
        }
    }
}

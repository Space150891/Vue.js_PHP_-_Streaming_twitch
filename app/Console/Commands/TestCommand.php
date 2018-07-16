<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stripe\Stripe;
use App\Models\{Profile, User, Viewer, Streamer, Game};
use GuzzleHttp\Client as Guzzle;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'try';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->fakeUsers(100);
    }

    private function fakeUsers($num = 10)
    {
        $clientId = config('services.twitch.client_id');
        $guzzle = new Guzzle([ 'headers' => [ 
            'Client-ID' => $clientId,
            'Accept'    => 'application/vnd.twitchtv.v5+json',
            ] ]);
        $result = $guzzle->request('GET', 'https://api.twitch.tv/helix/streams?first=' . $num);
        $allStreams = json_decode((string) $result->getBody(), true);
        foreach ($allStreams['data'] as $stream) {
            $result = $guzzle->request('GET', 'https://api.twitch.tv/kraken/streams/' . $stream['user_id']);
            $data = json_decode((string) $result->getBody(), true);
            $name = $data['stream']['channel']['name'];
            $game = $data['stream']['channel']['game'];
            echo "GAME = {$game}";
            $oldUser = User::where('name', $name)->first();
            if ($oldUser) {
                echo "user is already in DB \n";
                continue;
            }
            // creating user
            $user = new User();
            $user->token = '';
            $user->activated = 1;
            $user->password = \Hash::make('123');
            $user->last_name = '';
            $user->name = $name;
            $user->save();
            $streamer = new Streamer();
            $streamer->user_id = $user->id;
            $streamer->twitch_id = $stream['user_id'];
            $streamer->name = $user->name;
            $streamer->game = strtolower($game);
            $streamer->save();
            $viewer = new Viewer();
            $viewer->user_id = $user->id;
            $viewer->name = $user->name;
            $viewer->save();
        }
    }

    private function games()
    {
        $clientId = config('services.twitch.client_id');
        $guzzle = new Guzzle([ 'headers' => [ 
            'Client-ID' => $clientId,
            'Accept'    => 'application/vnd.twitchtv.v5+json',
            ] ]);
        $result = $guzzle->request('GET', 'https://api.twitch.tv/helix/games/top?first=100');
        $games = json_decode((string) $result->getBody(), true);
        foreach ($games['data'] as $game) {
            $url = $game["box_art_url"];
            $url = str_replace("{width}", 136, $url);
            $url = str_replace("{height}", 190, $url);
            echo "NAME= " . $game['name'] . " id=" . $game['id'] . " avatar=" . $url . "\n";
        }
    }
}

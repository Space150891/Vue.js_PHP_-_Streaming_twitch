<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe\Stripe;
use App\Models\{Profile, User, Viewer, Streamer, Game, ViewerItem, Activity, Item, Notification, SubscribedStreamers};
use GuzzleHttp\Client as Guzzle;
use LiqPay;

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
        $userId = 229212518;
        $r1 = $this->getTwitchUser($userId);
        $r2 = $this->getTwitchUserOld($userId);
        var_dump($r1);
        var_dump($r2);
    }


    private function getTwitchUser($userId)
    {
        $clientId = config('services.twitch.client_id');
        $guzzle = new Guzzle();
        $guzzle = new Guzzle([ 'headers' => [ 'Client-ID' => $clientId]]);
        $result = $guzzle->request('GET', 'https://api.twitch.tv/helix/users?id=' . $userId);
        $body = json_decode((string) $result->getBody(), true);
        return [
            'name'          => $body['data'][0]['login'],
            'nick'          => $body['data'][0]['display_name'],
            'avatar'        => $body['data'][0]['profile_image_url'],
            'stream_image'  => $body['data'][0]['offline_image_url'],
            'viewers'       => $body['data'][0]['view_count'],
            'email'         => null
        ];
    }

    private function getTwitchUserOld($userId, $oauth)
    {
        $clientId = config('services.twitch.client_id');
        $guzzle = new Guzzle();
        $guzzle = new Guzzle([ 'headers' => [ 'Client-ID' => $clientId]]);
        $result = $guzzle->request('GET', 'https://api.twitch.tv/kraken/user?id=' . $userId);
        $body = json_decode((string) $result->getBody(), true);

        return [
            'name'          => $body['name'],
            'nick'          => $body['display_name'],
            'avatar'        => $body['logo'],
            'stream_image'  => null,
            'viewers'       => null,
            'email'         => $body['email'],
        ];
    }

}

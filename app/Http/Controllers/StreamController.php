<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;

class StreamController extends Controller
{
    public function streams1()
    {
        $data = [
            'channel' => 'aws',
            'chat'    => 'aws',
        ];
        return view('pages.stream.streams1', $data);
    }

    public function streams2()
    {
        $data = [
            'channels'   => [
                'aws',
                'met_esports',
            ],
            'chat'    => 'aws',
        ];
        return view('pages.stream.streams2', $data);
    }

    public function streams4()
    {
        $data = [
            'channels'   => [
                'aws',
                'met_esports',
                'thespartanshow',
                'twitchpresents',
            ],
            'chat'    => 'aws',
        ];
        return view('pages.stream.streams4', $data);
    }

    public function test()
    {
        $twitchSecret = config('services.twitch.client_secret');
        $twitchId = config('services.twitch.client_id');
        $guzzle = new Guzzle([ 'headers' => [ 'Client-ID' => $twitchId ] ]);
        $top1 = 'https://api.twitch.tv/helix/games/top';
        $result = $guzzle->request('GET', $top1);
        $body = (string) $result->getBody();
        dd(json_decode($body));
        $data = [];
        return view('pages.stream.test', $data);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\{Streamer};

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

    public function startStream($token)
    {
        $streamer = Streamer::where('stream_token', $token)->first();
        if (!$streamer) {
            return redirect('/');
        }
        return view('pages.alert-widget', ['token' => $token]);
    }

}

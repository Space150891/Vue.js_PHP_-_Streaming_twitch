<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class ServerEventsController extends Controller
{
    public function serverSideEvents(Request $request)
    {
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Access-Control-Allow-Origin', getOrigin($_SERVER));
        $response->headers->set('Cache-Control', 'public');
        $response->setCallback(
            function() use ($request){
                if (array_key_exists('token', $_COOKIE) && $_COOKIE['token'] != 'undefined') {
                    $auth = auth()->setToken($_COOKIE['token'])->user();
                    if ($auth) {
                        $user = $auth;
                        $time = new Carbon();
                        $date = $time->toDateTimeString();
                        echo "data: " . json_encode(['message' => $date]) . PHP_EOL . PHP_EOL;
                    } else {
                        echo "data: " . json_encode(['error' => 1, 'error_message' => 'User Authentication Failed']) . PHP_EOL . PHP_EOL;
                    }
                } else {
                    echo "data: error= do not have token\n\n";
                }
                flush();
                sleep(2);
            });
        $response->send();
    }

    public function testPageSSE()
    {
        return view('pages.sse');
    }
}
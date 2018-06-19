<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Controllers\Controller;

class ServerEventsController extends Controller
{
    public function serverSideEvents(Request $request)
    {
        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $origin = $_SERVER['HTTP_ORIGIN'];
        }
        else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            $origin = $_SERVER['HTTP_REFERER'];
        } else {
            $origin = $_SERVER['REMOTE_ADDR'];
        }
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Access-Control-Allow-Origin', $origin);
        $response->headers->set('Cache-Control', 'public');
        $response->setCallback(
            function() use ($origin, $request){
                if (array_key_exists('token', $_COOKIE) && $_COOKIE['token'] != 'undefined') {
                    $auth = auth()->setToken($_COOKIE['token']);
                    if ($auth) {
                        $user = $auth->user();
                        echo "data: user_name= {$user->name}\n\n";
                    } else {
                        echo "data: error= wrong token\n\n";
                    }
                } else {
                    echo "data: error= do not have token\n\n";
                }
                ob_flush();
                flush();
                usleep(200000);
            });
        $response->send();
    }

    public function testPageSSE()
    {
        return view('pages.sse');
    }
}
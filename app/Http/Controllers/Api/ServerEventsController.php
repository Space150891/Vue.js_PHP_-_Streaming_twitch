<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Controllers\Controller;

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
                sleep(10);
            });
        $response->send();
    }

    public function testPageSSE()
    {
        return view('pages.sse');
    }
}
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Softon\Sms\Facades\Sms;
use App\Models\{User, Notification};

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
                if (array_key_exists('token', $_COOKIE) && $_COOKIE['token'] != 'undefined' && $_COOKIE['token'] != 'null') {
                    $user = auth()->setToken($_COOKIE['token'])->user();
                    if ($user) {
                        $count = 0;
                        do {
                            if ($data) {
                                $count++;
                                $total = Notification::where('user_id', $user->id)->count();
                                if ($total > 99) {
                                    $older = Notification::where('user_id', $user->id)->orderBy('created_at', 'asc')->first();
                                    $older->delete();
                                }
                                $notifyData = json_decode($data, true);
                                Notification::create([
                                    'user_id'       => $user->id,
                                    'event_type'    => $notifyData['event_type'],
                                    'message'    => $notifyData['message'],
                                    'created_at'    => Carbon::now()->toDateTimeString(),
                                    'updated_at'    => Carbon::now()->toDateTimeString(),
                                ]);
                                echo "data: " . $data . PHP_EOL . PHP_EOL;
                            }
                        } while($data && $count < 100);
                    } else {
                        echo "data: " . json_encode(['error' => 1, 'error_message' => 'User Authentication Failed']) . PHP_EOL . PHP_EOL;
                    }
                } else {
                    echo "data: " . json_encode(['error' => 1, 'error_message' => 'Do not have token']) . PHP_EOL . PHP_EOL;
                }
                sleep(5);
                flush();
            });
        $response->send();
    }

    public function testPageSSE()
    {
        return view('pages.sse');
    }
}
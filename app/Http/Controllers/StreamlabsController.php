<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;
use App\Models\{User, Streamer, SubscriptionPlan, MonthPlan, SubscribedStreamers, Payment, Diamond};

class StreamlabsController extends Controller
{

    public function Login(Request $request)
    {
        $clientId = env('STREAMLABS_CLIENT_ID');
        $redirect = env('STREAMLABS_REDIRECT_URL');
        $query = http_build_query([
            'response_type' => 'code',
            'client_id'     => $clientId,
            'redirect_uri'  => $redirect,
            'scope'         => 'donations.create',
          ]);
          
        $url = "https://www.streamlabs.com/api/v1.0/authorize?{$query}";
        return redirect($url);
    }

    public function Oauth(Request $request)
    {
        $clientId = env('STREAMLABS_CLIENT_ID');
        $redirect = env('STREAMLABS_REDIRECT_URL');
        $secret = env('STREAMLABS_SECRET');
        \Log::info('on streamlabs OAUTH code=' . $request->code);
        $client = new Guzzle();

        try {
            $response = $client->post('https://streamlabs.com/api/v1.0/token', [
                'form_params' => [
                'grant_type'    => 'authorization_code',
                'client_id'     => $clientId,
                'client_secret' => $secret,
                'redirect_uri'  => $redirect,
                'code'          => $_GET['code']
                ]
            ]);
            $result = (string)$response->getBody();
            \Log::info('auth result=' . $result);
            $data = json_decode($result, true);
            $accessToken = $data['access_token'];
            $refreshToken = $data['refresh_token'];
            $response = $client->get('https://streamlabs.com/api/v1.0/user?access_token=' . $accessToken);
            $result = (string)$response->getBody();
            \Log::info('user=' . $result);
            $data = json_decode($result, true);
            $twitchId = $data['twitch']['id'];
            $streamer = Streamer::where('twitch_id', $twitchId)->first();
            $streamer->streamlabs_access = $accessToken;
            $streamer->streamlabs_refresh = $refreshToken;
            $streamer->save();
        } catch (Exception $e) {
            $result = $e->getResponse()->json();
            \Log::info(json_encode($result));
        }
        // https://streamlabs.com/api/v1.0/donations?access_token=03xHrnM39KDLPtur0GmjYc7XcrSVskYOh2VF9GtQ
        return redirect('/#cabinet');
    }

}

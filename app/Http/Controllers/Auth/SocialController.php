<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Social;
use App\Models\User;
use App\Traits\ActivationTrait;
use App\Traits\CaptureIpTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use jeremykenedy\LaravelRoles\Models\Role;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Viewer;
use App\Models\Streamer;
use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    use ActivationTrait;

    public function getSocialRedirect($provider)
    {
        $providerKey = Config::get('services.'.$provider);

        if (empty($providerKey)) {
            return view('pages.status')
                ->with('error', trans('socials.noProvider'));
        }

        return Socialite::driver($provider)->redirect();
    }

    public function getSocialHandle($provider)
    {
        if (Input::get('denied') != '') {
            return redirect()->to('login')
                ->with('status', 'danger')
                ->with('message', trans('socials.denied'));
        }

        $socialUserObject = Socialite::driver($provider)->user();

        $socialUser = null;

        // Check if email is already registered
        $userCheck = User::where('email', '=', $socialUserObject->email)->first();

        $email = $socialUserObject->email;

        if (!$socialUserObject->email) {
            $email = 'missing'.str_random(10).'@'.str_random(10).'.example.org';
        }

        if (empty($userCheck)) {
            $sameSocialId = Social::where('social_id', '=', $socialUserObject->id)
                ->where('provider', '=', $provider)
                ->first();

            if (empty($sameSocialId)) {
                $ipAddress = new CaptureIpTrait();
                $socialData = new Social();
                $profile = new Profile();
                $role = Role::where('slug', '=', 'user')->first();
                $fullname = explode(' ', $socialUserObject->name);
                if (count($fullname) == 1) {
                    $fullname[1] = '';
                }
                $username = $socialUserObject->nickname;

                if ($username == null) {
                    foreach ($fullname as $name) {
                        $username .= $name;
                    }
                }

                $user = User::create([
                    'name'                 => $username,
                    'first_name'           => $fullname[0],
                    'last_name'            => $fullname[1],
                    'email'                => $email,
                    'password'             => bcrypt(str_random(40)),
                    'token'                => str_random(64),
                    'activated'            => true,
                    'signup_sm_ip_address' => $ipAddress->getClientIp(),

                ]);

                $socialData->social_id = $socialUserObject->id;
                $socialData->provider = $provider;
                $user->social()->save($socialData);
                $user->attachRole($role);
                $user->activated = true;

                $user->profile()->save($profile);
                $viewer = new Viewer();
                // $user->twitch_id = 
                $user->save();

                // save viewer and streamer
                $viewer->name = $user->name;
                $viewer->user_id = $user_id;
                $viewer->save();
                $streamer = new Streamer();
                $streamer->name = $user->name;
                $streamer->user_id = $user_id;
                $streamer->save();
                //
                if ($socialData->provider == 'github') {
                    $user->profile->github_username = $socialUserObject->nickname;
                }

                // Twitter User Object details: https://developer.twitter.com/en/docs/tweets/data-dictionary/overview/user-object
                if ($socialData->provider == 'twitter') {
                    $user->profile()->twitter_username = $socialUserObject->screen_name;
                }
                $user->profile->save();

                $socialUser = $user;
            } else {
                $socialUser = $sameSocialId->user;
            }

            auth()->login($socialUser, true);

            return redirect('home')->with('success', trans('socials.registerSuccess'));
        }

        $socialUser = $userCheck;

        auth()->login($socialUser, true);

        return redirect('home');
    }

    public function twitchRedirect(Request $request)
    {
        $clientId = config('services.twitch.client_id');
        $redirect = config('services.twitch.redirect');
        $state = str_random(30);
        $url = "https://api.twitch.tv/kraken/oauth2/authorize";
        // $url = "https://id.twitch.tv/oauth2/authorize";
        $url .= "?client_id={$clientId}";
        $url .= "&redirect_uri={$redirect}";
        $url .= "&response_type=code";
        $url .= "&scope=user_read";
        $url .= "&state={$state}";
        $request->session()->put('twitch_state', $state);
        return redirect($url);
    }

    public function twitchCallback(Request $request)
    {
        $clientId = config('services.twitch.client_id');
        $secret = config('services.twitch.client_secret');
        $redirect = config('services.twitch.redirect');
        // if (!$request->has('state') || $request->state !== $request->session()->get('twitch_state')) {
        //     exit("wrong request!");
        // }
        $guzzle = new Guzzle();
        $url = "https://id.twitch.tv/oauth2/token";
        $url .= "?client_id={$clientId}";
        $url .= "&client_secret={$secret}";
        $url .= "&code={$request->code}";
        $url .= "&grant_type=authorization_code";
        $url .= "&redirect_uri={$redirect}";
        $result = $guzzle->request('POST', $url);
        $statusSode = (string) $result->getStatusCode();
        $body = json_decode((string) $result->getBody(), true);
        $accessToken = $body['access_token'];
        $guzzle = new Guzzle([ 'headers' => [ 
            'Client-ID' => $clientId,
            'Authorization' => 'OAuth ' . $accessToken,
            ] ]);
        $result = $guzzle->request('GET', 'https://api.twitch.tv/kraken/user');
        $statusSode = (string) $result->getStatusCode();
        $body = json_decode((string) $result->getBody(), true);
        // dd($body);
        $user = User::where('name', $body['name'])->first();
        if (!$user) {
            $user = new User();
            $user->token = '';
            $user->activated = 1;
            $user->password = '123';
            $user->last_name = '';
        }
        $user->name = $body['name'];
        $user->first_name = $body['display_name'];
        $user->email = $body['email'];
        $user->bio = $body['bio'];
        $user->avatar = $body['logo'];
        $user->save();

        $token = auth()->login($user);

        $data = [
            'access_token'  => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
        return view('layouts.app', $data);
    }

    public function getToken(Request $request)
    {
        \Log::info('TOKEN INFO:');
        \Log::info($request->access_token);
        \Log::info($request->refresh_token);
        \Log::info($request->expires_in);
        \Log::info($scope);
    }

    public function test()
    {
        $data = [
            'access_token'  => '1234',
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
        return view('pages.getjwt', $data);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\{Profile, Social, User, Viewer, Streamer, Channel, Afiliate, Game, Achievement, AchievementProgres};
use App\Traits\ActivationTrait;
use App\Traits\CaptureIpTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use jeremykenedy\LaravelRoles\Models\Role;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\Auth;
use App\Achievements\{
    FirstLoginAchievement,
    Login10daysAchievement,
    Login20daysAchievement,
    FirstReferViewerAchievement,
    Refer100ViewersAchievement
};
use App\Mail\WellcomeMail;
use Illuminate\Support\Facades\Mail;

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
        $url .= "?client_id={$clientId}";
        $url .= "&redirect_uri={$redirect}";
        $url .= "&response_type=code";
        $url .= "&scope=channel_read user_read";
        $url .= "&state={$state}";
        $request->session()->put('twitch_state', $state);
        return redirect($url);
    }

    public function twitchCallback(Request $request)
    {
        $clientId = config('services.twitch.client_id');
        $secret = config('services.twitch.client_secret');
        $redirect = config('services.twitch.redirect');
        $ip = getOrigin($_SERVER);
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
        $refreshToken = $body['refresh_token'];
        $guzzle = new Guzzle([ 'headers' => [
            // 'Accept'    => 'application/vnd.twitchtv.v3+json',
            'Client-ID' => $clientId,
            'Authorization' => 'OAuth ' . $accessToken,
        ] ]);
        $result = $guzzle->request('GET', 'https://api.twitch.tv/kraken/user');
        // $result = $guzzle->request('GET', 'https://api.twitch.tv/kraken/channel');
        $statusSode = (string) $result->getStatusCode();
        $body = json_decode((string) $result->getBody(), true);
        $user = User::where('name', strtolower($body['name']))->first();
        if (!$user) {
            $user = new User();
            $user->name = $body['name'];
            $user->bio = $body['bio'];
            $user->avatar = $body['logo'];
            $user->twitch_id = $body['_id'];
            $user->token = '';
            $user->activated = 1;
            $user->password = \Hash::make('123');
            $user->last_name = '';
            $user->email = strtolower($body['email']);
            $mail = new WellcomeMail();
            Mail::to($user->email)->send($mail);
            $afiliate = Afiliate::where('ip_address', $ip)->whereNull('register_at')->first();
            if ($afiliate) {
                $afiliate->register_at = Carbon::now()->toDateTimeString();
                $afiliate->afiliate_id = $user->id;
                $afiliate->save();
            }
            $user->save();
            $streamer = new Streamer();
            $streamer->user_id = $user->id;
            $streamer->name = $user->name;
            $viewer = new Viewer();
            $viewer->user_id = $user->id;
            $viewer->name = $user->name;
            $viewer->save();
        } else {
            $streamer = $user->streamer()->first();
            $viewer = $user->viewer()->first();
        }
        $ip = getOrigin($_SERVER);
        $user->name = strtolower($body['name']);
        $user->email = strtolower($body['email']);
        $user->save();
        $user->first_name = $body['display_name'];
        $user->bio = $body['bio'];
        $user->avatar = $body['logo'];
        $user->twitch_id = $body['_id'];
        $user->save();
        $twitchUserId = $body['_id'];
        $streamer->twitch_id = $twitchUserId;
        $result = $guzzle->request('GET', 'https://api.twitch.tv/kraken/channel');
        $streamData = json_decode((string) $result->getBody(), true);
        //$streamData = isset($body['data'][0]) ? $body['data'][0] : false;
        $streamer->save();
        if ($streamData['game']) {
            $result = $guzzle->request('GET', 'https://api.twitch.tv/helix/games', ['query' => ['name' => $streamData['game']]]);
            $body = json_decode((string) $result->getBody(), true);
            $gameData = $body['data'][0];
            $streamer->game = $gameData['name'];
            $streamer->image = isset($streamData['video_banner']) ? $streamData['video_banner'] : null;
            $streamer->viewers_count = isset($streamData['views']) ? $streamData['views'] : 0;
            $streamer->followers_count = isset($streamData['followers']) ? $streamData['followers'] : 0;
            $streamer->save();
            $game = Game::find($gameData['id']);
            if (!$game) {
                $game = new Game();
                $game->name = $gameData['name'];
                $game->twitch_id = $gameData['id'];
                $game->avatar = $this->getImage($gameData['box_art_url'], 136, 190);
                $game->save();
            }
        }
        $streamer->save();
        ////
        $user->addAchievement('App\Achievements\FirstLoginAchievement');
        if (!$this->alreadyToday('App\Achievements\Login10daysAchievement', $user->id)) {
            $user->addAchievement('App\Achievements\Login10daysAchievement');
        }
        if (!$this->alreadyToday('App\Achievements\Login20daysAchievement', $user->id)) {
            $user->addAchievement('App\Achievements\Login20daysAchievement');
        }
        $token = auth()->login($user);
        $data = [
            'access_token'          => $token,
            'twitch_refresh_token'  => $refreshToken,
            'token_type'            => 'bearer',
            'expires_in'            => auth()->factory()->getTTL() * 60
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

    private function alreadyToday($achivementClass, $userId)
    {
        \Log::info('searching achievement ' . $achivementClass);
        $achievement = Achievement::where('class_name', $achivementClass)->first();
        $achievementProgres = AchievementProgres::where([
            ['user_id', '=', $userId],
            ['achievement_id', '=', $achievement->id],
        ])->first();
        if (!$achievementProgres) {
            return false;
        }
        $now = new Carbon;
        return ($achievementProgres->updated_at->toDateString() === $now->toDateString());
    }

    private function getImage($url, $width, $heigth)
    {
        $url = str_replace("{width}", $width, $url);
        $url = str_replace("{height}", $heigth, $url);
        return $url;
    }

}

<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\{Profile, Social, User, Viewer, Streamer, Channel, Afiliate};
use App\Traits\ActivationTrait;
use App\Traits\CaptureIpTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use jeremykenedy\LaravelRoles\Models\Role;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\Auth;
use App\Achievements\{FirstLoginAchievement, Login10daysAchievement, Login20daysAchievement};
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
        \Log::info('USER');
        \Log::info($body);
        $user = User::where('name', strtolower($body['name']))->first();
        if (!$user) {
            $ip = $request->ip();
            $afiliate = Afiliate::where('ip_address', $ip)->whereNull('register_at')->first();
            if ($afiliate) {
                $afiliate->register_at = Carbon::now()->toDateTimeString();
                $afiliate->save();
            }
            $user = new User();
            $user->token = '';
            $user->activated = 1;
            $user->password = \Hash::make('123');
            $user->last_name = '';
            $user->name = strtolower($body['name']);
            $user->email = strtolower($body['email']);
            $mail = new WellcomeMail();
            Mail::to($user->email)->send($mail);
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
        
        $user->name = strtolower($body['name']);
        $user->first_name = $body['display_name'];
        $user->email = $body['email'];
        $user->bio = $body['bio'];
        $user->avatar = $body['logo'];
        $user->save();
        $twitchUserId = $body['_id'];
        $result = $guzzle->request('GET', 'https://api.twitch.tv/kraken/streams/' . $twitchUserId);
        $body = json_decode((string) $result->getBody(), true);
        \Log::info('STREAMS');
        \Log::info($body);
        $streamer->twitch_id = $twitchUserId;
        $streamer->game = isset($body['stream']['channel']['game']) ? strtolower($body['stream']['channel']['game']) : null;
        $streamer->save();
        $user->addProgress(new FirstLoginAchievement(), 1);
        if (!$this->alreadyToday('Login10daysAchievement', $user)) {
            $user->addProgress(new Login10daysAchievement(), 1);
        }
        if (!$this->alreadyToday('Login20daysAchievement', $user)) {
            $user->addProgress(new Login20daysAchievement(), 1);
        }
        $token = auth()->login($user);
        $data = [
            'access_token'  => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
        \Log::info('token='.$token);
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

    private function alreadyToday($achivementName, $user)
    {
        if ($this->isFirst($achivementName)) {
            return false;
        }
        $class = $this->getClass($achivementName);
        $achivement = $user->achievements($class)->first();
        if  (!$achivement) {
            return false;
        }
        $updated   = $achivement->updated_at->toDateString();
        $now = new Carbon;
        $today = $now->toDateString();
        return ($today === $updated);
    }

    private function getClass($achivementName)
    {
        $class = "\App\Achievements\\" . $achivementName;
        return new $class;
    }

    private function isFirst($achivementName)
    {
        $class = "App\Achievements\\" . $achivementName;
        $count = \DB::table('achievement_details')->where('class_name', $class)->count();
        return ($count === 0);
    }
}

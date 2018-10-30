<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;

use App\Models\{User, SmsCode, Afiliate, Achievement, AchievementProgres};
use App\Achievements\{AccountVerifiedAchievement, FirstReferViewerAchievement, Refer100ViewersAchievement};

class SmsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['get']]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    public function getSms(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'phone'             => 'required|min:10|max:14'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }
        $phone = $request->phone;
        $user = auth()->user();
        $viewer = $user->viewer()->first();
        $viewer->phone = $phone;
        $viewer->save();
        // sending SMD
        $sms = SmsCode::where('user_id', $user->id)->first();
        if (!$sms) {
            $sms = new SmsCode();
        }
        $sms->user_id = $user->id;
        $sms->phone = $phone;
        $sms->code = $this->genCode();
        $sms->save();
        return response()->json([
            'message' => 'sms sended to phone ' . $phone,
        ]);
    }

    public function checkCode(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'code'             => 'required|min:1|max:50'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $user = auth()->user();
        $sms = SmsCode::where('user_id', $user->id)->first();
        if (!$sms) {
            return response()->json([
                'errors' => 'code not sended',
            ]);
        }
        if ($request->code !== $sms->code) {
            return response()->json([
                'errors' => 'wrong code',
            ]);
        }
        $sms->delete();
        $viewer = $user->viewer()->first();
        $viewer->phone_verified = 1;
        $viewer->save();
        $user->addAchievement('App\Achievements\AccountVerifiedAchievement');
        $afiliate = Afiliate::where('afiliate_id', $user->id)->whereNull('confirm_at')->first();
        if ($afiliate) {
            $afiliate->confirm_at = Carbon::now()->toDateTimeString();
            $afiliate->save();
            $userReferal = User::find($afiliate->user_id);
            $user->addAchievement('App\Achievements\FirstReferViewerAchievement');
            $user->addAchievement('App\Achievements\Refer100ViewersAchievement');
            $viewerReferal = $userReferal->viewer()->first();
            $viewerReferal->addPoints([
                'points'    => 10,
                'title'     => 'Referals',
                'description'   => 'Referal virified',
            ]);
            $viewerReferal->save();
        }
        return response()->json([
            'message' => 'code correct',
        ]);
    }

    private function genCode()
    {
        $length = 5;
        $symbols = '/\d|\w/';
        $code = '';
        do {
            $char = str_random(1);
            $code .= preg_match($symbols, $char) === 1 ? $char : '';
        } while(strlen($code) < $length);
        return $code;
    }
 
}

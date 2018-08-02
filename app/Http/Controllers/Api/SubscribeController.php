<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Carbon\Carbon;

use App\Models\{User, Streamer, SubscriptionPlan, MonthPlan, SubscribedStreamers};

class SubscribeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
        header("Access-Control-Allow-Origin: " . getOrigin($_SERVER));
    }

    public function listMonthPlans(Request $request)
    {
        $data = MonthPlan::all();
        return response()->json([
            'data' => [
                'month_plans' => $data,
            ],
        ]);
    }
    
    public function listSubscriptionPlans(Request $request)
    {
        $data = SubscriptionPlan::all();
        return response()->json([
            'data' => [
                'subscription_plans' => $data,
            ],
        ]);
    }

    public function adminSubscribe(Request $request) {
        $validator = Validator::make($request->all(),
            [
                'user_id'   =>  'required|numeric|min:1',
                'subscription_plan_id'   =>  'required|numeric|min:1',
                'month_plan_id'   =>  'required|numeric|min:1',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json([
                'errors' => ['user not found'],
            ]);
        }
        $subscribe = new SubscribedStreamers();
        $streamerId = $user->streamer()->first()->id;
        $subscribe->streamer_id = $streamerId;
        $subscribe->subscription_plan_id = $request->subscription_plan_id;
        $subscribe->month_plan_id = $request->month_plan_id;
        $monthPlan = MonthPlan::find($request->month_plan_id);
        $old = SubscribedStreamers::where([
            ['streamer_id', '=', $streamerId],
            ['valid_until', '>', Carbon::today()->toDateTimeString()]
        ])->orderBy('valid_until', 'desc')->first();
        if ($old) {
            $subscribe->valid_from = $old->valid_until;
        } else {
            $subscribe->valid_from = Carbon::today()->toDateTimeString();
        }
        $toDate = new Carbon($subscribe->valid_from);
        $toDate->addMonths($monthPlan->monthes);
        $subscribe->valid_until = $toDate->toDateTimeString();
        $subscribe->save();
        \Log::info('saved subscription ' . $subscribe->id);
        return response()->json([
            'message' => [
                'subscription created',
            ],
        ]);
        
    }
}

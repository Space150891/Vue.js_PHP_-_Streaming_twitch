<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

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
}

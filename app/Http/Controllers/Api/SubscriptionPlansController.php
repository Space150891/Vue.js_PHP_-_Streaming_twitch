<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{SubscriptionPlan};


class SubscriptionPlansController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = SubscriptionPlan::all();
        return response()->json(['data' => [
            'plans' => $plans,
        ]]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'points'                => 'required|numeric',
                'subscription_plan_id'  => 'required|numeric',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $plan = SubscriptionPlan::find($request->subscription_plan_id);
        if (!$plan) {
            return response()->json([
                'errors' => ['subscription plan not found'],
            ]);
        }
        $plan->points = $request->points;
        $plan->save();
        return response()->json(['message' => 'subscription plan updated']);
    }

}
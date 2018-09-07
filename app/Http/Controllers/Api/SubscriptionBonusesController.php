<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Models\{SubscriptionPlan, SubscriptionPoint};


class SubscriptionBonusesController extends Controller
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
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
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
                'errors' => ['subscription plan not found ' . $request->subscription_plan_id],
            ]);
        }
        $points = SubscriptionPoint::where('subscription_plan_id', $request->subscription_plan_id)->get();
        return response()->json(['data' => [
            'points' => $points,
        ]]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'subscription_plan_id'  => 'required|numeric',
                'from_viewers'          => 'required|numeric',
                'to_viewers'            => 'required|numeric',
                'points'                => 'required|numeric',
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
                'errors' => ['subscription plan not found'  . $request->subscription_plan_id],
            ]);
        }
        $find = false;
        $pointShemes = SubscriptionPoint::where('subscription_plan_id', $request->subscription_plan_id)->get();
        foreach ($pointShemes as $pointSheme) {
            if (
                $pointSheme->from_viewers <= $request->to_viewers 
                && $pointSheme->to_viewers >= $request->from_viewers 
                ) {
                $find = true;
            }
        }
        if ($find) {
            return response()->json([
                'errors' => ['range wrong'],
            ]);
        }
        $subscriptionPoint = new SubscriptionPoint();
        $subscriptionPoint->subscription_plan_id = $request->subscription_plan_id;
        $subscriptionPoint->from_viewers = $request->from_viewers;
        $subscriptionPoint->to_viewers = $request->to_viewers;
        $subscriptionPoint->points = $request->points;
        $subscriptionPoint->save();
        return response()->json(['message' => 'subscription plan points created']);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'subscription_point_id' => 'required|numeric',
                'from_viewers'          => 'required|numeric',
                'to_viewers'            => 'required|numeric',
                'points'                => 'required|numeric',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $subscriptionPoint = SubscriptionPoint::find($request->subscription_point_id);
        if (!$subscriptionPoint) {
            return response()->json([
                'errors' => ['subscription points scheme not found ' . $request->subscription_point_id],
            ]);
        }
        $plan = SubscriptionPlan::find($subscriptionPoint->subscription_plan_id);
        $find = false;
        $pointShemes = SubscriptionPoint::where('subscription_plan_id', $request->subscription_plan_id)->get();
        foreach ($pointShemes as $pointSheme) {
            if (
                $pointSheme->from_viewers <= $request->to_viewers 
                && $pointSheme->to_viewers >= $request->from_viewers 
                && $pointSheme->id != $subscriptionPoint->id
                ) {
                $find = true;
            }
        }
        if ($find) {
            return response()->json([
                'errors' => ['range wrong'],
            ]);
        }
        $subscriptionPoint->from_viewers = $request->from_viewers;
        $subscriptionPoint->to_viewers = $request->to_viewers;
        $subscriptionPoint->points = $request->points;
        $subscriptionPoint->save();
        return response()->json(['message' => 'subscription plan points updated']);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'subscription_point_id' => 'required|numeric',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $subscriptionPoint = SubscriptionPoint::find($request->subscription_point_id);
        if (!$subscriptionPoint) {
            return response()->json([
                'errors' => ['subscription points scheme not found'],
            ]);
        }
        $subscriptionPoint->delete();
        return response()->json(['message' => 'subscription plan points deleted']);
    }

    private function checkRange($request)
    {
        $find = false;
        $updatedId = $request->has('subscription_point_id') ? $request->subscription_point_id : false;
        $pointShemes = SubscriptionPoint::where('subscription_plan_id', $request->subscription_plan_id)->get();
        foreach ($pointShemes as $pointSheme) {
            if (
                $pointSheme->from_viewers <= $request->to_viewers 
                && $pointSheme->to_viewers > $request->from_viewers 
                && $updatedId != $request->subscription_point_id
                ) {
                $find = true;
            }
        }
        return !$find;
    }

}
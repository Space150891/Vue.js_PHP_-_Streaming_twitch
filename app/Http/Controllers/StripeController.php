<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\{User, Streamer, SubscriptionPlan, MonthPlan, SubscribedStreamers, Payment, Diamond};

class StripeController extends Controller
{
    public function subscribe (Request $request){
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['error'=>'user not found!'], 500);
        }
        $subscriptionPlan = SubscriptionPlan::find($request->plan);
        $monthPlan = MonthPlan::find($request->discount);
        $stripeId = $subscriptionPlan->name . '-' . $monthPlan->monthes;
        $planName = false;
        foreach (config('stripe') as $plan) {
            if ($plan['id'] == $stripeId) {
                $planName = $plan['name'];
            }
        }
        if (!$planName) {
            \Log::info('did dot find stripe plan id = ' . $stripeId);
            return response()->json(['error' => 'stripe id not found!'], 500);
        }
        $res = $user->newSubscription('main', $stripeId)
                ->create($request->token['id']);
        $payment = new Payment();
        $data = [
            'subscription_plan_id'  => $request->plan,
            'month_plan_id'         => $request->discount,
            'service'    => 'stripe'
        ];
        $payment->details = json_encode($data);
        $payment->user_id = $request->user_id;
        $payment->type = 'subscription';
        $payment->status = "draft";
        $payment->save();
        if (isset($res['stripe_plan']) && $res['stripe_plan'] == $stripeId) {
            $payment->status = "Done";
            $payment->save();
            $streamer = $user->streamer()->first();
            $details = json_decode($payment->details, true);
            $subscribed = new SubscribedStreamers();
            $subscribed->streamer_id = $streamer->id;
            $subscribed->subscription_plan_id = $request->plan;
            $subscribed->month_plan_id = $request->discount;
            $subscribed->valid_from = Carbon::today()->toDateTimeString();
            $toDate = new Carbon($subscribed->valid_from);
            $toDate->addMonths($monthPlan->monthes);
            $subscribed->valid_until = $toDate->toDateTimeString();
            $subscribed->save();
        }
        return response()->json($res);
    }
}

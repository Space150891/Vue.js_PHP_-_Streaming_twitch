<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Requests\LiqpayFormRequest;
use Illuminate\Http\Request;
use LiqPay;
use App\Models\{User, Streamer, SubscriptionPlan, MonthPlan, SubscribedStreamers, Payment, Diamond};
use App\Achievements\{BuyFirstDiamondsAchievement, Buy100DiamondsAchievement};

class LiqpayController extends Controller
{
    public function genSubscribeForm(LiqpayFormRequest $request)
    {
        $public_key = env('LIQPAY_PUBLIC_KEY');
        $private_key = env('LIQPAY_PRIVATE_KEY');
        $resultUrl = env('LIQPAY_RUSULT_URL');
        $serverUrl = env('LIQPAY_SERVER_URL');
        $lang = env('LIQPAY_LANG');
        $sandbox = env('LIQPAY_SANDBOX') ? '1' : null;
        $liqpay = new LiqPay($public_key, $private_key);
        $now = new Carbon();
        $amount = $request->amount;
        $subscriptionPlan = SubscriptionPlan::find($request->subscription_plan_id);
        $monthPlan = MonthPlan::find($request->month_plan_id);
        $payment = new Payment();
        $data = [
            'subscription_plan_id'  => $request->subscription_plan_id,
            'month_plan_id'         => $request->month_plan_id,
            'service'    => 'liqpay'
        ];
        $payment->details = json_encode($data);
        $payment->user_id = $request->user_id;
        $payment->type = 'subscription';
        $payment->status = "draft";
        $payment->save();
        $html = $liqpay->cnb_form(array(
            'version'=>'3',
            'action'         => 'subscribe',
            'amount'         => $amount, // сумма заказа
            'currency'       => 'USD',
            'description'    => 'Subscribe pay',
            'order_id'       => $payment->id,
            'subscribe'            => '1',
            'subscribe_date_start' => $now->format('Y-m-d H:i:s'),
            'subscribe_periodicity'=> $monthPlan->month == 12 ? 'year' : 'month',
            'result_url'	=>	$resultUrl,
            'server_url'	=>	$serverUrl,
            'language'		=>	$lang,
            'sandbox'       =>  $sandbox,
        ));
        return response()->json([
            'data' => [
                'form' => $html,
            ],
        ]);
    }

    public function acceptSubscribe(Request $request)
    {
        $data = $request->data;
        $signature = $request->signature;
        $public_key = env('LIQPAY_PUBLIC_KEY');
        $private_key = env('LIQPAY_PRIVATE_KEY');
        $testSignature = base64_encode(sha1($private_key . $data . $private_key, 1));
        if ($testSignature === $signature) {
            $data = json_decode($data, true);
            $payment = Payment::find($data['order_id']);
            $payment->status = 'Done';
            $payment->save();
            $user = User::find($payment->user_id);
            $streamer = $user->streamer()->first();
            $details = json_decode($payment->details, true);
            $sPlanId = $details['subscription_plan_id'];
            $mPlanId = $details['month_plan_id'];
            $subscribed = new SubscribedStreamers();
            $subscribed->streamer_id = $streamer->id;
            $subscribed->subscription_plan_id = $sPlanId;
            $subscribed->month_plan_id = $mPlanId;
            $subscribed->valid_from = Carbon::today()->toDateTimeString();
            $toDate = new Carbon($subscribed->valid_from);
            $toDate->addMonths($monthPlan->monthes);
            $subscribed->valid_until = $toDate->toDateTimeString();
            $subscribed->save();
        } else {
            \Log::info('bad signature');
        }
    }

}

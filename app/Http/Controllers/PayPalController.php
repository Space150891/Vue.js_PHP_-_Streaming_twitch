<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\{User, Streamer, SubscriptionPlan, MonthPlan, SubscribedStreamers, Payment, Diamond};
use App\Achievements\{BuyFirstDiamondsAchievement, Buy100DiamondsAchievement};

class PayPalController extends Controller
{
    /**
     * @var ExpressCheckout
     */
    protected $provider;

    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getExpressCheckout(Request $request)
    {
        if (!$request->has('type') || !$request->has('user_id')) {
            return redirect('/');
        }
        if ((!$request->has('subscription_plan_id') || !$request->has('month_plan_id')) && $request->type == "subscription") {
            return redirect('/#/subscribe');
        }
        if (!$request->has('diamonds_set_id') && $request->type == "buy_diamonds") {
            return redirect('/#/shop');
        }
        $recurring = false;
        $user = User::find($request->user_id);
        $userId = $user->id;
        $payment = new Payment();
        if ($request->type == 'buy_diamonds') {
            $data = ['diamonds_set_id'  =>  $request->diamonds_set_id, 'service'    => 'paypal'];
            $payment->details = json_encode($data);
        }
        if ($request->type == 'subscription') {
            $data = [
                'subscription_plan_id'  => $request->subscription_plan_id,
                'month_plan_id'         => $request->month_plan_id,
                'service'    => 'paypal'
            ];
            $payment->details = json_encode($data);
        }
        $payment->user_id = $userId;
        $payment->type = $request->type;
        $payment->status = "draft";
        $payment->save();
        $form = [
            'type'                  =>  $payment->type,
            'details'               =>  $payment->details,
            'user_id'               =>  $userId,
            'id'                    =>  $payment->id,
        ];
        $cart = $this->getCheckoutData($form, $recurring);
        try {
            $response = $this->provider->setExpressCheckout($cart, $recurring);
            if (!isset($response['paypal_link'])) {
                dd($response);
            }
            $payment->token = $response['TOKEN'];
            $payment->status = "ready";
            $payment->save();
            return redirect($response['paypal_link']);
        } catch (\Exception $e) {
            // error in payments
            dd($e);
        }
    }

    /**
     * Process payment on PayPal.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getExpressCheckoutSuccess(Request $request)
    {
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $token = $request->get('token');
        $payment = Payment::where('token', $token)->first();
        $form = [
            'type'                  => $payment->type,
            'details'               =>  $payment->details,
            'user_id'               =>  $payment->user_id,
            'id'                    =>  $payment->id,
        ];
        $PayerID = $request->get('PayerID');
        $cart = $this->getCheckoutData($form, $recurring);
        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            if ($recurring === true) {
                $response = $this->provider->createMonthlySubscription($response['TOKEN'], 9.99, $cart['subscription_desc']);
                if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                    $status = 'Processed';
                } else {
                    $status = 'Invalid';
                }
            } else {
                // Perform transaction on PayPal
                $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
                if (!isset($payment_status['PAYMENTINFO_0_PAYMENTSTATUS'])) {
                    dd($payment_status);
                }
                $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
            }

            if (trim($status) === 'Completed') {
                $payment->status = "Done";
                $payment->save();
                if ($payment->type == 'buy_diamonds') {
                    $user = User::find($payment->user_id);
                    $viewer = $user->viewer()->first();
                    $details = json_decode($payment->details, true);
                    $set = Diamond::find($details['diamonds_set_id']);
                    $viewer->diamonds += $set->amount;
                    $viewer->save();
                    $user->addProgress(new BuyFirstDiamondsAchievement(), 1);
                    $user->addProgress(new Buy100DiamondsAchievement(), $set->amount);
                    return redirect('/#/shop');
                }
                if ($payment->type == 'subscription') {
                    $user = User::find($payment->user_id);
                    $streamer = $user->streamer()->first();
                    $details = json_decode($payment->details, true);
                    $sPlanId = $details['subscription_plan_id'];
                    $mPlanId = $details['month_plan_id'];
                    $subscribed = new SubscribedStreamers();
                    $subscribed->streamer_id = $streamer->id;
                    $subscribed->subscription_plan_id = $sPlanId;
                    $subscribed->month_plan_id = $mPlanId;
                    $monthPlan = MonthPlan::find($mPlanId);
                    $old = SubscribedStreamers::where([
                        ['streamer_id', '=', $streamer->id],
                        ['valid_until', '>', Carbon::today()->toDateTimeString()]
                    ])->orderBy('valid_until', 'desc')->first();
                    if ($old) {
                        $subscribed->valid_from = $old->valid_until;
                    } else {
                        $subscribed->valid_from = Carbon::today()->toDateTimeString();
                    }

                    $toDate = new Carbon($subscribed->valid_from);
                    $toDate->addMonths($monthPlan->monthes);
                    $subscribed->valid_until = $toDate->toDateTimeString();
                    $subscribed->save();
                    return redirect('/#/subscribe');
                }
            }
            return redirect('/');
        }
    }

    

    /**
     * Parse PayPal IPN.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function notify(Request $request)
    {
        if (!($this->provider instanceof ExpressCheckout)) {
            $this->provider = new ExpressCheckout();
        }

        $request->merge(['cmd' => '_notify-validate']);
        $post = $request->all();

        $response = (string) $this->provider->verifyIPN($post);

        $logFile = 'ipn_log_'.Carbon::now()->format('Ymd_His').'.txt';
        Storage::disk('local')->put($logFile, $response);
    }

    /**
     * Set cart data for processing payment on PayPal.
     *
     * @param bool $recurring
     *
     * @return array
     */
    protected function getCheckoutData($form, $recurring = false)
    {
        $data = [];
        if ($form['type'] == 'subscription') {
            $details = json_decode($form['details'], true);
            $subscriptionPlan = SubscriptionPlan::find($details['subscription_plan_id']);
            $monthPlan = MonthPlan::find($details['month_plan_id']);
            $name = 'Subscription ' . $subscriptionPlan->name . ' months ' . $monthPlan->monthes;
            $price = round($subscriptionPlan->cost * $monthPlan->monthes * (100 - $monthPlan->percent) / 100, 2);
            $description = 'Subscription ' . $subscriptionPlan->name . ' months ' . $monthPlan->monthes;
        }
        if ($form['type'] == 'buy_diamonds') {
            $details = json_decode($form['details'], true);
            $set = Diamond::find($details['diamonds_set_id']);
            $name = 'Buy ' . $set->amount . ' diamonds';
            $price = $set->cost;
            $description = $name;
        }
        $data['items'] = [
            [
                'name'  => $name,
                'price' => $price,
                'qty'   => 1,
            ],
        ];
        $data['return_url'] =config('paypal.redirect_url');
        // $data['invoice_id'] = $form['id'];
        $data['invoice_id'] = uniqid();
        $data['invoice_description'] = $description;
        $data['cancel_url'] = url('/');
        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }
        $data['total'] = $total;
        return $data;
    }

}

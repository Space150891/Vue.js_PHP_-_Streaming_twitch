<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\{User, Streamer, SubscriptionPlan, MonthPlan, SubscribedStreamers, Payment};

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
        if (!$request->has('subscription_plan_id') || !$request->has('month_plan_id') || !$request->has('streamer_id')) {
            return redirect('/#/subscribe');
        }
        if ($request->subscription_plan_id == 0 || $request->month_plan_id == 0 || $request->streamer_id == 0) {
            return redirect('/#/subscribe');
        }
        $recurring = false;
        $payment = new Payment();
        $payment->subscription_plan_id = $request->subscription_plan_id;
        $payment->month_plan_id = $request->month_plan_id;
        $payment->streamer_id = $request->streamer_id;
        $payment->type = "paypal";
        $payment->status = "draft";
        $payment->save();
        $form = [
            'subscription_plan_id'  => $request->subscription_plan_id,
            'month_plan_id'         =>  $request->month_plan_id,
            'streamer_id'           =>  $request->streamer_id,
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
            'subscription_plan_id'  => $payment->subscription_plan_id,
            'month_plan_id'         =>  $payment->month_plan_id,
            'streamer_id'           =>  $payment->streamer_id,
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
                $subscribed = new SubscribedStreamers();
                $subscribed->streamer_id = $payment->streamer_id;
                $subscribed->subscription_plan_id = $payment->subscription_plan_id;
                $subscribed->month_plan_id = $payment->month_plan_id;
                $monthPlan = MonthPlan::find($payment->month_plan_id);
                $now = new Carbon();
                $now->addMonths($monthPlan->monthes);
                $subscribed->valid_until = $now->toDateTimeString();
                $subscribed->save();
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
        $subscriptionPlan = SubscriptionPlan::find($form['subscription_plan_id']);
        $monthPlan = MonthPlan::find($form['month_plan_id']);
        $data = [];
        $data['items'] = [
            [
                'name'  => 'Subscription ' . $subscriptionPlan->name . ' monthes ' . $monthPlan->monthes,
                'price' => round($subscriptionPlan->cost * $monthPlan->monthes * (100 - $monthPlan->percent) / 100, 2),
                'qty'   => 1,
            ],
        ];
        $data['return_url'] = 'http://localhost:8081/paypal/success';
        $data['invoice_id'] = $form['id'];
        $data['invoice_description'] = 'Subscription ' . $subscriptionPlan->name . ' monthes ' . $monthPlan->monthes;
        $data['cancel_url'] = url('/');
        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }
        $data['total'] = $total;
        return $data;
    }
}

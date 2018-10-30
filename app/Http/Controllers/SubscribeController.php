<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Models\User;
use App\Http\Requests\SibscribeFormRequest;

class SubscribeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Cashier::useCurrency('usd', '$');
    }

    public function index(Request $request)
    {
        return view('pages.user.subscribe');
    }

    public function makePayment(SibscribeFormRequest $request)
    {
        $user = \Auth::user();
        // $stripeKey = config('services.stripe.key');
        $stripeSecret = config('services.stripe.secret');
        $planeVip = config('services.stripe.vip');
        \Stripe\Stripe::setApiKey($stripeSecret);
        $token = \Stripe\Token::create([
            "card" => [
              "number" => $request->number,
              "exp_month" => $request->exp_month,
              "exp_year" => $request->exp_year,
              "cvc" => $request->cvc,
            ]
        ]);
        $message = "";
        
        if ($user->subscribed('vip')) {
            $message = trans('subscribe.always');
        } else {
            $user->newSubscription('vip', 'plan_Czf8bIU23j1pLq')->create($token->id, [
                'email' => $user->email,
            ]);
            $user->updateCard($token->id);
            $message = trans('subscribe.OK');
        }
        $data = [
            'message'   =>  $message,
        ];
        return view('pages.user.subscribeOK', $data);
    }

}

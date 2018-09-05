<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use LiqPay;
use App\Models\{User, Streamer, SubscriptionPlan, MonthPlan, SubscribedStreamers, Payment, Diamond};
use App\Achievements\{BuyFirstDiamondsAchievement, Buy100DiamondsAchievement};

class LiqpayController extends Controller
{
    public function genSubscribeForm(Request $request)
    {
        // not ready
        $public_key = env('LIQPAY_PUBLIC_KEY');
        $private_key = env('LIQPAY_PRIVATE_KEY');
        $resultUrl = env('LIQPAY_RUSULT_URL');
        $serverUrl = env('LIQPAY_SERVER_URL');
        $lang = env('LIQPAY_LANG');
        $sandbox = env('LIQPAY_SANDBOX') ? '1' : null;
        $liqpay = new LiqPay($public_key, $private_key);
        $now = new Carbon();
        $html = $liqpay->cnb_form(array(
            'version'=>'3',
            'action'         => 'subscribe',
            'amount'         => '33', // сумма заказа
            'currency'       => 'USD',
            'description'    => 'Оплата заказа № 3', 
            'order_id'       => '3',
            'subscribe'            => '1',
            'subscribe_date_start' => $now->format('Y-m-d H:i:s'),
            'subscribe_periodicity'=> 'month',
            'result_url'	=>	$resultUrl,
            'server_url'	=>	$serverUrl,
            'language'		=>	$lang,
            'sandbox'       =>  $sandbox,
            ));

            return response()->json([
                'data' => [
                    'form'       => $html,
                ],
            ]);
    }

    public function acceptSubscribe(Request $request)
    {
        
    }
    
}
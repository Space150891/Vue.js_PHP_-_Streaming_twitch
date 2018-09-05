<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe\Stripe;
use App\Models\{Profile, User, Viewer, Streamer, Game, ViewerItem, Activity, Item, Notification, SubscribedStreamers};
use GuzzleHttp\Client as Guzzle;
use LiqPay;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'try';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $public_key = env('LIQPAY_PUBLIC_KEY');
        $private_key = env('LIQPAY_PRIVATE_KEY');
        $sandbox = env('LIQPAY_SANDBOX') ? '1' : null;
        $liqpay = new LiqPay($public_key, $private_key);
        $html = $liqpay->cnb_form(array(
            'version'=>'3',
            'action'         => 'subscribe',
            'amount'         => '33', // сумма заказа
            'currency'       => 'UAH',
            'description'    => 'Оплата заказа № 3', 
            'order_id'       => '3',
            'subscribe'            => '1',
            'subscribe_date_start' => '2015-03-31 00:00:00',
            'subscribe_periodicity'=> 'month',
            'result_url'	=>	'http://mydomain.site/thank_you_page/',
            'server_url'	=>	'http://mydomain.site/liqpay_status/',
            'language'		=>	'ru', // uk, en
            'sandbox'=> $sandbox
            ));
        var_dump($html);

    }

}

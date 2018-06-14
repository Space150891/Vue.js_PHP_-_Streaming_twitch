<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stripe\Stripe;

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
        echo "\n start testing stripe \n";
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        // creating product
        // $product = \Stripe\Product::create([
        //     'name' => 'Online Streamer Promotion Platform',
        //     'type' => 'service',
        // ]);

        // $plan = \Stripe\Plan::create([
        //     'product' => $product->id,
        //     'nickname' => 'OSPP Platform VIP USD',
        //     'interval' => 'month',
        //     'currency' => 'usd',
        //     'amount' => 10,
        //   ]);

        $source = \Stripe\Source::create([
            "type" => "ideal",
            "currency" => "usd",
            "owner" => array(
              "email" => "jenny.rosen@example.com"
            )
        ]);
        $customer = \Stripe\Customer::create([
            'email' => 'johd.doe@example.com',
            'source' => $source->id,
        ]);

        var_dump($customer);
    }
}

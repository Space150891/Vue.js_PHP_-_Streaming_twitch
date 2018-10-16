<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe\Stripe;
use App\Models\{Profile, User, Viewer, Streamer, Game, ViewerItem, Activity, Item, SubscribedStreamers};
use GuzzleHttp\Client as Guzzle;
use LiqPay;

class StripeCreatePlansCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating stripe plans by Stripe API';

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
        $this->stripeCreatePlans();
    }

    private function stripeCreatePlans()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $plans = \Stripe\Plan::all();
        foreach ($plans->data as $plan) {
            $plan->delete();
        }
        $this->stripeShowPlansList();
        $data = config('stripe');
        echo "\n Created Stripe plans: \n";
        foreach ($data as $d) {
            $this->stripePlanCreate($d);
        }
        $this->stripeShowPlansList();
    }

    private function stripeShowPlansList()
    {
        $res = \Stripe\Plan::all(array("limit" => 10));
        foreach ($res->data as $r) {
            echo "id={$r->id}, active {$r->active}, {$r->amount}, {$r->interval} - {$r->interval_count} \n";
        }
    }

    private function stripePlanCreate($data)
    {
        $res = \Stripe\Plan::create([
            "amount"            => $data['amount'],
            "interval"          => $data['interval'],
            "interval_count"    =>  $data['interval_count'],
            "product"           => [
                "name" => $data['name'],
            ],
            "currency"          => $data['currency'],
            "id"                => $data['id'],
        ]);
        return $res;
    }

}

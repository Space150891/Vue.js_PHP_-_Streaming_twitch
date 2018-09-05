<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe\Stripe;
use App\Models\{Profile, User, Viewer, Streamer, Game, ViewerItem, Activity, Item, Notification, SubscribedStreamers};
use GuzzleHttp\Client as Guzzle;
use LiqPay;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Http\Controllers\WSController;
use RuntimeException;

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
        
    }

}

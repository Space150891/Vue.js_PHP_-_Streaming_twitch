<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use App\Models\{Activity, Item, ViewerItem, Viewer, Streamer, Notification};
// use Carbon\Carbon;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Http\Controllers\WSController;

class StartWSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start web-socket server';

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
        $port = 8080;
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WSController()
                )
            ),
            $port
        );
        echo "\n starting WS on port {$port}\n";
        $server->run();
    }

}

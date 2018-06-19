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
       echo config('database.connections.mysql.host') . "\n";
       echo config('database.connections.mysql.port') . "\n";
       echo config('database.connections.mysql.username') . "\n";
       echo config('database.connections.mysql.password') . "\n";
       echo env('DB_CONNECTION') . "\n";
    }
}

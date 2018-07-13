<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stripe\Stripe;
use App\Models\Streamer;

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
        
        $password = \Hash::make('123');
        echo $password;
        $user = \App\Models\User::find(3);
        $user->password = $password;
        $user->save();
        $user = \App\Models\User::find(4);
        $user->password = $password;
        $user->save();
    }
}

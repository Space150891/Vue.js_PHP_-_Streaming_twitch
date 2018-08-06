<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe\Stripe;
use App\Models\{Profile, User, Viewer, Streamer, Game, ViewerItem};
use GuzzleHttp\Client as Guzzle;

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
        echo $this->genCode() . "\n";
    }

    private function genCode()
    {
        $length = 5;
        $symbols = '/\d|\w/';
        $code = '';
        do {
            $char = str_random(1);
            $code .= preg_match($symbols, $char) === 1 ? $char : '';
        } while(strlen($code) < $length);
        return $code;
    }

}

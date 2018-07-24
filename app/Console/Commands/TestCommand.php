<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe\Stripe;
use App\Models\{Profile, User, Viewer, Streamer, Game};
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\Redis;

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
    //    $this->emitEvent();
        $streamers = Streamer::all();
        foreach ($streamers as $streamer) {
            echo $streamer->name ."\n";
        }
    }

    private function emitEvent()
    {
        $data = [
            'event_type'      => 'user_message',
            'message'         => 'test ' . time(),
            'user_name'       => 'alex_k2017',
            'timestamp'       => time(),
        ];
        Redis::command('RPUSH', ['messages:' . $data['user_name'], json_encode($data)]);
    }

    private function increaseAchivements($name, $points)
    {
        $class = "\App\Achievements\\" . $name;
        $a = new $class;
    }
}

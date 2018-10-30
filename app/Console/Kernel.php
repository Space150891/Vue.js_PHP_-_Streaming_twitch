<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\TestCommand',
        'App\Console\Commands\FakeStreamersCommand',
        'App\Console\Commands\DailyWinerCommand',
        'App\Console\Commands\StartWSCommand',
        'App\Console\Commands\StripeCreatePlansCommand',
        'App\Console\Commands\EmulateCommand',
        'App\Console\Commands\UploadItemsCommand',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // $schedule->command('activations:clean')->daily();
        $schedule->command('viewers:daily_winner')->daily();
        // $schedule->command('ws:start')->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}

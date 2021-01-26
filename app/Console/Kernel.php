<?php

namespace App\Console;

use App\Console\Commands\RemoveExpiredLinks;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RemoveExpiredLinks::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**
         * Runs every two hours to remove expired links
         */
        $schedule->call(function () {
            Artisan::call('remove:expired_links');
        })->everyTwoHours();
    }
}

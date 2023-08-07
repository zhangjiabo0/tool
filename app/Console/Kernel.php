<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('v2free:sign')->dailyAt('12:00')->sendOutputTo('/home/vagrant/code/tool/storage/logs/v2free_sign.log');
        //aliyunpan:sign
        $schedule->command('aliyunpan:sign')->dailyAt('12:01')->sendOutputTo('/home/vagrant/code/tool/storage/logs/aliyunpan_sign.log');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

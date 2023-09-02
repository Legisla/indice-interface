<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\DadosAbertosRetry;
use App\Console\Commands\DadosAbertosImport;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if(config('app.env') == 'production'){
            $schedule->command(DadosAbertosRetry::class)->dailyAt('03:00');
            $schedule->command(DadosAbertosImport::class,['--initiator=cron'])->saturdays()->at('00:00');;
        }else{
            $schedule->command(DadosAbertosRetry::class)->cron('0 3,6,9,12,15,19,21 * * *');
            $schedule->command(DadosAbertosImport::class,['--initiator=cron'])->dailyAt('00:00');
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

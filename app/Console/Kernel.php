<?php

namespace App\Console;
use App\Jobs\UpdateRotacionJob;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
     $schedule->job(new \App\Jobs\UpdateRotacionJob)
    ->cron('26 9,10 * * *') 
    ->timezone('America/Mexico_City');

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

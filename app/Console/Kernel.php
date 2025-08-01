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
    protected $commands = [
        \App\Console\Commands\BackupDatabaseCommand::class,
    ];
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new \App\Jobs\UpdateRotacionJob)
            ->cron('10 6,9 * * *')
            ->timezone('America/Mexico_City');

        $schedule->job(new \App\Jobs\accionesCorrectivasJob)->dailyAt('07:00');
        $schedule->command('backup:database')
            ->hourly()
            ->between('7:00', '19:00')
            ->days([1, 2, 3, 4, 5, 6]) // Lunes (1) a Sábado (6)
            ->appendOutputTo(storage_path('logs/backup.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

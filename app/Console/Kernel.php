<?php

namespace App\Console;

use App\Jobs\VacacionesRegistrosJob;
use App\Jobs\accionesCorrectivasJob;
use App\Jobs\AddWeek;
use App\Jobs\UpdateVacations;
use App\Jobs\reporteGeneral;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Mail;

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
        //save rotation daily
        $schedule->job(new \App\Jobs\UpdateRotacionJob)
            ->cron('10 6,9 * * *')
            ->timezone('America/Mexico_City');

        $schedule->job(new \App\Jobs\VacacionesRegistrosJob)->cron('1 0,7 * * *');

        $schedule->job(new \App\Jobs\accionesCorrectivasJob)->dailyAt('07:00');
        //Data base backup
        $schedule->command('backup:database')
            ->hourly()
            ->between('7:00', '20:00')
            ->days([1, 2, 3, 4, 5, 6])
            ->appendOutputTo(storage_path('logs/backup.log'));
            // creacion de listas de asistencia y registros
        $schedule->job(new \App\Jobs\AddWeek())->dailyAt('06:30');

        //weekly list assistence
       $schedule->job(new \App\Jobs\reporteGeneral())->dailyAt('06:30');
      // $schedule->job(new \App\Jobs\reporteGeneral())->everyMinute()->between('07:00', '20:00');

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

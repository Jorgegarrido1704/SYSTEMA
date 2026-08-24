<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
        // save rotation daily
        $schedule->job(new \App\Jobs\UpdateRotacionJob)
            ->cron('31 3,5,7 * * *')
            ->timezone('America/Mexico_City')
            ->onFailure(function () {
                Log::error('El job de rotación falló.');
            });

        $schedule->job(new \App\Jobs\VacacionesRegistrosJob)->cron('5 2,5,7,9 * * *')
            ->onFailure(function () {
                Log::error('El job de vacaciones falló.');
            });

        /*  $schedule->job(new \App\Jobs\reportemaquinasdecorte)
              ->everyTenMinutes()
              ->between('08:00', '16:00')
              ->days([1, 2, 3, 4, 5, 6]) // Lunes a Sábado
              ->timezone('America/Mexico_City')
              ->appendOutputTo(storage_path('logs/schedule.log')) // Crea un log específico
              ->onFailure(function () {
                  Log::error('El job de reporte de máquinas falló.');
              });
          */
        // $schedule->job(new \App\Jobs\accionesCorrectivasJob)->dailyAt('07:00');
        // Data base backup
        $schedule->command('backup:database')
            ->hourly()
            ->between('7:00', '20:00')
            ->days([1, 2, 3, 4, 5, 6])
            ->appendOutputTo(storage_path('logs/backup.log'));
        // creacion de listas de asistencia y registros
        // $schedule->job(new \App\Jobs\AddWeek)->dailyAt('08:15');
        $schedule->job(new \App\Jobs\AddWeek)->cron('15 5,6,7 * * *')
            ->onFailure(function () {
                Log::error('El job de creación de listas de asistencia y registros falló.');
            });
        // $schedule->job(new \App\Jobs\updateRoutingsTimes)->cron('1 21,22,23 * * *');
        $schedule->job(new \App\Jobs\updateRoutingsTimes)->cron('0 8,13,17 * * 1-5')
            ->timezone('America/Mexico_City')
            ->appendOutputTo(storage_path('logs/schedule.log'))
            ->onFailure(function () {
                Log::error('El job de actualización de rutas falló.');
            });

        $schedule->job(new \App\Jobs\respolados)->cron('1 6,18 * * *')
            ->onFailure(function () {
                Log::error('El job de respolados falló.');
            });

        // weekly list assistence
        $schedule->job(new \App\Jobs\reporteGeneral)->cron('45 6,9,13,17 * * 1-5')
         ->timezone('America/Mexico_City')
            ->onFailure(function () {
                Log::error('El job de reporte general falló.');
            });
        // $schedule->job(new \App\Jobs\reporteGeneral())->everyMinute()->between('07:00', '20:00');

        // acciones correctivas recordatorio de lunes a sabado a las 5:00 am
        $schedule->job(new \App\Jobs\accionesCorrectivasJob)->cron('21 4,7 * * *')
            ->onFailure(function () {
                Log::error('El job de acciones correctivas falló.');
            });
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

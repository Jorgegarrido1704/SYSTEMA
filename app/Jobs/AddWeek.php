<?php

namespace App\Jobs;

use App\Models\assistence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Models\personalBergsModel;


class AddWeek implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $week = carbon::now()->weekOfYear;
        $today = Carbon::now()->dayOfWeekIso;
        $days = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
        $day = $days[$today - 1];
        $registrosEmpleados = personalBergsModel::where('status', '!=', 'Baja')->get();
        foreach ($registrosEmpleados as $registroEmpleado) {
            if (assistence::where('week', '=', $week)->where('id_empleado', '=', $registroEmpleado->employeeNumber)->count() == 0) {
                assistence::insert([
                    'id_empleado' => $registroEmpleado->employeeNumber,
                    'week' => $week,
                    'lider' => $registroEmpleado->employeeLider,
                    'name' => $registroEmpleado->employeeName,
                ]);
                switch ($registroEmpleado->typeWorker) {
                    case 'Indirecto':
                        assistence::where('week', '=', $week)->where('id_empleado', '=', $registroEmpleado->employeeNumber)->update([$day => 'OK']);
                        break;
                    case 'Practicante':
                        assistence::where('week', '=', $week)->where('id_empleado', '=', $registroEmpleado->employeeNumber)->update([$day => 'PCT']);
                        break;
                    case 'Asimilado':
                        assistence::where('week', '=', $week)->where('id_empleado', '=', $registroEmpleado->employeeNumber)->update([$day => 'ASM']);
                        break;
                    case 'Servicio comprado':
                        assistence::where('week', '=', $week)->where('id_empleado', '=', $registroEmpleado->employeeNumber)->update([$day => 'SCE']);
                        break;
                }
            }
        }
    }
}

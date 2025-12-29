<?php

namespace App\Jobs;

use App\Models\assistence;
use App\Models\personalBergsModel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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

        $week = intval(date('W'));
        $year = $week <= 1 ? Carbon::now()->year + 1 : Carbon::now()->year;
        $today = Carbon::now()->dayOfWeekIso;
        $days = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        $day = $days[$today - 1];
        $dates = Carbon::now()->format('Y-m-d');
        $hollyDays = [
            '2026-01-01',
            '2025-12-12',
            '2025-12-25',
            '2025-12-26',
            '2026-01-02',
        ];

        $registrosEmpleados = personalBergsModel::where('status', '!=', 'Baja')->get();

        foreach ($registrosEmpleados as $registroEmpleado) {
            if (assistence::where('week', '=', $week)->where('id_empleado', '=', $registroEmpleado->employeeNumber)->count() == 0) {
                assistence::insert([
                    'id_empleado' => $registroEmpleado->employeeNumber,
                    'week' => $week,
                    'lider' => $registroEmpleado->employeeLider,
                    'name' => $registroEmpleado->employeeName,
                    'yearOfAssistence' => $year,
                ]);
            }
            if (in_array($dates, $hollyDays)) {
                assistence::where('week', '=', $week)
                    ->where('id_empleado', '=', $registroEmpleado->employeeNumber)
                    ->update([$day => 'PCS']);
            } else {
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

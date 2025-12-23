<?php

namespace App\Jobs;

use App\Models\personalBergsModel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class VacacionesRegistrosJob implements ShouldQueue
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
        $empleados = personalBergsModel::where('status', 'Activo')->get();

        $hoy = Carbon::now();
        $anio = $hoy->year;
        $nextYear = $anio + 1;

        foreach ($empleados as $emp) {
            $empleadoIngreso = Carbon::parse($emp->DateIngreso);
            $cumple = Carbon::createFromDate($anio, $empleadoIngreso->month, $empleadoIngreso->day);
            $difference = $cumple->diffInDays($hoy, false); // negativo si ya pasó

            $anosEnEmpleado = ($difference < 0) ? $anio - $empleadoIngreso->year : ($anio + 1) - $empleadoIngreso->year;

            // Determinar días de vacaciones según antigüedad
            $diasVacaciones = match (true) {
                $anosEnEmpleado == 1 => 12,
                $anosEnEmpleado == 2 => 14,
                $anosEnEmpleado == 3 => 16,
                $anosEnEmpleado == 4 => 18,
                $anosEnEmpleado == 5 => 20,
                $anosEnEmpleado > 5 && $anosEnEmpleado < 11 => 22,
                $anosEnEmpleado > 10 && $anosEnEmpleado < 15 => 24,
                $anosEnEmpleado > 15 && $anosEnEmpleado < 21 => 26,
                $anosEnEmpleado > 20 && $anosEnEmpleado < 25 => 28,
                $anosEnEmpleado > 25 && $anosEnEmpleado < 31 => 30,
                $anosEnEmpleado > 30 => 32,
                default => 0,
            };

            if ($difference < 0) {
                $absDifference = abs($difference);
                $diasVacacionesPendientes = intval(($diasVacaciones / 365) * (365 - $absDifference));

                $menos = DB::table('registro_vacaciones')
                    ->where(function ($q) use ($emp) {
                        $q->where('id_empleado', $emp->employeeNumber);
                    })
                    ->where('usedYear', $anio)
                    ->count();

                $total = $diasVacacionesPendientes + $emp->lastYear - $menos;
                $diasVacacionesPendientes -= $menos;

                DB::table('personalberg')
                    ->where('id', $emp->id)
                    ->update([
                        'currentYear' => $diasVacacionesPendientes,
                        'DaysVacationsAvailble' => $total,
                    ]);
            } else {
                $diasVacacionesPendientes = intval(($diasVacaciones / 365) * $difference);

                $menos = DB::table('registro_vacaciones')
                    ->where(function ($q) use ($emp) {
                        $q->where('id_empleado', $emp->employeeNumber);
                    })
                    ->where('usedYear', $nextYear)
                    ->count();

                $total = $emp->currentYear + $diasVacacionesPendientes + $emp->lastYear - $menos;
                $diasVacacionesPendientes -= $menos;

                DB::table('personalberg')
                    ->where('id', $emp->id)
                    ->update([
                        'nextYear' => $diasVacacionesPendientes,
                        'DaysVacationsAvailble' => $total,
                    ]);
            }

        }
    }
}

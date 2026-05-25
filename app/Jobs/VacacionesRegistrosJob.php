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
        $anoAnterior = $anio - 1;

        foreach ($empleados as $emp) {
            $empleadoIngreso = Carbon::parse($emp->DateIngreso);
            $cumple = Carbon::createFromDate($anio, $empleadoIngreso->month, $empleadoIngreso->day);
            $difference = $cumple->diffInDays($hoy, false); // negativo si ya pasó

            $anosEnEmpleado = ($difference < 0) ? $anio - $empleadoIngreso->year : $nextYear - $empleadoIngreso->year;
            $anosEmpleadoAnterios = ($difference < 0) ? $anoAnterior - $empleadoIngreso->year : $anio - $empleadoIngreso->year;

            function calcularDiasVacaciones($anos)
            {
                return match (true) {
                    $anos == 1 => 12,
                    $anos == 2 => 14,
                    $anos == 3 => 16,
                    $anos == 4 => 18,
                    $anos == 5 => 20,
                    $anos > 5 && $anos < 11 => 22,
                    $anos > 10 && $anos < 15 => 24,
                    $anos > 15 && $anos < 21 => 26,
                    $anos > 20 && $anos < 25 => 28,
                    $anos > 25 && $anos < 31 => 30,
                    $anos > 30 => 32,
                    default => 0,
                };
            }
            // Determinar días de vacaciones según antigüedad
            $diasVacaciones = calcularDiasVacaciones($anosEnEmpleado);
            $diasVacacionesAnteriores = calcularDiasVacaciones($anosEmpleadoAnterios);

            if ($difference < 0) {
                $absDifference = abs($difference);
                $diasVacacionesPendientes = intval(($diasVacaciones / 365) * (365 - $absDifference));

                $menos = DB::table('registro_vacaciones')
                    ->where(function ($q) use ($emp) {
                        $q->where('id_empleado', $emp->employeeNumber);
                    })
                    ->where('usedYear', $anio)
                    ->count();
                $menosAnoAnterios = DB::table('registro_vacaciones')
                    ->where(function ($q) use ($emp) {
                        $q->where('id_empleado', $emp->employeeNumber);
                    })
                    ->where('usedYear', $anoAnterior)
                    ->count();

                $total = $diasVacacionesPendientes + $diasVacacionesAnteriores - $menos - $menosAnoAnterios;
                $diasVacacionesAnteriores -= $menosAnoAnterios;

                $diasVacacionesPendientes -= $menos;

                DB::table('personalberg')
                    ->where('id', $emp->id)
                    ->update([
                        'lastYear' => $diasVacacionesAnteriores,
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

                $menosAnoAnterios = DB::table('registro_vacaciones')
                    ->where(function ($q) use ($emp) {
                        $q->where('id_empleado', $emp->employeeNumber);
                    })
                    ->where('usedYear', $anio)
                    ->count();

                $total = $diasVacacionesPendientes + $diasVacacionesAnteriores + $emp->lastYear - $menos - $menosAnoAnterios;
                $diasVacacionesPendientes -= $menos;
                $diasVacacionesAnteriores -= $menosAnoAnterios;

                DB::table('personalberg')
                    ->where('id', $emp->id)
                    ->update([
                        'currentYear' => $diasVacacionesAnteriores,
                        'nextYear' => $diasVacacionesPendientes,
                        'DaysVacationsAvailble' => $total,
                    ]);
            }

        }
    }
}

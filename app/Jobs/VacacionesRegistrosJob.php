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

    // 1. Dale más tiempo de vida al Job (ejemplo: 5 minutos / 300 segundos)
    public $timeout = 300;

    // 2. Define cuántas veces se puede reintentar antes de ir a 'failed_jobs'
    public $tries = 3;

    public function handle(): void
    {
        $hoy = Carbon::now();
        $anio = $hoy->year;
        $nextYear = $anio + 1;
        $anoAnterior = $anio - 1;

        // 3. Cambiamos ->get() por ->chunk() para liberar memoria y no saturar la base de datos
        personalBergsModel::where('status', 'Activo')->chunk(100, function ($empleados) use ($hoy, $anio, $nextYear, $anoAnterior) {
            foreach ($empleados as $emp) {

                // --- TU LÓGICA DE CÁLCULO SE QUEDA IGUAL AQUÍ ---
                $empleadoIngreso = Carbon::parse($emp->DateIngreso);
                $cumple = Carbon::createFromDate($anio, $empleadoIngreso->month, $empleadoIngreso->day);
                $difference = $cumple->diffInDays($hoy, false);

                $anosEnEmpleado = ($difference < 0) ? $anio - $empleadoIngreso->year : $nextYear - $empleadoIngreso->year;
                $anosEmpleadoAnterios = ($difference < 0) ? $anoAnterior - $empleadoIngreso->year : $anio - $empleadoIngreso->year;

                $diasVacaciones = $this->calcularDiasVacaciones($anosEnEmpleado);
                $diasVacacionesAnteriores = $this->calcularDiasVacaciones($anosEmpleadoAnterios);

                if ($difference < 0) {
                    $absDifference = abs($difference);
                    $diasVacacionesPendientes = intval(($diasVacaciones / 365) * (365 - $absDifference));

                    $menos = DB::table('registro_vacaciones')->where('id_empleado', $emp->employeeNumber)->where('usedYear', $anio)->count();
                    $menosAnoAnterios = DB::table('registro_vacaciones')->where('id_empleado', $emp->employeeNumber)->where('usedYear', $anoAnterior)->count();
                    $diaslastYear = $diasVacacionesAnteriores - $menosAnoAnterios > 0 ? $diasVacacionesAnteriores - $menosAnoAnterios : 0;
                    $diasCurrentYear = $diasVacacionesPendientes - $menos > 0 ? $diasVacacionesPendientes - $menos : 0;
                    $total = $diaslastYear + $diasCurrentYear;

                    DB::table('personalberg')->where('id', $emp->id)->update([
                        'lastYear' => $diaslastYear,
                        'currentYear' => $diasCurrentYear,
                        'DaysVacationsAvailble' => $total,
                    ]);
                } else {
                    $diasVacacionesPendientes = intval(($diasVacaciones / 365) * $difference);

                    $menos = DB::table('registro_vacaciones')->where('id_empleado', $emp->employeeNumber)->where('usedYear', $nextYear)->count();
                    $menosAnoAnterios = DB::table('registro_vacaciones')->where('id_empleado', $emp->employeeNumber)->where('usedYear', $anio)->count();
                    $diasCurrentYear = $diasVacacionesAnteriores - $menosAnoAnterios > 0 ? $diasVacacionesAnteriores - $menosAnoAnterios : 0;
                    $diasNextYear = $diasVacacionesPendientes - $menos > 0 ? $diasVacacionesPendientes - $menos : 0;
                    $total = $diasCurrentYear + $diasNextYear;

                    DB::table('personalberg')->where('id', $emp->id)->update([
                        'currentYear' => $diasCurrentYear,
                        'nextYear' => $diasNextYear,
                        'DaysVacationsAvailble' => $total + DB::raw('lastYear'),
                    ]);
                }

            }
        });
    }

    private function calcularDiasVacaciones(int $anos): int
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
            $anos > 31 => 32,
            default => 0,
        };
    }
}

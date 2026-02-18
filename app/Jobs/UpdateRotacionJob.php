<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateRotacionJob implements ShouldQueue
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
        $week = Carbon::now()->week();
        // Obtiene el número del día de la semana (1 para lunes, 7 para domingo)
        $days = ['domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];
        $dayNumber = Carbon::now()->dayOfWeek;
        $today = Carbon::now()->format('Y-m-d');
        $vacaciones = $faltas = $permisosConGose = $permisosSinGose = $incapacidad = $assistencia = $retardos =
         $suspension = $practicantes = $tsp = $assimilados = $sce = $he = $total = 0;

        $registroAssitenceDailyJob = Db::table('assistence')
            ->select($days[$dayNumber])
            ->where('week', '=', $week)
            ->orderBy($days[$dayNumber], 'ASC')
            ->get();
        foreach ($registroAssitenceDailyJob as $registro) {
            switch ($registro->{$days[$dayNumber]}) {
                case 'V':
                    $vacaciones++;
                    break;
                case 'F':
                    $faltas++;
                    break;
                case 'PSS':
                    $permisosConGose++;
                    break;
                case 'PCS':
                    $permisosSinGose++;
                    break;
                case 'INC':
                    $incapacidad++;
                    break;
                case 'OK':
                    $assistencia++;
                    break;
                case 'R':
                    $retardos++;
                    break;
                case 'SUS':
                    $suspension++;
                    break;
                case 'PCT':
                    $practicantes++;
                    break;
                case 'TSP':
                    $tsp++;
                    break;
                case 'ASM':
                    $assimilados++;
                    break;
                case 'SCE':
                    $sce++;
                case 'HE':
                    $he++;
                    break;
            }

        }
        if (DB::connection('rrhh')->table('rotacion')->where('fecha_rotacion', '=', $today)->exists()) {
            // Actualiza el registro existente
            DB::connection('rrhh')->table('rotacion')
                ->where('fecha_rotacion', '=', $today)
                ->update([
                    'vacaciones' => $vacaciones,
                    'faltas' => $faltas,
                    'permisos_gose' => $permisosConGose,
                    'permisos_sin_gose' => $permisosSinGose,
                    'incapacidad' => $incapacidad,
                    'assistencia' => $assistencia,
                    'retardos' => $retardos,
                    'suspension' => $suspension,
                    'practicantes' => $practicantes,
                    'tsp' => $tsp,
                    'asimilados' => $assimilados,
                    'ServiciosComprados' => $sce,
                    'horarioEspecial' => $he,
                ]);
        } else {
            // Crea un nuevo registro
            DB::connection('rrhh')->table('rotacion')->insert([
                'fecha_rotacion' => $today,
                'vacaciones' => $vacaciones,
                'faltas' => $faltas,
                'permisos_gose' => $permisosConGose,
                'permisos_sin_gose' => $permisosSinGose,
                'incapacidad' => $incapacidad,
                'assistencia' => $assistencia,
                'retardos' => $retardos,
                'suspension' => $suspension,
                'practicantes' => $practicantes,
                'tsp' => $tsp,
                'asimilados' => $assimilados,
                'ServiciosComprados' => $sce,
                'horarioEspecial' => $he,
            ]);
        }

        // Puedes agregar logs si deseas:
        Log::info('Tabla rotacion actualizada correctamente por UpdateRotacionJob.');
    }
}

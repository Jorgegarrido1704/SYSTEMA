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
use PHPUnit\Framework\Constraint\Count;

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
        $week =Carbon::now()->week();
        // Obtiene el número del día de la semana (1 para lunes, 7 para domingo)
        $days = ['domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];
        $dayNumber = Carbon::now()->dayOfWeek;
        $today= Carbon::now()->format('Y-m-d');
        $vacaciones = $faltas=$permisosConGose=$permisosSinGose=$incapacidad=$assistencia=$retardos=$suspension=$practicantes=0;


      $registroAssitenceDailyJob =  Db::table('assistence')
        ->select($days[$dayNumber])
        ->where('week', '=', $week)
        ->orderBy($days[$dayNumber], 'desc')
        ->get();
        foreach ($registroAssitenceDailyJob as $registro) {
            if ($registro->{$days[$dayNumber]} == 'V') {
                $vacaciones++;
            } elseif ($registro->{$days[$dayNumber]} == 'F') {
                $faltas++;
            } elseif ($registro->{$days[$dayNumber]} == 'PSS') {
                $permisosConGose++;
            } elseif ($registro->{$days[$dayNumber]} == 'PCS') {
                $permisosSinGose++;
            } elseif ($registro->{$days[$dayNumber]} == 'INC') {
                $incapacidad++;
            }else if ($registro->{$days[$dayNumber]} == 'OK') {
                $assistencia++;
            }else if ($registro->{$days[$dayNumber]} == 'R') {
                $retardos++;
            }else if ($registro->{$days[$dayNumber]} == 'SUS') {
                $suspension++;
            }else if ($registro->{$days[$dayNumber]} == 'PCT') {
                $practicantes++;
            }

        }
        if(DB::connection('rrhh')->table('rotacion')->where('fecha_rotacion', '=', $today)->exists()){
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
                    'practicantes' => $practicantes
                ]);

        }else{
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
                    'practicantes' => $practicantes
            ]);
        }



    // Puedes agregar logs si deseas:
    Log::info('Tabla rotacion actualizada correctamente por UpdateRotacionJob.');


    }
}

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
        $now = Carbon::now();
        $week = $now->week();
        $today = $now->format('Y-m-d');

        $days = ['domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];
        $column = $days[$now->dayOfWeek];

        // Obtener conteo agrupado directamente desde BD
        $registros = DB::table('assistence')
            ->select($column, DB::raw('COUNT(*) as total'))
            ->where('week', $week)
            ->groupBy($column)
            ->pluck('total', $column);

        $data = [
            'fecha_rotacion' => $today,
            'vacaciones' => $registros['V'] ?? 0,
            'faltas' => $registros['F'] ?? 0,
            'permisos_gose' => $registros['PSS'] ?? 0,
            'permisos_sin_gose' => $registros['PCS'] ?? 0,
            'incapacidad' => $registros['INC'] ?? 0,
            'assistencia' => $registros['OK'] ?? 0,
            'retardos' => $registros['R'] ?? 0,
            'suspension' => $registros['SUS'] ?? 0,
            'practicantes' => $registros['PCT'] ?? 0,
            'tsp' => $registros['TSP'] ?? 0,
            'asimilados' => $registros['ASM'] ?? 0,
            'ServiciosComprados' => $registros['SCE'] ?? 0,
            'horarioEspecial' => $registros['HE'] ?? 0,
        ];

        DB::connection('rrhh')->table('rotacion')
            ->updateOrInsert(
                ['fecha_rotacion' => $today],
                $data
            );

        Log::info('Tabla rotacion actualizada correctamente por UpdateRotacionJob.');
    }
}

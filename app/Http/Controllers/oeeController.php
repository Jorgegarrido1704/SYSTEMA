<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class oeeController extends Controller
{
    //
    public function indexEoo()
    {
        $value = session('user');
        $cat = session('categoria');
        if ($value == '' || $value == null) {
            return redirect('/');
        }

        return view('oee.index', ['value' => $value, 'cat' => $cat]);
    }

    public function appJointtiemposCompletos(Request $request)
    {
        $fechaDelDia = $request->input('fecha') ?? Carbon::now()->format('Y-m-d');
        $turno = (int) ($request->input('turno') ?? 1);
        $maquina = $request->input('maquina') ?? '';

        // Ajusta a tus nombres reales de máquinas
        $maquinas = $maquina !== '' ? [$maquina] : ['M1', 'M2', 'M3', 'M4', 'M5'];

        $inicio = $turno === 1
            ? Carbon::parse($fechaDelDia.' 07:30:00')
            : Carbon::parse($fechaDelDia)->subDay()->setTime(19, 30, 0);
        $fin = $inicio->copy()->addHours(12);

        $minutosTurno = 690; // 720 - 30 min de descanso

        $selects = [];
        $bindings = [];
        $horas = [];
        for ($i = 0; $i < 12; $i++) {
            $desde = $inicio->copy()->addHours($i);
            $hasta = $desde->copy()->addHour();

            $selects[] = "COUNT(CASE WHEN fecha >= ? AND fecha < ? THEN 1 END) as h{$i}";
            $bindings[] = $desde->format('Y-m-d H:i:s');
            $bindings[] = $hasta->format('Y-m-d H:i:s');
            $horas[$i] = $desde->format('H:i:s');
        }

        // Una sola consulta agrupada por máquina
        $filas = DB::connection('toi')
            ->table('lecturas')
            ->selectRaw('maquina, '.implode(', ', $selects).', COUNT(*) as total_general', $bindings)
            ->where('estado', 'RUN')
            ->whereIn('maquina', $maquinas)
            ->where('fecha', '>=', $inicio->format('Y-m-d H:i:s'))
            ->where('fecha', '<', $fin->format('Y-m-d H:i:s'))
            ->groupBy('maquina')
            ->get()
            ->keyBy('maquina');

        $resultadoPorMaquina = [];
        $runningTotal = 0;
        $cortesTotal = 0;

        foreach ($maquinas as $m) {
            $row = $filas->get($m); // null si la máquina no tuvo lecturas

            $run = [];
            $stop = [];
            foreach ($horas as $i => $hora) {
                $conteo = $row ? (int) $row->{"h{$i}"} : 0;
                $min = round((($conteo * 6.48) / 2) / 60, 2);
                $run[$hora] = min($min, 60);
                $stop[$hora] = round(60 - $run[$hora], 2);
            }

            $totalLecturas = $row ? (int) $row->total_general : 0;
            $running = min(round((($totalLecturas * 6.48) / 2) / 60, 2), $minutosTurno);
            $cortes = $totalLecturas > 0 ? round($totalLecturas / 2) : 0;

            $resultadoPorMaquina[$m] = [
                'tiempo_funcionando_total' => $running,
                'tiempo_detenido_total' => round(max(0, $minutosTurno - $running), 2),
                'oee' => round(($running / $minutosTurno) * 100, 2),
                'cortes' => $cortes,
                'desglose_por_hora' => [
                    'funcionando' => $run,
                    'detenido' => $stop,
                ],
            ];

            $runningTotal += $running;
            $cortesTotal += $cortes;
        }

        $planTotal = $minutosTurno * count($maquinas);

        // Paros registrados y fallas de calidad
        $qParos = DB::connection('toi')->table('cutting_machine_stops')->where('fecha', $fechaDelDia);
        $qCal = DB::connection('toi')->table('calidad_corte_oee')->where('fecha', $fechaDelDia);
        if ($maquina !== '') {
            $qParos->where('maquina', $maquina);
            $qCal->where('maquina', $maquina);
        }
        $registrosparos = (float) ($qParos->sum('time_min') ?? 0);
        $totalFallasCalidad = (float) ($qCal->sum('qty_errores') ?? 0);

        $oee = $planTotal > 0 ? round(($runningTotal / $planTotal) * 100, 2) : 0;

        $disponibilidad = $planTotal > 0
            ? round((($planTotal - $registrosparos) / $planTotal) * 100, 2)
            : 0;

        $porcentajeCalidad = $cortesTotal > 0
            ? round((($cortesTotal - $totalFallasCalidad) / $cortesTotal) * 100, 2)
            : 100;

        $resultadoPorMaquina['total'] = [
            'tiempo_total_funcionando' => round($runningTotal, 2),
        ];
        $resultadoPorMaquina['registrosparos'] = [
            'tiempo_total_detenido' => round($registrosparos, 2),
        ];

        return response()->json([
            'resultadoPorMaquina' => $resultadoPorMaquina,
            'turno' => $turno,
            'oee' => $oee,
            'disponibilidad' => $disponibilidad,
            'porcentajeCalidad' => $porcentajeCalidad,
            'totalCortes' => $cortesTotal,
            'totalFallasCalidad' => $totalFallasCalidad,
        ]);
    }

    public function appJointtiemposCalidad(Request $request)
    {
        $fechaDelDia = $request->input('fecha') ?? Carbon::now()->format('Y-m-d');

        $coleccionGeneral = DB::connection('toi')
            ->table('calidad_corte_oee')
            ->where('fecha', $fechaDelDia)
            ->orderBy('maquina', 'ASC')
            ->orderBy('fecha', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->groupBy('maquina');

        // Top 3 defectos del día (ajusta 'tipo_defecto' al nombre real de tu columna)
        $topDefectos = DB::connection('toi')
            ->table('calidad_corte_oee')
            ->select('motivo', DB::raw('SUM(qty_errores) as total'))
            ->where('fecha', $fechaDelDia)
            ->groupBy('motivo')
            ->orderByDesc('total')
            ->limit(3)
            ->get();
        foreach ($topDefectos as $defecto) {
            $buscarDefectoNombre = DB::table('clavecali')->where('clave', $defecto->motivo)->first();
            $defecto->defecto = $buscarDefectoNombre ? $buscarDefectoNombre->defecto : 'Desconocido';
        }

        return response()->json([
            'detalle' => $coleccionGeneral,
            'topDefectos' => $topDefectos,
        ]);
    }

    // NUEVO: detalle de paros (para la tabla, ya que solo tenías el SUM)
    public function appJointtiemposParos(Request $request)
    {
        $fechaDelDia = $request->input('fecha') ?? Carbon::now()->format('Y-m-d');

        try {
            // Si no viene fecha, usamos la de hoy
            $fechaDelDia = $request->input('fecha') ?? Carbon::now()->format('Y-m-d');

            $paros = DB::connection('toi')
                ->table('cutting_machine_stops')
                ->select('maquina', 'motive', DB::raw('SUM(time_min) as tiempo_total'))
                ->where('fecha', $fechaDelDia)
                ->groupBy('maquina', 'motive')
                ->orderBy(DB::raw('SUM(time_min)'), 'DESC') // Más seguro para evitar fallos de SQL estricto
                ->limit(3)
                ->get();

            return response()->json($paros);

        } catch (\Exception $e) {
            // Si algo falla, te devolverá un JSON con el error real en vez de romper la app
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

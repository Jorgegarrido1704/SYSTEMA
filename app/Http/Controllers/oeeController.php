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
        $runnigGrantotal = 0;
        $stopGrantotal = 0;
        $totalCortes = 0;

        $coleccionGeneral = DB::connection('toi')
            ->table('lecturas')
            ->whereBetween('fecha', [$fechaDelDia.' 07:30:00', $fechaDelDia.' 15:30:00'])
            ->orderBy('maquina', 'ASC')
            ->orderBy('fecha', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->groupBy('maquina'); // Agrupamos por máquina en Laravel

        $resultadoPorMaquina = [];
        // registro de paros de corte
        $registrosdeParospordia = DB::connection('toi')->table('cutting_machine_stops')->selectRaw('sum(time_min) as paros')->where('fecha', $fechaDelDia)->get();
        $registrosparos = $registrosdeParospordia[0]->paros != null ? $registrosdeParospordia[0]->paros : 0;

        // registro fallas calidad
        $fallasCalidad = DB::connection('toi')->table('calidad_corte_oee')->selectRaw('sum(qty_errores) as paros')->where('fecha', $fechaDelDia)->get();
        $totalFallasCalidad = $fallasCalidad[0]->paros != null ? $fallasCalidad[0]->paros : 0;

        foreach ($coleccionGeneral as $nombreMaquina => $lecturas) {

            $horasBase = ['07:30:00', '08:30:00', '09:30:00', '10:30:00', '11:30:00', '12:30:00', '13:30:00', '14:30:00'];
            $run = array_fill_keys($horasBase, 0);
            $stop = array_fill_keys($horasBase, 0);

            $parosTotales = 0;
            $runningTotal = 0;

            $lastTiempo = null;
            $lasStatus = null;

            foreach ($lecturas as $row) {
                $estatus = $row->estado;
                $fechaActual = strtotime($row->fecha);
                $horaFormateada = Carbon::parse($row->fecha)->format('H:i:s');

                if ($lastTiempo === null) {
                    $lastTiempo = $fechaActual;
                    $lasStatus = $estatus;

                    continue;
                }

                $diffTimeSeconds = abs($fechaActual - $lastTiempo);
                $diffTimeMinutes = round($diffTimeSeconds / 60, 2);

                if ($lasStatus == 'STOP' && $diffTimeSeconds > 10) {
                    $parosTotales += $diffTimeMinutes;
                    $stopGrantotal += $diffTimeMinutes;
                } else {
                    $runningTotal += $diffTimeMinutes;
                    $runnigGrantotal += $diffTimeMinutes;
                    $totalCortes += 1;

                    // Determinar el bloque sutilmente usando rangos de tiempo
                    foreach ($horasBase as $horaInicio) {
                        $limiteInicio = Carbon::parse($horaInicio)->subSecond()->format('H:i:s'); // ej. 07:29:59
                        $limiteFin = Carbon::parse($horaInicio)->addHour()->format('H:i:s');     // ej. 08:30:00

                        // Ajuste para el último bloque
                        if ($horaInicio === '14:30:00') {
                            $limiteFin = '15:30:01';
                        }

                        if ($horaFormateada > $limiteInicio && $horaFormateada <= $limiteFin) {
                            $run[$horaInicio] += $diffTimeMinutes;
                            break;
                        }
                    }
                }

                // Calcular el complemento para STOP por cada hora recorriendo el bloque
                foreach ($horasBase as $horaInicio) {
                    $stop[$horaInicio] = max(0, 60 - $run[$horaInicio]);
                }

                $lastTiempo = $fechaActual;
                $lasStatus = $estatus;
            }

            // Guardamos los datos procesados de esta máquina
            $resultadoPorMaquina[$nombreMaquina] = [
                'tiempo_funcionando_total' => round($runningTotal, 2),
                'tiempo_detenido_total' => round($parosTotales, 2),

                'desglose_por_hora' => [
                    'funcionando' => $run,
                    'detenido' => $stop,
                ],
            ];
        }
        $resultadoPorMaquina['total'] = [
            'tiempo_total_funcionando' => round($runnigGrantotal, 2),
        ];
        $productividad = round($runnigGrantotal / ((450 * 5) - $registrosparos) * 100, 2);
        $resultadoPorMaquina['registrosparos'] = ['tiempo_total_detenido' => round($registrosparos, 2)];
        $disponibilidad = round(((450 * 5) - $registrosparos) / (450 * 5) * 100, 2);
        $totalCortes = $totalCortes > 0 ? $totalCortes : 1; //
        $porcentajeCalidad = round((($totalCortes - $totalFallasCalidad) / $totalCortes) * 100, 2);

        $oee = (($porcentajeCalidad / 100) * ($disponibilidad / 100) * ($productividad / 100));
        $oee = round($oee * 100, 2);

        $datos = [
            'resultadoPorMaquina' => $resultadoPorMaquina,
            'disponibilidad' => $disponibilidad,
            'productividad' => $productividad,
            'oee' => $oee,
            'porcentajeCalidad' => $porcentajeCalidad,
            'totalCortes' => $totalCortes,
            'totalFallasCalidad' => $totalFallasCalidad,
        ];

        return response()->json($datos);
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

        $paros = DB::connection('toi')
            ->table('cutting_machine_stops')
            ->where('fecha', $fechaDelDia)
            ->orderBy('maquina', 'ASC')
            ->orderBy('id', 'ASC')
            ->get();

        return response()->json($paros);
    }
}

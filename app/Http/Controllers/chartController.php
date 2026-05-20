<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        $value = session('user');
        $cat = session('categoria');
        if ($value == '') {
            return redirect('/');
        }

        return view('dashboards.corte', ['cat', 'value' => $value, 'cat' => $cat]);
    }

    public function getDatacorte(Request $request)
    {
        // 1. Si no viene fecha, usamos el día de hoy
        $fechaDelDia = $request->input('fecha') ?? \Carbon\Carbon::now()->format('Y-m-d');

        // 2. IMPORTANTE: Agregamos el ->whereDate() para no saturar el servidor con datos viejos
        $colection = DB::connection('toi')
            ->table('lecturas')
            ->where('maquina', 'M1')
            ->whereDate('fecha', $fechaDelDia) // <-- Evita traer miles de filas innecesarias
            ->orderBy('fecha', 'ASC')
            ->get();

        $paros = 0;
        $running = 0;
        $lastTiempo = null;
        $lasStatus = null;

        foreach ($colection as $row) {
            $estatus = $row->estado;
            $fechaActual = strtotime($row->fecha);

            if ($lastTiempo === null) {
                $lastTiempo = $fechaActual;
                $lasStatus = $estatus;

                continue;
            }

            $diffTimeSeconds = abs($fechaActual - $lastTiempo);
            $diffTimeMinutes = round($diffTimeSeconds / 60, 2);

            if ($lasStatus == 'STOP') {
                $paros += $diffTimeMinutes;
            } else {
                $running += $diffTimeMinutes;
            }

            $lastTiempo = $fechaActual;
            $lasStatus = $estatus;
        }

        $paros = round($paros, 2);
        $running = round($running, 2);

        // 3. Ajustamos para que calcule el tiempo transcurrido basándose en la fecha seleccionada
        $TiempoInicial = strtotime($fechaDelDia.' 07:30:00');

        // Si la fecha consultada es HOY, comparamos contra la hora actual.
        // Si están consultando un día del pasado, comparamos contra el fin de turno (ej. 16:30 u otra hora) para que no dé negativo.
        if ($fechaDelDia === date('Y-m-d')) {
            $tiempoAhora = time();
        } else {

            $tiempoAhora = strtotime($fechaDelDia.' 15:30:00');
        }

        $diferenciaDeTiempo = $tiempoAhora - $TiempoInicial;

        // Evitamos que si entran antes de las 7:30 am dé minutos negativos
        if ($diferenciaDeTiempo < 0) {
            $diferenciaDeTiempo = 0;
        }

        $diferenciaDeTiempoMinutes = round($diferenciaDeTiempo / 60, 2);

        // 4. Protección contra división por cero
        if ($diferenciaDeTiempoMinutes > 0) {
            $oee = round(($running / $diferenciaDeTiempoMinutes) * 100, 2);
        } else {
            $oee = 0;
        }

        $datos = [
            'paros' => $paros,
            'running' => $running,
            'OEE' => $oee,
            'tiempo_total_turno' => $diferenciaDeTiempoMinutes, // Agregado para que puedas validar en tu JS
        ];

        // En Laravel es mejor retornar una respuesta JSON nativa en lugar de usar json_encode
        return response()->json($datos);
    }
}

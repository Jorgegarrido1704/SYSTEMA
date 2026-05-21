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

        $fechaDelDia = $request->input('fecha') ?? \Carbon\Carbon::now()->format('Y-m-d');

        $colection = DB::connection('toi')
            ->table('lecturas')
            ->where('maquina', 'M1')
            ->whereBetween('fecha', [$fechaDelDia.' 07:30:00', $fechaDelDia.' 15:30:00'])
            // FIX 1: Match the exact ordering of your first script
            ->orderBy('fecha', 'ASC')
            ->orderBy('id', 'ASC')
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

            if ($lasStatus == 'STOP' && $diffTimeSeconds > 3) {
                $paros += $diffTimeMinutes;
            } else {
                $running += $diffTimeMinutes;
            }

            $lastTiempo = $fechaActual;
            $lasStatus = $estatus;
        }

        $paros = round($paros, 2);
        $running = round($running, 2);

        // FIX 2: Normalize time calculation to handle time strings accurately
        $TiempoInicial = strtotime($fechaDelDia.' 07:30:00');

        if ($fechaDelDia === date('Y-m-d')) {
            // Ensuring both timestamps include the exact same date structure
            $tiempoAhora = strtotime($fechaDelDia.' '.date('H:i:s'));
        } else {
            $tiempoAhora = strtotime($fechaDelDia.' 15:30:00');
        }

        $diferenciaDeTiempo = abs($tiempoAhora - $TiempoInicial);
        $diferenciaDeTiempoMinutes = round($diferenciaDeTiempo / 60, 2);
        $diferenciaDeTiempoMinutes = $diferenciaDeTiempoMinutes > 30 ? $diferenciaDeTiempoMinutes - 30 : $diferenciaDeTiempoMinutes; // Evitar división por cero

        if ($diferenciaDeTiempoMinutes > 0) {
            $oee = round(($running / $diferenciaDeTiempoMinutes) * 100, 2);
        } else {
            $oee = 0;
        }

        $datos = [
            'paros' => $paros,
            'running' => $running,
            'OEE' => $oee,
            'tiempo_total_turno' => $diferenciaDeTiempoMinutes,
        ];

        return response()->json($datos);
    }
}

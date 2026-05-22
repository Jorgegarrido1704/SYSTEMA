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
            ->orderBy('fecha', 'ASC')
            ->orderBy('id', 'ASC')
            ->get();
        $cortes = DB::connection('toi')
            ->table('lecturas')
            ->where('maquina', 'M1')
            ->where('estado', 'RUN')
            ->whereBetween('fecha', [$fechaDelDia.' 07:30:00', $fechaDelDia.' 15:30:00'])
            ->orderBy('fecha', 'ASC')
            ->orderBy('id', 'ASC')
            ->count();

             $registroParos = DB::connection('toi')
            ->table('cutting_machine_stops')
            ->where('maquina', 'M1')
            ->where('fecha', $fechaDelDia)
            ->get();

        $qtyCortes = $cortes>0?round($cortes/2):0;
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

            if ($lasStatus == 'STOP' && $diffTimeSeconds > 5) {
                $paros += $diffTimeMinutes;
            } else {
                $running += $diffTimeMinutes;
            }

            $lastTiempo = $fechaActual;
            $lasStatus = $estatus;
            $ultimoEstado = $row->estado;
        }

        $paros = round($paros, 2);
        $running = round($running, 2);

        // FIX 2: Normalize time calculation to handle time strings accurately
        $TiempoInicial = strtotime($fechaDelDia.' 07:30:00');

        if ($fechaDelDia === date('Y-m-d') and date('H:i:s') < '15:30:01') {

            $tiempoAhora = strtotime($fechaDelDia.' '.date('H:i:s'));
        } elseif ($fechaDelDia === date('Y-m-d') and date('H:i:s') > '15:30:00') {

            $tiempoAhora = strtotime($fechaDelDia.' 15:30:00');
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
            'cortes' => $qtyCortes,
            'registroParos' => $registroParos,
            'estado' => $ultimoEstado
        ];

        return response()->json($datos);
    }
}

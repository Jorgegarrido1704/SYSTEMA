<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $maquina = $request->input('maquina') ?? 'M1';

        $colection = DB::connection('toi')
            ->table('lecturas')
            ->where('maquina', $maquina)
            ->whereBetween('fecha', [$fechaDelDia.' 07:30:00', $fechaDelDia.' 15:30:00'])
            ->orderBy('fecha', 'ASC')
            ->orderBy('id', 'ASC')
            ->get();
        // subgroups per hour of day
        $stop = [];
        $stop['07:30:00'] = 0;
        $stop['08:30:00'] = 0;
        $stop['09:30:00'] = 0;
        $stop['10:30:00'] = 0;
        $stop['11:30:00'] = 0;
        $stop['12:30:00'] = 0;
        $stop['13:30:00'] = 0;
        $stop['14:30:00'] = 0;
        $run = [];
        $run['07:30:00'] = 0;
        $run['08:30:00'] = 0;
        $run['09:30:00'] = 0;
        $run['10:30:00'] = 0;
        $run['11:30:00'] = 0;
        $run['12:30:00'] = 0;
        $run['13:30:00'] = 0;
        $run['14:30:00'] = 0;

        $cortes = DB::connection('toi')
            ->table('lecturas')
            ->where('maquina', $maquina)
            ->where('estado', 'RUN')
            ->whereBetween('fecha', [$fechaDelDia.' 07:30:00', $fechaDelDia.' 15:30:00'])
            ->orderBy('fecha', 'ASC')
            ->orderBy('id', 'ASC')
            ->count();

        $registroParos = DB::connection('toi')
            ->table('cutting_machine_stops')
            ->where('maquina', $maquina)
            ->where('fecha', $fechaDelDia)
            ->get();

        $qtyCortes = $cortes > 0 ? round($cortes / 2) : 0;
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
            $hora = Carbon::parse($row->fecha)->format('H:i:s');
            if ($lasStatus == 'STOP' && $diffTimeSeconds > 4) {
                $paros += $diffTimeMinutes;

            } else {
                $running += $diffTimeMinutes;
                switch (Carbon::parse($row->fecha)->format('H:i:s')) {
                    case Carbon::parse($row->fecha)->format('H:i:s') > '07:29:59' && Carbon::parse($row->fecha)->format('H:i:s') < '08:30:00':
                        $run['07:30:00'] += $diffTimeMinutes;
                        break;
                    case Carbon::parse($row->fecha)->format('H:i:s') > '08:29:59' && Carbon::parse($row->fecha)->format('H:i:s') < '09:30:00':
                        $run['08:30:00'] += $diffTimeMinutes;
                        break;
                    case Carbon::parse($row->fecha)->format('H:i:s') > '09:29:59' && Carbon::parse($row->fecha)->format('H:i:s') < '10:30:00':
                        $run['09:30:00'] += $diffTimeMinutes;
                        break;
                    case Carbon::parse($row->fecha)->format('H:i:s') > '10:29:59' && Carbon::parse($row->fecha)->format('H:i:s') < '11:30:00':
                        $run['10:30:00'] += $diffTimeMinutes;
                        break;
                    case Carbon::parse($row->fecha)->format('H:i:s') > '11:29:59' && Carbon::parse($row->fecha)->format('H:i:s') < '12:30:00':
                        $run['11:30:00'] += $diffTimeMinutes;
                        break;
                    case Carbon::parse($row->fecha)->format('H:i:s') > '12:29:59' && Carbon::parse($row->fecha)->format('H:i:s') < '13:30:00':
                        $run['12:30:00'] += $diffTimeMinutes;
                        break;
                    case Carbon::parse($row->fecha)->format('H:i:s') > '13:29:59' && Carbon::parse($row->fecha)->format('H:i:s') < '14:30:00':
                        $run['13:30:00'] += $diffTimeMinutes;
                        break;
                    case Carbon::parse($row->fecha)->format('H:i:s') > '14:29:59' && Carbon::parse($row->fecha)->format('H:i:s') <= '15:30:00':
                        $run['14:30:00'] += $diffTimeMinutes;
                        break;
                }

            }
            $stop['07:30:00'] = 60 - $run['07:30:00'];
            $stop['08:30:00'] = 60 - $run['08:30:00'];
            $stop['09:30:00'] = 60 - $run['09:30:00'];
            $stop['10:30:00'] = 60 - $run['10:30:00'];
            $stop['11:30:00'] = 60 - $run['11:30:00'];
            $stop['12:30:00'] = 60 - $run['12:30:00'];
            $stop['13:30:00'] = 60 - $run['13:30:00'];
            $stop['14:30:00'] = 60 - $run['14:30:00'];

            $lastTiempo = $fechaActual;
            $lasStatus = $estatus;
            $ultimoEstado = $row->estado;

        }

        $paros = round($paros, 2);
        $running = round($running, 2);

        //  Normalize time calculation to handle time strings accurately
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
        $diferenciaDeTiempoMinutes = $diferenciaDeTiempoMinutes > 240 ? $diferenciaDeTiempoMinutes - 30 : $diferenciaDeTiempoMinutes; // Evitar división por cero

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
            'estado' => $ultimoEstado,
            'stop' => $stop,
            'run' => $run,
        ];

        return response()->json($datos);
    }
}

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
        $fechaAyer = \Carbon\Carbon::parse($fechaDelDia)->subDay()->format('Y-m-d');
        $turnoActual = $request->input('turno') ?? 1;
        $maquina = $request->input('maquina') ?? 'M1';
        if ($turnoActual == 1) {
            $colections = DB::connection('toi')
                ->table('lecturas')
                ->selectRaw('
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total8,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total9,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total10,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total11,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total12,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total13,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total14,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total15,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total16,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total17,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total18,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total19,
                    COUNT(*) as total_general
                ', [
                    $fechaDelDia.' 07:30:00', $fechaDelDia.' 08:30:00',
                    $fechaDelDia.' 08:30:00', $fechaDelDia.' 09:30:00',
                    $fechaDelDia.' 09:30:00', $fechaDelDia.' 10:30:00',
                    $fechaDelDia.' 10:30:00', $fechaDelDia.' 11:30:00',
                    $fechaDelDia.' 11:30:00', $fechaDelDia.' 12:30:00',
                    $fechaDelDia.' 12:30:00', $fechaDelDia.' 13:30:00',
                    $fechaDelDia.' 13:30:00', $fechaDelDia.' 14:30:00',
                    $fechaDelDia.' 14:30:00', $fechaDelDia.' 15:30:00',
                    $fechaDelDia.' 15:30:00', $fechaDelDia.' 16:30:00',
                    $fechaDelDia.' 16:30:00', $fechaDelDia.' 17:30:00',
                    $fechaDelDia.' 17:30:00', $fechaDelDia.' 18:30:00',
                    $fechaDelDia.' 18:30:00', $fechaDelDia.' 19:30:00',
                ])
                ->where('estado', 'RUN')
                ->where('maquina', $maquina)
                ->whereBetween('fecha', [$fechaDelDia.' 07:30:00', $fechaDelDia.' 19:30:00'])
                ->first();
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
            $stop['15:30:00'] = 0;
            $stop['16:30:00'] = 0;
            $stop['17:30:00'] = 0;
            $stop['18:30:00'] = 0;
            $stop['19:30:00'] = 0;

            $run = [];
            $run['07:30:00'] = 0;
            $run['08:30:00'] = 0;
            $run['09:30:00'] = 0;
            $run['10:30:00'] = 0;
            $run['11:30:00'] = 0;
            $run['12:30:00'] = 0;
            $run['13:30:00'] = 0;
            $run['14:30:00'] = 0;
            $run['15:30:00'] = 0;
            $run['16:30:00'] = 0;
            $run['17:30:00'] = 0;
            $run['18:30:00'] = 0;
            $run['19:30:00'] = 0;

            $cortes = $colections->total_general ?? 0;
            $registroParos = DB::connection('toi')
                ->table('cutting_machine_stops')
                ->where('maquina', $maquina)
                ->where('fecha', $fechaDelDia)
                ->get();

            $qtyCortes = $cortes > 0 ? round($cortes / 2) : 0;
            $paros = 0;
            $running = round((($colections->total_general * 6.48) / 2) / 60, 2) ?? 0;
            $lastTiempo = null;
            $lasStatus = null;
            $ultimoEstado = 'RUN';

            $run['07:30:00'] = round((($colections->total8 * 6.48) / 2) / 60, 2);
            $run['08:30:00'] = round((($colections->total9 * 6.48) / 2) / 60, 2);
            $run['09:30:00'] = round((($colections->total10 * 6.48) / 2) / 60, 2);
            $run['10:30:00'] = round((($colections->total11 * 6.48) / 2) / 60, 2);
            $run['11:30:00'] = round((($colections->total12 * 6.48) / 2) / 60, 2);
            $run['12:30:00'] = round((($colections->total13 * 6.48) / 2) / 60, 2);
            $run['13:30:00'] = round((($colections->total14 * 6.48) / 2) / 60, 2);
            $run['14:30:00'] = round((($colections->total15 * 6.48) / 2) / 60, 2);
            $run['15:30:00'] = round((($colections->total16 * 6.48) / 2) / 60, 2);
            $run['16:30:00'] = round((($colections->total17 * 6.48) / 2) / 60, 2);
            $run['17:30:00'] = round((($colections->total18 * 6.48) / 2) / 60, 2);
            $run['18:30:00'] = round((($colections->total19 * 6.48) / 2) / 60, 2);

            $stop['07:30:00'] = 60 - $run['07:30:00'];
            $stop['08:30:00'] = 60 - $run['08:30:00'];
            $stop['09:30:00'] = 60 - $run['09:30:00'];
            $stop['10:30:00'] = 60 - $run['10:30:00'];
            $stop['11:30:00'] = 60 - $run['11:30:00'];
            $stop['12:30:00'] = 60 - $run['12:30:00'];
            $stop['13:30:00'] = 60 - $run['13:30:00'];
            $stop['14:30:00'] = 60 - $run['14:30:00'];
            $stop['15:30:00'] = 60 - $run['15:30:00'];
            $stop['16:30:00'] = 60 - $run['16:30:00'];
            $stop['17:30:00'] = 60 - $run['17:30:00'];
            $stop['18:30:00'] = 60 - $run['18:30:00'];

            $paros = round($paros, 2);
            $running = round($running, 2);

            //  Normalize time calculation to handle time strings accurately
            $TiempoInicial = strtotime($fechaDelDia.' 07:30:00');

            if ($fechaDelDia === date('Y-m-d') and date('H:i:s') < '15:30:01') {

                $tiempoAhora = strtotime($fechaDelDia.' '.date('H:i:s'));
            } elseif ($fechaDelDia === date('Y-m-d') and date('H:i:s') > '17:30:00') {

                $tiempoAhora = strtotime($fechaDelDia.' 17:30:00');
            } else {
                $tiempoAhora = strtotime($fechaDelDia.' 17:30:00');
            }

            $diferenciaDeTiempo = abs($tiempoAhora - $TiempoInicial);
            $diferenciaDeTiempoMinutes = round($diferenciaDeTiempo / 60, 2);
            $diferenciaDeTiempoMinutes = $diferenciaDeTiempoMinutes > 240 ? $diferenciaDeTiempoMinutes - 30 : $diferenciaDeTiempoMinutes; // Evitar división por cero

            if ($diferenciaDeTiempoMinutes > 0) {
                $oee = round(($running / $diferenciaDeTiempoMinutes) * 100, 2);
            } else {
                $oee = 0;
            }
        } elseif ($turnoActual == 2) {

            $colections = DB::connection('toi')
                ->table('lecturas')
                ->selectRaw('
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total19,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total20,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total21,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total22,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total23,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total1,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total2,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total3,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total4,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total5,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total6,
                    COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as total7,
                    COUNT(*) as total_general
                ', [
                    $fechaAyer.' 19:30:00', $fechaAyer.' 20:30:00',
                    $fechaAyer.' 20:30:00', $fechaAyer.' 21:30:00',
                    $fechaAyer.' 21:30:00', $fechaAyer.' 22:30:00',
                    $fechaAyer.' 22:30:00', $fechaAyer.' 23:30:00',
                    $fechaAyer.' 23:30:00', $fechaDelDia.' 00:30:00',
                    $fechaDelDia.' 00:30:00', $fechaDelDia.' 01:30:00',
                    $fechaDelDia.' 01:30:00', $fechaDelDia.' 02:30:00',
                    $fechaDelDia.' 02:30:00', $fechaDelDia.' 03:30:00',
                    $fechaDelDia.' 03:30:00', $fechaDelDia.' 04:30:00',
                    $fechaDelDia.' 04:30:00', $fechaDelDia.' 05:30:00',
                    $fechaDelDia.' 05:30:00', $fechaDelDia.' 06:30:00',
                    $fechaDelDia.' 06:30:00', $fechaDelDia.' 07:30:00',
                ])
                ->where('estado', 'RUN')
                ->where('maquina', $maquina)
                ->whereBetween('fecha', [$fechaAyer.' 19:30:00', $fechaDelDia.' 07:30:00'])
                ->first();
            // subgroups per hour of day
            $stop = [];
            $stop['19:30:00'] = 0;
            $stop['20:30:00'] = 0;
            $stop['21:30:00'] = 0;
            $stop['22:30:00'] = 0;
            $stop['23:30:00'] = 0;
            $stop['00:30:00'] = 0;
            $stop['01:30:00'] = 0;
            $stop['02:30:00'] = 0;
            $stop['03:30:00'] = 0;
            $stop['04:30:00'] = 0;
            $stop['05:30:00'] = 0;
            $stop['06:30:00'] = 0;

            $run = [];
            $run['19:30:00'] = 0;
            $run['20:30:00'] = 0;
            $run['21:30:00'] = 0;
            $run['22:30:00'] = 0;
            $run['23:30:00'] = 0;
            $run['00:30:00'] = 0;
            $run['01:30:00'] = 0;
            $run['02:30:00'] = 0;
            $run['03:30:00'] = 0;
            $run['04:30:00'] = 0;
            $run['05:30:00'] = 0;
            $run['06:30:00'] = 0;

            $cortes = $colections->total_general ?? 0;
            $registroParos = DB::connection('toi')
                ->table('cutting_machine_stops')
                ->where('maquina', $maquina)
                ->where('fecha', $fechaDelDia)
                ->get();

            $qtyCortes = $cortes > 0 ? round($cortes / 2) : 0;
            $paros = 0;
            $running = round((($colections->total_general * 6.48) / 2) / 60, 2) ?? 0;
            $lastTiempo = null;
            $lasStatus = null;
            $ultimoEstado = 'RUN';

            $run['19:30:00'] = round((($colections->total8 * 6.48) / 2) / 60, 2);
            $run['20:30:00'] = round((($colections->total9 * 6.48) / 2) / 60, 2);
            $run['21:30:00'] = round((($colections->total10 * 6.48) / 2) / 60, 2);
            $run['22:30:00'] = round((($colections->total11 * 6.48) / 2) / 60, 2);
            $run['23:30:00'] = round((($colections->total12 * 6.48) / 2) / 60, 2);
            $run['00:30:00'] = round((($colections->total13 * 6.48) / 2) / 60, 2);
            $run['01:30:00'] = round((($colections->total14 * 6.48) / 2) / 60, 2);
            $run['02:30:00'] = round((($colections->total15 * 6.48) / 2) / 60, 2);
            $run['03:30:00'] = round((($colections->total16 * 6.48) / 2) / 60, 2);
            $run['04:30:00'] = round((($colections->total17 * 6.48) / 2) / 60, 2);
            $run['05:30:00'] = round((($colections->total18 * 6.48) / 2) / 60, 2);
            $run['06:30:00'] = round((($colections->total19 * 6.48) / 2) / 60, 2);

            $stop['19:30:00'] = 60 - $run['19:30:00'];
            $stop['20:30:00'] = 60 - $run['20:30:00'];
            $stop['21:30:00'] = 60 - $run['21:30:00'];
            $stop['22:30:00'] = 60 - $run['22:30:00'];
            $stop['23:30:00'] = 60 - $run['23:30:00'];
            $stop['00:30:00'] = 60 - $run['00:30:00'];
            $stop['01:30:00'] = 60 - $run['01:30:00'];
            $stop['02:30:00'] = 60 - $run['02:30:00'];
            $stop['03:30:00'] = 60 - $run['03:30:00'];
            $stop['04:30:00'] = 60 - $run['04:30:00'];
            $stop['05:30:00'] = 60 - $run['05:30:00'];
            $stop['06:30:00'] = 60 - $run['06:30:00'];

            $paros = round($paros, 2);
            $running = round($running, 2);

            //  Normalize time calculation to handle time strings accurately
            $TiempoInicial = strtotime($fechaDelDia.' 07:30:00');

            if ($fechaDelDia === date('Y-m-d') and date('H:i:s') < '15:30:01') {

                $tiempoAhora = strtotime($fechaDelDia.' '.date('H:i:s'));
            } elseif ($fechaDelDia === date('Y-m-d') and date('H:i:s') > '17:30:00') {

                $tiempoAhora = strtotime($fechaDelDia.' 17:30:00');
            } else {
                $tiempoAhora = strtotime($fechaDelDia.' 17:30:00');
            }

            $diferenciaDeTiempo = abs($tiempoAhora - $TiempoInicial);
            $diferenciaDeTiempoMinutes = round($diferenciaDeTiempo / 60, 2);
            $diferenciaDeTiempoMinutes = $diferenciaDeTiempoMinutes > 240 ? $diferenciaDeTiempoMinutes - 30 : $diferenciaDeTiempoMinutes; // Evitar división por cero

            if ($diferenciaDeTiempoMinutes > 0) {
                $oee = round(($running / $diferenciaDeTiempoMinutes) * 100, 2);
            } else {
                $oee = 0;
            }
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

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
        $fechaDelDia = $request->input('fecha') ?? Carbon::now()->format('Y-m-d');
        $turnoActual = (int) ($request->input('turno') ?? 1);
        $maquina = $request->input('maquina') ?? 'M1';

        // Inicio del turno
        if ($turnoActual === 1) {
            $inicio = Carbon::parse($fechaDelDia.' 07:30:00');
        } else {
            $inicio = Carbon::parse($fechaDelDia.' 19:30:00')->subDay();
        }
        $fin = $inicio->copy()->addHours(12);

        // Construir 12 rangos horarios
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
        $selects[] = 'COUNT(*) as total_general';

        $colections = DB::connection('toi')
            ->table('lecturas')
            ->selectRaw(implode(",\n", $selects), $bindings)
            ->where('estado', 'RUN')
            ->where('maquina', $maquina)
            ->where('fecha', '>=', $inicio->format('Y-m-d H:i:s'))
            ->where('fecha', '<', $fin->format('Y-m-d H:i:s'))
            ->first();

        $run = [];
        $stop = [];
        for ($i = 0; $i < 12; $i++) {
            $conteo = $colections->{"h{$i}"} ?? 0;
            $minRun = round((($conteo * 6.48) / 2) / 60, 2);
            $run[$horas[$i]] = $minRun;
            $stop[$horas[$i]] = round(60 - $minRun, 2);
        }

        $cortes = $colections->total_general ?? 0;
        $qtyCortes = $cortes > 0 ? round($cortes / 2) : 0;
        $running = round((($cortes * 6.48) / 2) / 60, 2);

        $registroParos = DB::connection('toi')
            ->table('cutting_machine_stops')
            ->where('maquina', $maquina)
            ->where('fecha', $fechaDelDia)
            ->get();

        // Tiempo transcurrido del turno
        $ahora = Carbon::now();
        if ($ahora->between($inicio, $fin)) {
            $minutosTurno = $inicio->diffInMinutes($ahora);
        } else {
            $minutosTurno = 12 * 60;
        }
        // Descontar 30 min de comida si ya pasó de 4 horas
        $minutosTurno = $minutosTurno > 240 ? $minutosTurno - 30 : $minutosTurno;

        $oee = $minutosTurno > 0 ? round(($running / $minutosTurno) * 100, 2) : 0;

        return response()->json([
            'paros' => 0,
            'running' => $running,
            'OEE' => $oee,
            'tiempo_total_turno' => $minutosTurno,
            'cortes' => $qtyCortes,
            'registroParos' => $registroParos,
            'estado' => 'RUN',
            'stop' => $stop,
            'run' => $run,
        ]);
    }
}

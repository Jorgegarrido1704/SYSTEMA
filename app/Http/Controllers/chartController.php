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

        $inicio = $turnoActual === 1
            ? Carbon::parse($fechaDelDia.' 07:30:00')
            : Carbon::parse($fechaDelDia)->subDay()->setTime(19, 30, 0);
        $fin = $inicio->copy()->addHours(12);

        $minutosTurno = 690; // 720 - 30 min de descanso

        // Un COUNT por cada hora del turno (intervalo [desde, hasta) para no contar doble)
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

        $row = DB::connection('toi')
            ->table('lecturas')
            ->selectRaw(implode(', ', $selects).', COUNT(*) as total_general', $bindings)
            ->where('estado', 'RUN')
            ->where('maquina', $maquina)
            ->where('fecha', '>=', $inicio->format('Y-m-d H:i:s'))
            ->where('fecha', '<', $fin->format('Y-m-d H:i:s'))
            ->first();

        $run = [];
        $stop = [];
        foreach ($horas as $i => $hora) {
            $min = round((($row->{"h{$i}"} * 6.48) / 2) / 60, 2);
            $run[$hora] = min($min, 60);
            $stop[$hora] = round(60 - $run[$hora], 2);
        }

        $totalLecturas = (int) ($row->total_general ?? 0);
        $qtyCortes = $totalLecturas > 0 ? round($totalLecturas / 2) : 0;
        $running = min(round((($totalLecturas * 6.48) / 2) / 60, 2), $minutosTurno);
        $paros = 0;

        $oee = $minutosTurno > 0 ? round(($running / $minutosTurno) * 100, 2) : 0;

        $registroParos = DB::connection('toi')
            ->table('cutting_machine_stops')
            ->where('maquina', $maquina)
            ->where('fecha', $fechaDelDia)
            ->get();

        return response()->json([
            'paros' => $paros,
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

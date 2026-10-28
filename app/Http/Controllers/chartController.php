<?php

namespace App\Http\Controllers;

use App\Models\cortes_maquina_corte;
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
        $fechaDelDia = $request->input('fecha') ?? Carbon::now()->format('Y-m-d');
        $fechaAyer = Carbon::parse($fechaDelDia)->subDay()->format('Y-m-d');
        $turnoActual = (int) ($request->input('turno') ?? 1);
        $maquina = $request->input('maquina') ?? 'M1';

        // Seguridad: $maquina se usa como nombre de columna en select()
        if (! preg_match('/^\w+$/', $maquina)) {
            return response()->json(['error' => 'Máquina inválida'], 422);
        }

        // ---- Target (número, o 0 si no hay registro) ----
        $targetRow = cortes_maquina_corte::select($maquina)
            ->where('fecha_de_trabajo', $fechaDelDia)
            ->where('turno', $turnoActual)
            ->first();
        $target = $targetRow->{$maquina} ?? 0;

        // ---- Inicio del turno ----
        // Turno 1: hoy 07:30 -> 19:30 | Turno 2: ayer 19:30 -> hoy 07:30
        $inicio = $turnoActual === 2
            ? Carbon::parse($fechaAyer.' 19:30:00')
            : Carbon::parse($fechaDelDia.' 07:30:00');
        $fin = $inicio->copy()->addHours(12);

        // ---- Generar las 12 franjas de una hora ----
        $slots = [];   // [label => [desde, hasta]]
        $bindings = [];
        $selects = [];
        for ($i = 0; $i < 12; $i++) {
            $desde = $inicio->copy()->addHours($i);
            $hasta = $desde->copy()->addHour();

            $slots["h{$i}"] = $desde->format('H:i:s');
            $selects[] = "COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) as h{$i}";
            $bindings[] = $desde->format('Y-m-d H:i:s');
            $bindings[] = $hasta->format('Y-m-d H:i:s');
        }
        $selects[] = 'COUNT(*) as total_general';

        $colections = DB::connection('toi')
            ->table('lecturas')
            ->selectRaw(implode(', ', $selects), $bindings)
            ->where('estado', 'RUN')
            ->where('maquina', $maquina)
            ->whereBetween('fecha', [$inicio->format('Y-m-d H:i:s'), $fin->format('Y-m-d H:i:s')])
            ->first();

        $totalGeneral = (int) ($colections->total_general ?? 0);

        // ---- Run / Stop por hora ----
        $run = [];
        $stop = [];
        foreach ($slots as $campo => $label) {
            $lecturas = (int) ($colections->{$campo} ?? 0);
            $minutos = round((($lecturas * 6.48) / 2) / 60, 2);
            $minutos = min($minutos, 60);

            $run[$label] = $minutos;
            $stop[$label] = round(60 - $minutos, 2);
        }

        // ---- Registro de paros ----
        $paros = DB::connection('toi')
            ->table('cutting_machine_stops')
            ->where('maquina', $maquina);

        if ($turnoActual === 2) {
            // Parte nocturna del día anterior + madrugada del día actual
            // (asume que 'hora' es tipo TIME o string 'H:i:s')
            $paros->where(function ($q) use ($fechaAyer, $fechaDelDia) {
                $q->where(function ($q2) use ($fechaAyer) {
                    $q2->where('fecha', $fechaAyer)->where('hora', '>=', '19:30:00');
                })->orWhere(function ($q2) use ($fechaDelDia) {
                    $q2->where('fecha', $fechaDelDia)->where('hora', '<', '07:30:00');
                });
            });
        } else {
            $paros->where('fecha', $fechaDelDia);
        }
        $registroParos = $paros->get();

        // ---- Totales ----
        $qtyCortes = $totalGeneral > 0 ? round($totalGeneral / 2) : 0;

        $running = round((($totalGeneral * 6.48) / 2) / 60, 2);
        if ($running > 720) {
            $running = round((($totalGeneral * 4.48) / 2) / 60, 2);
        }

        // 12 h de turno - 30 min de descanso
        $tiempoTotalTurno = 690;
        $oee = $tiempoTotalTurno > 0
            ? round(($running / $tiempoTotalTurno) * 100, 2)
            : 0;

        return response()->json([
            'paros' => 0,
            'running' => $running,
            'OEE' => $oee,
            'tiempo_total_turno' => $tiempoTotalTurno,
            'cortes' => $qtyCortes,
            'registroParos' => $registroParos,
            'estado' => 'RUN',
            'stop' => $stop,
            'run' => $run,
            'target' => $target,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VSM_and_simulation extends Controller
{
    public function simuladorIndex()
    {
        $value = session('user');
        $cat = session('categoria');

        return view('scheduleWork.simulacion', ['value' => $value, 'cat' => $cat]);
    }

    public function buscarPn(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if ($q === '' || strlen($q) < 2) {
            return response()->json([]);
        }

        $resultados = DB::table('tiemposderuteo')->where('pn', 'like', "%{$q}%")
            ->distinct()
            ->limit(15)
            ->pluck('pn');

        return response()->json($resultados);
    }

    /**
     * Simulación de carga por turno.
     * POST /api/tiempos/simular
     * Body JSON:
     * {
     *   "horas_turno": 8,
     *   "operarios": { "Cutting": 1, "Terminals": 2, "Assembly": 3, "Looming": 1, "Quality": 1, "Packaging": 1 },
     *   "items": [ { "pn": "1001489409", "qty": 50 }, { "pn": "660320", "qty": 30 } ]
     * }
     */
    public function simular(Request $request)
    {
        $data = $request->validate([
            'horas_turno' => 'required|numeric|min:0.5',
            'operarios' => 'array',
            'operarios.*' => 'numeric|min:0',
            'items' => 'array',
            'items.*.pn' => 'required|string',
            'items.*.qty' => 'required|numeric|min:0',
        ]);

        $horasTurno = (float) $data['horas_turno'];
        $operariosCfg = $data['operarios'] ?? [];
        $items = $data['items'] ?? [];

        $AREAS = ['Cutting', 'Terminals', 'Assembly', 'Looming', 'Quality', 'Packaging'];

        // Capacidad disponible por área en minutos (horas_turno * 60 * # operarios/estaciones)
        $capacidadPorArea = [];
        foreach ($AREAS as $area) {
            $operarios = (float) ($operariosCfg[$area] ?? 1);
            $capacidadPorArea[$area] = $horasTurno * 60 * $operarios;
        }

        $pnsSolicitados = collect($items)->pluck('pn')->unique()->values();
        $ruteos = DB::table('tiemposderuteo')->whereIn('pn', $pnsSolicitados)->get()->groupBy('pn');

        $requeridoPorArea = array_fill_keys($AREAS, 0.0);
        $detalleItems = [];
        $pnSinRuteo = [];

        foreach ($items as $item) {
            $pn = $item['pn'];
            $qty = (float) $item['qty'];

            if (! isset($ruteos[$pn])) {
                $pnSinRuteo[] = $pn;

                continue;
            }

            $tiemposPorArea = [];
            $totalItem = 0.0;

            foreach ($ruteos[$pn] as $r) {
                $tiempo = ($qty * $r->processtime) + $r->setupTime;
                $tiemposPorArea[$r->work] = round($tiempo, 2);
                $requeridoPorArea[$r->work] = ($requeridoPorArea[$r->work] ?? 0) + $tiempo;
                $totalItem += $tiempo;
            }

            $detalleItems[] = [
                'pn' => $pn,
                'qty' => $qty,
                'tiempo_por_area' => $tiemposPorArea,
                'tiempo_total_min' => round($totalItem, 2),
            ];
        }

        // Resumen por área: requerido vs capacidad
        $resumenAreas = [];
        $cuelloBotella = null;
        $maxUtilizacion = -1;

        foreach ($AREAS as $area) {
            $requerido = round($requeridoPorArea[$area], 2);
            $capacidad = round($capacidadPorArea[$area], 2);
            $utilizacion = $capacidad > 0 ? round(($requerido / $capacidad) * 100, 1) : 0;
            $disponible = round($capacidad - $requerido, 2);

            $resumenAreas[] = [
                'area' => $area,
                'requerido_min' => $requerido,
                'capacidad_min' => $capacidad,
                'disponible_min' => $disponible,
                'utilizacion_pct' => $utilizacion,
                'saturado' => $requerido > $capacidad,
            ];

            if ($utilizacion > $maxUtilizacion) {
                $maxUtilizacion = $utilizacion;
                $cuelloBotella = $area;
            }
        }

        return response()->json([
            'horas_turno' => $horasTurno,
            'items' => $detalleItems,
            'pn_sin_ruteo' => array_values(array_unique($pnSinRuteo)),
            'resumen_areas' => $resumenAreas,
            'cuello_botella' => $cuelloBotella,
            'utilizacion_max' => $maxUtilizacion,
            'cabe_en_turno' => $maxUtilizacion <= 100,
        ]);
    }
}

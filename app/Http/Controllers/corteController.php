<?php

namespace App\Http\Controllers;

use App\Models\crimpersTools;
use carbon\Carbon;

class corteController extends Controller
{
    //
    public function indexCorte()
    {
        $day = Carbon::now()->hour < 9 ? Carbon::now()->subDay()->format('Y-m-d') : Carbon::now()->format('Y-m-d');

        $cat = session('categoria');
        $value = session('user');

        return view('corte.terminales', ['value' => $value, 'cat' => $cat, 'day' => $day]);
    }

    public function appJointTerminales()
    {
        try {
            $hoy = carbon::now()->format('Y-m-d');
            $ayer = $hoy->isMonday() ? $hoy->copy()->subDays(3)->format('Y-m-d') : $hoy->copy()->subDay()->format('Y-m-d');

            // Obtenemos los datos agrupados por máquina y sumados
            $datos = crimpersTools::whereIn('dateRegistered', [$ayer, $hoy])
                ->select('toolingCrimperName')
                ->selectRaw('SUM(CAST(TerminalsUsed AS UNSIGNED)) as total_terminales')
                ->selectRaw('SUM(minutesStop) as total_paro')
                ->groupBy('toolingCrimperName')
                ->get()
                ->pluck(null, 'toolingCrimperName'); // Esto crea un objeto con el nombre como llave

            return response()->json($datos);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function appJointTerminalesTabla()
    {
        try {
            $hoy = carbon::now()->format('Y-m-d');
            $ayer = $hoy->isMonday() ? $hoy->copy()->subDays(2)->format('Y-m-d') : $hoy->copy()->subDay()->format('Y-m-d');

            $horaCorte = '09:00:00';
            $horaActual = date('H:i:s');

            // Si es antes de las 9 AM, mostrar ayer. Si es después, mostrar hoy.
            $fechaConsultar = ($horaActual < $horaCorte) ? $ayer : $hoy;

            $datos = crimpersTools::where('dateRegistered', $fechaConsultar)
                ->orderBy('toolingCrimperName', 'asc')
                ->orderBy('startHour', 'asc')
                ->get();

            return response()->json($datos);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

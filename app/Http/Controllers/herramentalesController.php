<?php

namespace App\Http\Controllers;

use App\Models\herramentales\golesDiarios;
use App\Models\herramentales\herramentalInfo;
use App\Models\Maintanance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class herramentalesController extends Controller
{
    //
    public function index()
    {
        $value = session('user');
        $cat = session('categoria');

        $crimpersRequested = DB::table('registro_paro')
            ->select('fecha', 'nombreEquipo', 'id', 'dano', 'quien', 'atiende', 'inimant', 'finhora')
            ->where('finhora', null)
            ->orWhere('finhora', '')
            ->orderBy('id', 'asc')
            ->get();
        $herramntal = herramentalInfo::orderBy('terminal', 'asc')->get();

        return view('herramentales.index', ['crimpersRequested' => $crimpersRequested, 'cat' => $cat, 'value' => $value,
            'herramntal' => $herramntal]);
    }

    public function update(Request $request, $id)
    {
        $nombrePersonalHerrmanetal = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('nombrePersonal')) ?? '';
        $fechaRegistros = Carbon::now()->format('d-m-Y H:i');
        if ($nombrePersonalHerrmanetal != '') {
            DB::table('registro_paro')
                ->where('id', $id)
                ->update(['atiende' => $nombrePersonalHerrmanetal,
                    'inimant' => $fechaRegistros]);
        } else {
            DB::table('registro_paro')
                ->where('id', $id)
                ->update(['finhora' => $fechaRegistros]);
        }

        return redirect('/herramentales');

    }

    public function sumCrimpers(Request $request)
    {
        $request->validate([
            'tooling' => ['required', 'string'],
            'qtyHits' => ['required', 'numeric'],
        ]);

        $date = Carbon::now()->format('d-m-Y');
        $tooling = explode('||', $request->input('tooling'))[1];
        $termina = explode('||', $request->input('tooling'))[0];
        $termina = str_replace(' ', '', $termina);
        $tooling = str_replace(' ', '', $tooling);
        $golpesDiarios = preg_replace('/[^0-9]+/', '', $request->input('qtyHits')) ?? 0;
        golesDiarios::create([
            'herramental' => $tooling,
            'terminal' => $termina,
            'fecha_reg' => $date,
            'golpesDiarios' => $golpesDiarios,
        ]);
        $lastMantainence = herramentalInfo::select('golpesTotales', 'totalmant')->where('herramental', '=', $tooling)->where('terminal', '=', $termina)->orderBy('id', 'desc')->first();
        $totalMant = round(intval($lastMantainence->golpesTotales + $golpesDiarios) / 5000);
        if ($totalMant > $lastMantainence->totalmant) {
            $respuesta = 'falta';
            // email de alerta
            $acciones['inicio'] = 'Se les informaque el dia de hoy se acumularon mas de 5000 golpes en el siguiente herramiental';
            $acciones['quepaso'] = 'Herramental: '.$tooling.' Terminal: '.$termina.' Total de golpes: '.$lastMantainence->golpesTotales;
            $acciones['final'] = 'Este herramental cuenta con de '.$lastMantainence->totalmant.' mantenimientos correctivos actualmente';
            $recipients = [
                'jolaes@mx.bergstrominc.com',
                'lramos@mx.bergstrominc.com',
                'emedina@mx.bergstrominc.com',
                'ediaz@mx.bergstrominc.com',
                'AnGonzalez@mx.bergstrominc.com',
                'scastillo@mx.bergstrominc.com',
                'rramirez@mx.bergstrominc.com',
                'drocha@mx.bergstrominc.com',
                'jgarrido@mx.bergstrominc.com',
            ];
            Mail::to($recipients)->send(new \App\Mail\herramentales('Nueva requisición de mantenimiento', $acciones));
        } else {
            $respuesta = 'ok';
        }

        if (herramentalInfo::where('herramental', '=', $tooling)->where('terminal', '=', $termina)->where('fecha_reg', '=', $date)->exists()) {
            herramentalInfo::where('herramental', '=', $tooling)->where('terminal', '=', $termina)->update([
                'golpesDiarios' => DB::raw("golpesDiarios + $golpesDiarios"),
                'golpesTotales' => DB::raw('golpesTotales +'.$golpesDiarios),
                'totalmant' => $totalMant,
                'mantenimiento' => $respuesta,

            ]);
        } else {
            herramentalInfo::where('herramental', '=', $tooling)->where('terminal', '=', $termina)->update([
                'fecha_reg' => $date,
                'golpesDiarios' => $golpesDiarios,
                'golpesTotales' => DB::raw('golpesTotales +'.$golpesDiarios),
                'totalmant' => $totalMant,
                'mantenimiento' => $respuesta,

            ]);
        }

        return back()->with('message', 'Count of hits added successfully.');
    }

    public function addHerramental(Request $request)
    {
        $request->validate([
            'newTooling' => ['required', 'string'],
            'terminalNewTooling' => ['required', 'string'],
        ]);
        $newTooling = strtoupper($request->input('newTooling'));
        $terminalNewTooling = strtoupper($request->input('terminalNewTooling'));
        $herramental = new herramentalInfo;
        $herramental->herramental = $newTooling;
        $herramental->terminal = $terminalNewTooling;
        $herramental->fecha_reg = Carbon::now()->format('d-m-Y');
        $herramental->save();

        return back()->with('message', 'Inventory added successfully.');
    }

    public function toolingMaintenance()
    {
        $value = session('user');
        $cat = session('categoria');

        $preventivo = herramentalInfo::where('mantenimiento', '=', 'ok')->orderBy('golpesTotales', 'DESC')->orderBy('terminal', 'asc')->get();
        $correctivo = herramentalInfo::where('mantenimiento', '!=', 'ok')->orderBy('golpesTotales', 'DESC')->orderBy('terminal', 'asc')->get();
        $maintenanceRecord = DB::table('mant_herramental')->orderBy('id', 'desc')->limit(25)->get();

        return view('herramentales.maintenenceTooling', ['cat' => $cat, 'value' => $value,
            'preventivo' => $preventivo, 'correctivo' => $correctivo, 'maintenanceRecord' => $maintenanceRecord]);

    }

    public function saveMantTooling(Request $request)
    {
        $request->validate([
            'tooling' => ['required', 'string'],
            'cantidad' => ['required', 'integer'],
            'personalRegistro' => ['required', 'string'],
            'observaciones' => ['required', 'string'],
        ]);
        $observaciones = preg_replace('/[^\p{L}0-9()._\- ]/u', ' ', $request->input('observaciones')) ?? '';
        $tooling = explode('//', $request->input('tooling'))[0];
        $terminal = explode('//', $request->input('tooling'))[1];
        $minutes = preg_replace('/[^0-9]+/', '', $request->input('cantidad')) ?? 0;
        $personal = preg_replace('/[^\p{L} ]/u', ' ', $request->input('personalRegistro')) ?? '';

        DB::table('mant_herramental')->insert([
            'fecha_reg' => Carbon::now()->format('d-m-Y'),
            'tiempos' => Carbon::now()->format('H:i'),
            'herramental' => $tooling,
            'terminal' => $terminal,
            'Minutos' => $minutes,
            'quien' => $personal,
            'docMant' => $observaciones,
        ]);

        herramentalInfo::where('herramental', '=', $tooling)->where('terminal', '=', $terminal)->update([
            'mantenimiento' => 'ok',
        ]);
        // email alerta
        $acciones['inicio'] = 'Se les informaque el dia de hoy se realizo el mantenimiento en el siguiente herramiental';
        $acciones['quepaso'] = 'Herramental: '.$tooling.' Terminal: '.$terminal.' Minutos de trabajp: '.$minutes;
        $acciones['final'] = 'Quien realizo el mantenimiento fue : '.$personal.' y redacto las siguientes observaciones: '.$observaciones;
        $recipients = [
            'jolaes@mx.bergstrominc.com',
            'lramos@mx.bergstrominc.com',
            'emedina@mx.bergstrominc.com',
            'ediaz@mx.bergstrominc.com',
            'AnGonzalez@mx.bergstrominc.com',
            'scastillo@mx.bergstrominc.com',
            'rramirez@mx.bergstrominc.com',
            'drocha@mx.bergstrominc.com',
            'jgarrido@mx.bergstrominc.com',
        ];
        Mail::to($recipients)->send(new \App\Mail\herramentales('Realizacion de mantenimiento', $acciones));

        return back()->with('message', 'Maintenence added successfully.');

    }

    public function toolingAnalysis()
    {
        $value = session('user');
        $cat = session('categoria');

        // --- Lógica de Fechas ---
        $hoy = Carbon::now();

        if ($hoy->isMonday()) {
            // We search from Friday 00:00 to Monday 23:59
            $fechaInicio = $hoy->copy()->subDays(3)->startOfDay()->format('d-m-Y');
            $fechaFin = $hoy->format('d-m-Y');
        } else {
            $fechaInicio = $hoy->copy()->subDay()->startOfDay()->format('d-m-Y');
            $fechaFin = $hoy->copy()->format('d-m-Y');
        }

        /**
         * IMPORTANT:
         * In your screenshot, 'fecha' is YYYY-MM-DD.
         * In your screenshot, 'inimant' and 'finhora' are DD-MM-YYYY.
         * We must use different masks for each!
         */

        // 1. Promedio de Espera
        $promedioespera = Maintanance::selectRaw('
        AVG(TIMESTAMPDIFF(MINUTE, 
            fecha, 
            STR_TO_DATE(inimant, "%d-%m-%Y %H:%i")
        )) as promedio')
            // Correcting the filter: parsing 'fecha' (YYYY-MM-DD) to match your variable (DD-MM-YYYY)
            ->whereRaw('DATE_FORMAT(fecha, "%d-%m-%Y") between ? and ?', [$fechaInicio, $fechaFin])
            ->where('inimant', '!=', '')
            ->where('area', '=', 'maquina')
            ->groupBy('area')
            ->get();

        $promedio = $promedioespera[0]->promedio ?? 0;

        // 2. Time Working (Difference between inimant and finhora)
        $times = Maintanance::selectRaw('COUNT(*) as total_trabajos,
        AVG(TIMESTAMPDIFF(MINUTE, 
            STR_TO_DATE(inimant, "%d-%m-%Y %H:%i"), 
            STR_TO_DATE(finhora, "%d-%m-%Y %H:%i")
        )) as promedio')
            ->whereRaw('DATE_FORMAT(fecha, "%d-%m-%Y") between ? and ?', [$fechaInicio, $fechaFin])
            ->where('inimant', '!=', '')
            ->where('area', '=', 'maquina')
            ->groupBy('area')
            ->get();

        $timeWorking = $times[0]->promedio ?? 0;
        $totalDeTrabajos = $times[0]->total_trabajos ?? 0;

        // 3. Total Times AVG (Difference between fecha and finhora)
        $ttimes = Maintanance::selectRaw('
        AVG(TIMESTAMPDIFF(MINUTE, 
            fecha, 
            STR_TO_DATE(finhora, "%d-%m-%Y %H:%i")
        )) as promedio')
            ->whereRaw('DATE_FORMAT(fecha, "%d-%m-%Y") between ? and ?', [$fechaInicio, $fechaFin])
            ->where('inimant', '!=', '')
            ->where('area', '=', 'maquina')
            ->groupBy('area')
            ->get();

        $totalTimesAVG = $ttimes[0]->promedio ?? 0;

        $tooling = Maintanance::selectRaw('nombreEquipo, COUNT(nombreEquipo) as tiemposVal')
            ->where('area', '=', 'maquina')
            ->groupBy('nombreEquipo')
            ->orderBy('tiemposVal', 'desc')
            ->limit(10)
            ->get();

        // dd($tooling, $promedio, $timeWorking, $totalTimesAVG);

        return view('herramentales.analysis', ['cat' => $cat, 'value' => $value, 'promedioespera' => $promedioespera, 'timeWorking' => $timeWorking,
            'totalTimesAVG' => $totalTimesAVG, 'tooling' => $tooling, 'totalDeTrabajos' => $totalDeTrabajos,
        ]);

    }

    public function filterTooling(Request $request)
    {
        $valor = $request->input('value');
        if ($valor == 'all') {
            $data = herramentalInfo::orderBy('golpesTotales', 'desc')->get();

            return json_encode($data);
        } else {
            $data = herramentalInfo::where('herramental', '=', $valor)
                ->orWhere('terminal', '=', $valor)->orderBy('golpesTotales', 'desc')->get();
        }

        return json_encode($data);

    }
}

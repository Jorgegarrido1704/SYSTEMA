<?php

namespace App\Http\Controllers;

use App\Models\herramentales\golesDiarios;
use App\Models\herramentales\herramentalInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Maintanance;

class herramentalesController extends Controller
{
    //
    public function index()
    {
        $value = session('user');
        $cat = session('categoria');
        if ($value != 'Admin' or $cat == 'herramentales') {
            return redirect('/login');
        }
        $crimpersRequested = DB::table('registro_paro')
            ->select('fecha', 'nombreEquipo', 'id', 'dano', 'quien', 'atiende', 'inimant', 'finhora')
            ->where('finhora', null)
            ->orWhere('finhora', '')
            ->orderBy('id', 'asc')
            ->get();
        $herramntal = herramentalInfo::orderBy('golpesTotales', 'DESC')->orderBy('terminal', 'asc')->get();

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
        $golpesDiarios = preg_replace('/[^0-9]+/', '', $request->input('qtyHits')) ?? 0;
        golesDiarios::create([
            'herramental' => $tooling,
            'terminal' => $termina,
            'fecha_reg' => $date,
            'golpesDiarios' => $request->input('qtyHits'),
        ]);
        if (herramentalInfo::where('herramental', '=', $tooling)->where('terminal', '=', $termina)->where('fecha_reg', '=', $date)->exists()) {
            herramentalInfo::where('herramental', '=', $tooling)->where('terminal', '=', $termina)->update([
                'golpesDiarios' => 'golpesDiarios +'.$request->input('qtyHits'),
                'golpesTotales' => 'golpesTotales +'.$request->input('qtyHits'),

            ]);
        }else{
            herramentalInfo::where('herramental', '=', $tooling)->where('terminal', '=', $termina)->update([
                'fecha_reg'=>carbon::now()->format('d-m-Y'),
                'golpesDiarios' => $request->input('qtyHits'),
                'golpesTotales' => 'golpesTotales +'.$request->input('qtyHits'),

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
        $newTooling=strtoupper($request->input('newTooling'));
        $terminalNewTooling=strtoupper($request->input('terminalNewTooling'));
        $herramental = new herramentalInfo;
        $herramental->herramental = $newTooling;
        $herramental->terminal = $terminalNewTooling;
        $herramental->fecha_reg = Carbon::now()->format('d-m-Y');
        $herramental->save();

        return back()->with('message', 'Inventory added successfully.');
    }
    public function toolingMaintenance(){
          $value = session('user');
        $cat = session('categoria');
        if ($value != 'Admin' or $cat == 'herramentales') {
            return redirect('/login');
        }
        
        $preventivo = herramentalInfo::where('mantenimiento', '=', 'ok')->orderBy('golpesTotales', 'DESC')->orderBy('terminal', 'asc')->get();
        $correctivo =  herramentalInfo::where('mantenimiento', '!=', 'ok')->orderBy('golpesTotales', 'DESC')->orderBy('terminal', 'asc')->get();
        $maintenanceRecord= DB::table('mant_herramental')->orderBy('id', 'desc')->limit(25)->get();
        return view('herramentales.maintenenceTooling', [ 'cat' => $cat, 'value' => $value,
            'preventivo' => $preventivo, 'correctivo' => $correctivo,'maintenanceRecord' => $maintenanceRecord]);

    }
    public function saveMantTooling(Request $request ){
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
        $personal= preg_replace('/[^\p{L} ]/u', ' ', $request->input('personalRegistro')) ?? '';

        DB::table('mant_herramental')->insert([
            'fecha_reg' => Carbon::now()->format('d-m-Y'),
            'tiempos' => Carbon::now()->format('H:i'),
            'herramental' => $tooling,
            'terminal' => $terminal,
            'Minutos' => $minutes,
            'quien' => $personal,
            'docMant' => $observaciones
        ]);

        herramentalInfo::where('herramental', '=', $tooling)->where('terminal', '=', $terminal)->update([
            'mantenimiento' => 'ok',
        ]);
        return back()->with('message', 'Maintenence added successfully.');
        
    }

    public function toolingAnalysis(){
         $value = session('user');
        $cat = session('categoria');
        if ($value != 'Admin' or $cat == 'herramentales') {
            return redirect('/login');
        }
        $promedioespera=Maintanance::selectRaw('AVG(TIMESTAMPDIFF(MINUTE,STR_TO_DATE(fecha, "%d-%m-%Y %H:%i"), STR_TO_DATE(inimant, "%d-%m-%Y %H:%i"))) as promedio')->where('inimant', '!=', '')->where('area', '=', 'maquina')->groupBy('area')->orderBy('id', 'desc')->get();
        $promedio=$promedioespera[0]->promedio;
         $times=Maintanance::selectRaw('AVG(TIMESTAMPDIFF(MINUTE,STR_TO_DATE(inimant, "%d-%m-%Y %H:%i"), STR_TO_DATE(finhora, "%d-%m-%Y %H:%i"))) as promedio')->where('inimant', '!=', '')->where('area', '=', 'maquina')->groupBy('area')->orderBy('id', 'desc')->get();
        $timeWorking=$times[0]->promedio;
         $ttimes=Maintanance::selectRaw('AVG(TIMESTAMPDIFF(MINUTE,STR_TO_DATE(fecha, "%d-%m-%Y %H:%i"), STR_TO_DATE(finhora, "%d-%m-%Y %H:%i"))) as promedio')->where('inimant', '!=', '')->where('area', '=', 'maquina')->groupBy('area')->orderBy('id', 'desc')->get();
        $totalTimesAVG=$ttimes[0]->promedio;
        $tooling=Maintanance::selectRaw('nombreEquipo,COUNT(nombreEquipo) as tiemposVal')->where('area', '=', 'maquina')->groupBy('nombreEquipo')->orderBy('tiemposVal', 'desc')->limit(5)->get();
        
        return view('herramentales.analysis', [ 'cat' => $cat, 'value' => $value,'promedioespera' => $promedio,'timeWorking' => $timeWorking,
            'totalTimesAVG' => $totalTimesAVG,'tooling' => $tooling
            ]);

    }

}

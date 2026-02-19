<?php

namespace App\Http\Controllers;

use App\Models\herramentales\golesDiarios;
use App\Models\herramentales\herramentalInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $herramntal = herramentalInfo::select('herramental', 'terminal')->orderBy('terminal', 'asc')->get();

        return view('herramentales.index', ['crimpersRequested' => $crimpersRequested, 'cat' => $cat, 'value' => $value,
            'herramntal' => $herramntal]);
    }

    public function update(Request $request, $id)
    {
        $nombrePersonalHerrmanetal = $request->input('nombrePersonal') ?? '';
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
        $tooling = explode('||', $request->input('tooling'))[0];
        $termina = explode('||', $request->input('tooling'))[1];
        golesDiarios::create([
            'herramental' => $tooling,
            'terminal' => $termina,
            'fecha_reg' => $date,
            'golpesDiarios' => $request->input('qtyHits'),
        ]);

        return back()->with('message', 'Inventory added successfully.');
    }
}

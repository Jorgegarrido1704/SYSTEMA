<?php

namespace App\Http\Controllers;

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

        return view('herramentales.index', ['crimpersRequested' => $crimpersRequested, 'cat' => $cat, 'value' => $value]);
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
}

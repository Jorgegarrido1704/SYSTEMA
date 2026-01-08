<?php

namespace App\Http\Controllers;

use App\Models\electricalTesting;
use App\Models\regPar;
use Illuminate\Http\Request;

class pruebasElectricasController extends Controller
{
    //
    public function pruebasElecticas()
    {
        $value = session('user');
        $cat = session('categoria');
        if ($value == '') {
            return redirect('/');
        }
        $pruebas = $arneses = [];
        $pruebas = electricalTesting::where('status_of_order', 'Pending')->orWhere('status_of_order', 'In Process')->get();
        $arneses = regPar::where('ensaPar', '!=', 0)->orWhere('loomPar', '!=', 0)->orWhere('specialWire', '!=', 0)->get();

        return view('inge.pruebasElectricas.index', ['value' => $value, 'cat' => $cat, 'pruebas' => $pruebas, 'arneses' => $arneses]);
    }

    public function dispatchElecticalTest(request $request)
    {
        $distch = electricalTesting::where('id', $request->input('id'))->update([
            'status_of_order' => 'Completed']);

        return redirect()->back()->with('message', 'Inventory added successfully.');
    }
}

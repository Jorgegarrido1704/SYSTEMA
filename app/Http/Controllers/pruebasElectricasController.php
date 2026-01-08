<?php

namespace App\Http\Controllers;

use App\Models\electricaltesting;
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
        $pruebas = electricaltesting::where('status_of_order', 'Pending')->orWhere('status_of_order', 'In Process')->get();

        return view('inge.pruebasElectricas.index', ['value' => $value, 'cat' => $cat, 'pruebas' => $pruebas]);
    }

    public function dispatchElecticalTest(request $request)
    {
        $distch = electricaltesting::where('id', $request->input('id'))->update([
            'status_of_order' => 'Completed']);

        return redirect()->back()->with('message', 'Inventory added successfully.');
    }
}

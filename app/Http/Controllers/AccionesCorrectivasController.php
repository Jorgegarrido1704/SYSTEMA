<?php

namespace App\Http\Controllers;

use App\Models\accionesCorrectivas;
use Illuminate\Http\Request;

class AccionesCorrectivasController extends Controller
{
    //
    public function index()
    {
        $cat=session('categoria');
        $value=session('user');
        $accionesActivas = accionesCorrectivas::where('status', '!=', 'finalizada')->orderBy('id_acciones_correctivas', 'ASC')->get();
        $diasRestantes = [];
        foreach ($accionesActivas as $accion) {
            $diasRestantes[$accion->id_acciones_correctivas] = $accion->getDateForFinisg($accion->id_acciones_correctivas);
        }
        return view('accionesCorrectiva.index',[
            'cat' => $cat,
            'value' => $value,
            'accionesActivas' => $accionesActivas,
            'diasRestantes' => $diasRestantes,


        ]);
    }
    public function create(Request $request)
    {
        $request->validate([
            'fechaAccion' => 'required|date',
            'Afecta' => 'required|string|max:50',
            'origenAccion' => 'required|string|max:50',
            'resposableAccion' => 'required|string|max:80',
            'descripcionAccion' => 'required|string|max:500',
            'fechaCompromiso' => 'required|date',
        ]);
        $accion = new accionesCorrectivas();
        $accion->fechaAccion = $request->input('fechaAccion');
        $accion->Afecta = $request->input('Afecta');
        $accion->origenAccion = $request->input('origenAccion');
        $accion->resposableAccion = $request->input('resposableAccion');
        $accion->descripcionAccion = $request->input('descripcionAccion');
        $accion->fechaCompromiso = $request->input('fechaCompromiso');
        $accion->save();

        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva creada exitosamente.');
    }
    public function show($id)
    {
    $cat=session('categoria');
    $value=session('user');
        $accion = accionesCorrectivas::findOrFail($id);
        return view('accionesCorrectiva.show', [
            'accion' => $accion,
            'cat' => $cat,
            'value' => $value,
        ]);
    }
}

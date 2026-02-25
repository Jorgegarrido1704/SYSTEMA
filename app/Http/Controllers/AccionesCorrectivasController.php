<?php

namespace App\Http\Controllers;

use App\Models\accionesCorrectivas;
use App\Models\accionesCorrectivas\monitoreosAcciones;
use App\Models\personalBergsModel;
use App\Models\sub_acciones_model;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccionesCorrectivasController extends Controller
{
    //
    public function index()
    {
        $cat = session('categoria');
        $value = session('user');
        $diasRestantes = [];
        if ($value == 'Admin' or $value == 'Martin A') {
            $accionesActivas = accionesCorrectivas::where('status', '!=', 'finalizada')->orderBy('id_acciones_correctivas', 'ASC')->get();

        } else {
            $accionesActivas = accionesCorrectivas::where('status', '!=', 'finalizada')->where('resposableAccion', $value)->orderBy('id_acciones_correctivas', 'ASC')->get();
        }
        foreach ($accionesActivas as $accion) {
            if ($accion->status == 'Activa - Etapa 1') {
                $diaFinal = Carbon::parse($accion->fechaFinAccion)->addWeekDays(2);
                $accion->faltanDias = Carbon::parse($diaFinal)->diffInDays($accion->fechaAccion);
            }
            $accion->resposableAccion = explode('/', $accion->resposableAccion)[1] ?? $accion->resposableAccion;
        }
        $personal = personalBergsModel::select('employeeLider')->groupBy('employeeLider')->get();

        return view('accionesCorrectiva.index', [
            'cat' => $cat,
            'value' => $value,
            'accionesActivas' => $accionesActivas,
            'diasRestantes' => $diasRestantes,
            'personal' => $personal,

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

        ]);
        if ($request->input('origenAccion') == 'otro') {
            $origenAccion = $request->input('origenAccion').'-'.$request->input('origenAccionotro');
        } else {
            $origenAccion = $request->input('origenAccion');
        }
        $cantidadAccionesHoy = accionesCorrectivas::whereYear('fechaAccion', $request->input('fechaAccion'))->count();
        $cantidadAccionesHoy = $cantidadAccionesHoy + 1;
        if ($cantidadAccionesHoy == 0) {
            $cantidadAccionesHoy = '001';
        } elseif ($cantidadAccionesHoy < 10) {
            $cantidadAccionesHoy = '00'.$cantidadAccionesHoy;
        } elseif ($cantidadAccionesHoy < 100) {
            $cantidadAccionesHoy = '0'.$cantidadAccionesHoy;
        } // dd($cantidadAccionesHoy);
        $accion = new accionesCorrectivas;
        $accion->folioAccion = 'AC-'.carbon::parse($request->input('fechaAccion'))->format('Y').'-'.$cantidadAccionesHoy;
        $accion->fechaAccion = $request->input('fechaAccion');
        $accion->Afecta = $request->input('Afecta');
        $accion->origenAccion = $origenAccion;
        $accion->resposableAccion = $request->input('resposableAccion');
        $accion->descripcionAccion = $request->input('descripcionAccion');
        $accion->save();

        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva creada exitosamente.');
    }

    public function show($id)
    {
        $cat = session('categoria');
        $value = session('user');
        $problema = 'Alta rotación de empleados';
        $categorias = [];
        $registroPorquest = accionesCorrectivas::where('folioAccion', $id)->first();
        if (! empty($registroPorquest->porques)) {
            $categorias = explode(' | ', $registroPorquest->porques);
        } elseif (! empty($registroPorquest->Ishikawa)) {
            $categorias = json_decode($registroPorquest->Ishikawa, true);

        }

        $acciones = sub_acciones_model::where('folioAccion', $id)->get();

        $personal = personalBergsModel::select('employeeLider')->groupBy('employeeLider')->get();
        $seguimientosSubAcciones = monitoreosAcciones::where('folioAccion', $registroPorquest->folioAccion)
            ->orderBy('idSubAccion', 'ASC')
            ->orderBy('id', 'ASC')->get();

        return view('accionesCorrectiva.show', [
            'acciones' => $acciones,
            'cat' => $cat,
            'value' => $value,
            'problema' => $problema,
            'categorias' => $categorias,
            'registroPorquest' => $registroPorquest,
            'seguimientosSubAcciones' => $seguimientosSubAcciones,
            'personal' => $personal,

        ]);
    }

    public function guardarPorques(Request $request)
    {
        $request->validate([
            'porque1' => 'required|string|max:500',
            'conclusion' => 'required|string|max:500',
            'accion_id' => 'required|integer',
        ]);
        $registroPorquest = $request->input('porque1');

        for ($i = 2; $i <= 5; $i++) {
            $key = 'porque'.$i;
            if ($request->filled($key)) {
                $registroPorquest .= ' | '.$request->input($key);
            }
        }
        if ($request->input('sistemic') != 'NO') {
            $sistemic = true;
        } else {
            $sistemic = false;
        }
        // dd($sistemic.' '.$registroPorquest.' '.$request->input('conclusion').' '.$request->input('accion_id'));
        $accion = accionesCorrectivas::findOrFail($request->input('accion_id'));
        $accion->porques = $registroPorquest;
        $accion->conclusiones = $request->input('conclusion');
        $accion->IsSistemicProblem = $sistemic;
        $accion->status = 'etapa 2 - Causa Raiz';
        $accion->save();

        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva actualizada exitosamente.');
    }

    public function guardarIshikawa(Request $request)
    {
        $request->validate([
            'problema1' => 'required|string|max:500',
            'motivo1' => 'required|string|max:500',
            'conclusion' => 'required|string|max:500',
            'accion_id' => 'required|integer',
        ]);
        $registroPorquest = [
            'porque1' => $request->input('porque1'),
        ];
        $datosIshikawa = [
            $request->input('problema1') => $request->input('motivo1'),
        ];

        for ($i = 2; $i <= 5; $i++) {

            if ($request->filled('problema'.$i)) {
                $datosIshikawa[$request->input('problema'.$i)] = $request->input('motivo'.$i);
            }
        }

        if ($request->input('sistemic') != 'NO') {
            $sistemic = true;
        } else {
            $sistemic = false;
        }
        $accion = accionesCorrectivas::findOrFail($request->input('accion_id'));
        $accion->Ishikawa = $datosIshikawa;
        $accion->conclusiones = $request->input('conclusion');
        $accion->IsSistemicProblem = $sistemic;
        $accion->status = 'etapa 2 - Causa Raiz';
        $accion->save();

        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva actualizada exitosamente.');
    }

    public function guardarAccion(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:15',
            'accion' => 'required|string|max:500',
            'reponsableAccion' => 'required|string|max:500',
            'fechaInicioAccion' => 'required|date',
            'fechaFinAccion' => 'required|date',
            'verificadorAccion' => 'required|string|max:500',
        ]);
        sub_acciones_model::create([
            'folioAccion' => $request->input('id'),
            'descripcionSubAccion' => $request->input('accion'),
            'resposableSubAccion' => $request->input('reponsableAccion'),
            'fechaInicioSubAccion' => $request->input('fechaInicioAccion'),
            'fechaFinSubAccion' => $request->input('fechaFinAccion'),
            'auditorSubAccion' => $request->input('verificadorAccion'),

        ]);

        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $accion = accionesCorrectivas::findOrFail($id);
        $accion->delete();

        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva eliminada exitosamente.');
    }

    public function guardarSeguimiento(Request $request, $id, $folio)
    {
        /* $request->validate([
             'accion_id' => 'required|integer',
             'seguimiento' => 'required|string|max:500',
             'validador' => 'required|string|max:500',
         ]);*/

        monitoreosAcciones::create([
            'folioAccion' => $folio,
            'idSubAccion' => $id,
            'descripcionSeguimiento' => $request->input('seguimiento'),
            'AprobadorSeguimiento' => $request->input('validador'),
        ]);

        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva actualizada exitosamente.');

    }
}

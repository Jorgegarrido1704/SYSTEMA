<?php

namespace App\Http\Controllers;

use App\Models\accionesCorrectivas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\accionesCorrectivas\acciones;
use App\Models\accionesCorrectivas\monitoreosAcciones;

class AccionesCorrectivasController extends Controller
{
    //
    public function index()
    {
        $cat = session('categoria');
        $value = session('user');
        $diasRestantes = [];
        if($value=='Admin' or $value=='Martin A'){
             $accionesActivas = accionesCorrectivas::where('status', '!=', 'finalizada')->orderBy('id_acciones_correctivas', 'ASC')->get();

        }
        else{
            $accionesActivas = accionesCorrectivas::where('status', '!=', 'finalizada')->where('resposableAccion', $value)->orderBy('id_acciones_correctivas', 'ASC')->get();
        }
        foreach ($accionesActivas as $accion) {
            $diasRestantes[$accion->id_acciones_correctivas] = $accion->fechaAccion->addWeekDays(2)->format('Y-m-d');
        }
        return view('accionesCorrectiva.index', [
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

        ]);
        if($request->input('origenAccion')=='otro'){
             $origenAccion= $request->input('origenAccion')."-".$request->input('origenAccionotro');
        }else{
           $origenAccion= $request->input('origenAccion');
        }
        $cantidadAccionesHoy= accionesCorrectivas::whereDate('fechaAccion', $request->input('fechaAccion'))->count();

        $accion = new accionesCorrectivas();
        $accion->folioAccion = "C-" . carbon::parse($request->input('fechaAccion'))->format('dmY') . ($cantidadAccionesHoy + 1);
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
        $problema = "Alta rotación de empleados";
        $categorias = [];
        $registroPorquest = accionesCorrectivas::findOrFail($id);
      if (!empty($registroPorquest->porques)) {
        $categorias = json_decode($registroPorquest->porques, true);
        } else if ($registroPorquest->Ishikawa != null) {
            $categorias = json_decode($registroPorquest->Ishikawa, true);

        }


        $acciones = acciones::where('folioAccion', $registroPorquest->folioAccion)->get();

        $diasRestantes = [];
        foreach ($acciones as $accion) {
            $diasRestantes[$accion->id] = $accion->fechaFinAccion->diffInDays($accion->fechaInicioAccion);
            $seguimientos = monitoreosAcciones::where('folioAccion', $accion->id)->orderBy('folioAccion', 'DESC')->get();

            foreach ($seguimientos as $seguimiento) {
                $registrosSeguimientos[$accion->id][$seguimiento->id] = [
                    'fecha' => $seguimiento->created_at,
                    'seguimiento' => $seguimiento->descripcionSeguimiento,
                    'aprobador' => $seguimiento->AprobadorSeguimiento,
                    'comentario' => $seguimiento->comentariosSeguimiento

            ];
            }
        }


        return view('accionesCorrectiva.show', [
            'acciones' => $acciones,
            'cat' => $cat,
            'value' => $value,
            'problema' => $problema,
            'categorias' => $categorias,
            'diasRestantes' => $diasRestantes,
            'registroPorquest' => $registroPorquest,
            'registrosSeguimientos' => $registrosSeguimientos??[],

        ]);
    }
    public function guardarPorques(Request $request)
    {
        $request->validate([
            'porque1' => 'required|string|max:500',
            'conclusion' => 'required|string|max:500',
            'accion_id' => 'required|integer'
        ]);
        $registroPorquest = [
            'porque1' => $request->input('porque1')
        ];

        for ($i = 2; $i <= 5; $i++) {
            $key = 'porque' . $i;
            if ($request->filled($key)) {
                $registroPorquest[$key] = $request->input($key);
            }
        }
        if ($request->input('sistemic') != 'NO') {
            $sistemic = true;
        }else{
            $sistemic = false;
        }
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
            'accion_id' => 'required|integer'
        ]);
        $registroPorquest = [
            'porque1' => $request->input('porque1')
        ];
        $datosIshikawa = [
            $request->input('problema1') => $request->input('motivo1')
        ];

        for ($i = 2; $i <= 5; $i++) {

            if ($request->filled('problema'.$i)) {
                $datosIshikawa[$request->input('problema'.$i)] = $request->input('motivo'.$i);
            }
        }

        if ($request->input('sistemic') != 'NO') {
            $sistemic = true;
        }else{
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
            'id'=>'required|string|max:15',
            'accion' => 'required|string|max:500',
            'reponsableAccion' => 'required|string|max:500',
            'fechaInicioAccion' => 'required|date',
            'fechaFinAccion' => 'required|date',
            'verificadorAccion' => 'required|string|max:500',
        ]);
         acciones::create([
            'folioAccion' =>$request->input('id'),
       'accion' => $request->input('accion'),
       'reponsableAccion' => $request->input('reponsableAccion'),
       'fechaInicioAccion' => $request->input('fechaInicioAccion'),
       'fechaFinAccion' => $request->input('fechaFinAccion'),
       'verificadorAccion' => $request->input('verificadorAccion'),

        ]);
        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva actualizada exitosamente.');
    }
    public function destroy($id)
    {
        $accion = accionesCorrectivas::findOrFail($id);
        $accion->delete();
        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva eliminada exitosamente.');
    }
    public function guardarSeguimiento (Request $request,){
        $request->validate([
            'accion_id' => 'required|integer',
            'seguimiento' => 'required|string|max:500',
            'validador' => 'required|string|max:500',
        ]);

        monitoreosAcciones::create([
            'folioAccion' =>$request->input('accion_id'),
            'descripcionSeguimiento' => $request->input('seguimiento'),
            'AprobadorSeguimiento' => $request->input('validador'),
        ]);
        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva actualizada exitosamente.');

    }
}

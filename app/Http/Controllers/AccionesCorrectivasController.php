<?php

namespace App\Http\Controllers;

use App\Models\accionesCorrectivas;
use Illuminate\Http\Request;

class AccionesCorrectivasController extends Controller
{
    //
    public function index()
    {
        $cat = session('categoria');
        $value = session('user');
        $accionesActivas = accionesCorrectivas::where('status', '!=', 'finalizada')->orderBy('id_acciones_correctivas', 'ASC')->get();
        $diasRestantes = [];
        foreach ($accionesActivas as $accion) {
            $diasRestantes[$accion->id_acciones_correctivas] = $accion->getDateForFinisg($accion->id_acciones_correctivas);
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
        $cat = session('categoria');
        $value = session('user');
        $problema = "Alta rotación de empleados";
        $categorias = [];
        $mermaid = "";
        $registroPorquest = accionesCorrectivas::findOrFail($id);
      if (!empty($registroPorquest->porques)) {
        $categorias = json_decode($registroPorquest->porques, true);
        } else if ($registroPorquest->Ishikawa != null) {
            $categorias = json_decode($registroPorquest->Ishikawa);
            $mermaid = "graph LR\n";

            foreach ($categorias as $cats => $causas) {
                $cats_id = str_replace(' ', '_', $cats);
                $mermaid .= "    {$cats_id} -->|{$cats}| Problema\n";

                foreach ($causas as $i => $causa) {
                    $causa_id = $cats_id . "_" . $i;
                    $mermaid .= "    {$causa_id}[\"{$causa}\"] --> {$cats_id}\n";
                }
            }

            $mermaid .= "    Problema(\"$problema\")\n";
        }



        $accion = accionesCorrectivas::findOrFail($id);
        return view('accionesCorrectiva.show', [
            'accion' => $accion,
            'cat' => $cat,
            'value' => $value,
            'problema' => $problema,
            'categorias' => $categorias,

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
        if ($request->input('sistemic') != null) {
            $sistemic = true;
        }else{
            $sistemic = false;
        }
        $accion = accionesCorrectivas::findOrFail($request->input('accion_id'));
        $accion->porques = $registroPorquest;
        $accion->conclusiones = $request->input('conclusion');
        $accion->IsSistemicProblem = $sistemic;
        $accion->save();
        return redirect()->route('accionesCorrectivas.index')->with('success', 'Acción correctiva actualizada exitosamente.');
    }
}

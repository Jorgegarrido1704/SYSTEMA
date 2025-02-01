<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\salud;
use App\Models\inventaryMedicine;
use App\Models\inOutMedi;
class SaludController extends Controller
{
    //
    public function index_salud(){
        $cat=session('categoria');
        $user=session('user');
        $buscarFolio = DB::table('salud')->orderBy('id_salud', 'desc')->first();
        if($buscarFolio==null){
            $folio=1;
        }else{
            $folio=$buscarFolio->id_salud+1;
        }
        return view('salud.salud',['cat'=>$cat,'user'=>$user,'folio'=>$folio]);
    }

    public function visita_enfermeria(Request $request)
    {
        // Get all input data
        $datos = $request->all();
        $datos['nomEmp'] = $request->input('nomEmp');
        $datos['nombreEmp'] = $request->input('nombreEmp');
        $datos['cargo'] = $request->input('cargo');
        $datos['area'] = $request->input('area');
        $datos['supervisor'] = $request->input('supervisor');
        $datos['motivo'] = $request->input('motivo');
        $datos['comentarios'] = $request->input('comentarios');
        $datos['medicamentos'] = $request->input('medicamentos');

        /* Validate incoming data (optional but recommended)
        $validatedData = $request->validate([
            'nomEmp' => 'required|numeric',
            'nombreEmp' => 'required|string',
            'cargo' => 'required|string',
            'area' => 'required|string',
            'supervisor' => 'required|string',
            'motivo' => 'required|string',
            'comentarios' => 'required|string',
            'medicamentos' => 'nullable|array',
            'medicamentos.*.medicamento' => 'required|string',
            'medicamentos.*.cantidad' => 'required|numeric',
        ]);*/

        // Get the current date and time
        $fechaVisita = now();

        // Create a new VisitaEnfermeria entry in the database
        $visita = new salud();
        $visita->employee = $datos['nomEmp'] . '-' . $datos['nombreEmp'] . '-' . $datos['cargo'] . '-' . $datos['area'] . '-' . $datos['supervisor'];
        $visita->motive = $datos['motivo'];
        $visita->Diagnostic = $datos['comentarios'];
        $visita->dateVisit = $fechaVisita;
        $visita->save();

        // Save medicamento data if available
        if (isset($datos['medicamentos'])) {
            foreach ($datos['medicamentos'] as $medicamentoData) {
                // Create a new inOutMedi entry for each medicamento
                $medicamento = new inOutMedi();
                $medicamento->medicament = $medicamentoData['medicamento'];
                $medicamento->qtyMove = $medicamentoData['cantidad'];
                $medicamento->dateMove = $fechaVisita;
                $medicamento->id_visEnf = $visita->id;
                $medicamento->save();
            }
        }

        // Redirect or return response after saving data
        return redirect()->route('salud')->with('success', 'Visita Enfermería saved successfully');
    }


}

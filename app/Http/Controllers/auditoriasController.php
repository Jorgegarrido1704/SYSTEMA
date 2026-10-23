<?php

namespace App\Http\Controllers;

use App\Models\personalBergsModel;
use App\Models\regPar;
use App\Mail\auditorias\cvts_orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class auditoriasController extends Controller
{
    //
    public function cvts_orders()
    {
        $value = session('user');
        $cat = session('categoria');
        if ($value == '' or $cat == '') {
            return view('login');
        }
        $responsables = personalBergsModel::select('employeeLider')->distinct()->get();

        return view('auditorias.cvts.auditoria_ordenes', ['value' => $value, 'cat' => $cat,'responsables'=>$responsables]);
    }
    public function jsonDatosWo(Request $request){
        $wo = $request->input('wo');
        $data_wo =regPar::where('wo',$wo)->get();    
        return json_encode($data_wo);
    }
    public function safeData(Request $request){
        $data = $request->all();
        
        $status= $data['status'];
        $cuantos = COUNT($status);
        $cuenta =0;
        $registos=[];
        foreach($status as $st){
            if($st=='OK'){
                $cuenta++;
            }
        }
        
        $resultados= round(($cuenta/$cuantos)*100,2);
        Mail::to('jgarrido@mx.bergstrominc.com')->send(new cvts_orders($data, $resultados,'Auditorias CVTS ordenes.'));

        return redirect()->back()->wiht(['success'=>'Registro guardado exitosamente']);
    }
}

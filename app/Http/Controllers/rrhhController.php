<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\assistence;
use App\Models\rrhh\rotacionModel;
use Illuminate\Http\Request;
use App\Jobs\UpdateRotacionJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class rrhhController extends Controller
{
    public function rrhhDashBoard()
    {
        $value=session('user');
        $cat=session('categoria');

            $datosRHWEEK = assistence::leader($value)->OrderBy('lider', 'desc')->get();
            if($value == 'Admin' or $value == 'Paola A'){
                $diasRegistro=['','','','','',''];
            }else{
                $diasRegistro=['readonly','readonly','readonly','readonly','readonly'];
                $diasRegistros=['','','','',''];
            }
                $datosRHWEEK = assistence::leader($value,$cat)->OrderBy('lider', 'desc')->get();

             $diaNum=carbon::now()->dayOfWeek; //

             if($diaNum == 5 or $diaNum == 6 or $diaNum == 7){
                 $diasRegistro[4]='';
                 $diasRegistros[4]='';

             }else{
                 $diasRegistro[$diaNum-1]='';
                 $diasRegistros[$diaNum-1]='';
             }

        return view('juntas/hrDocs/rrhhDashBoard',['diasRegistros'=>$diasRegistros,'diasRegistro'=>$diasRegistro,'datosRHWEEK'=>$datosRHWEEK,'value'=>$value,'cat'=>$cat]);

}

    public function updateAsistencia(Request $request)
{
    $week = date('W');

    $validated = $request->validate([
        'lun' => 'required|array',
        'extra_lun' => 'required|array',
        'mar' => 'required|array',
        'extra_mar' => 'required|array',
        'mie' => 'required|array',
        'extra_mie' => 'required|array',
        'jue' => 'required|array',
        'extra_jue' => 'required|array',
        'vie' => 'required|array',
        'extra_vie' => 'required|array',
        'sab' => 'required|array',
        'extra_sab' => 'required|array',
        'dom' => 'required|array',
        'extra_dom' => 'required|array',
        'numero_empleado' => 'required|array',
    ]);

    foreach ($validated['numero_empleado'] as $index => $id_empleado) {
        $updateData = [
            'lunes' => $validated['lun'][$index] ?  strtoupper(str_replace('-', '', $validated['lun'][$index])):strtoupper('-', '', $validated['lun'][$index]),
            'extLunes' => $validated['extra_lun'][$index],
            'martes' => $validated['mar'][$index] ?  strtoupper(str_replace('-', '', $validated['mar'][$index])):strtoupper($validated['mar'][$index]),
            'extMartes' => $validated['extra_mar'][$index],
            'miercoles' => $validated['mie'][$index] ?  strtoupper(str_replace('-', '', $validated['mie'][$index])): strtoupper( $validated['mie'][$index]),
            'extMiercoles' => $validated['extra_mie'][$index],
            'jueves' => $validated['jue'][$index] ?  strtoupper(str_replace('-', '', $validated['jue'][$index])):strtoupper($validated['jue'][$index]),
            'extJueves' => $validated['extra_jue'][$index],
            'viernes' => $validated['vie'][$index] ?  strtoupper(str_replace('-', '', $validated['vie'][$index])): strtoupper($validated['vie'][$index]),
            'extViernes' => $validated['extra_vie'][$index],
            'sabado' => $validated['sab'][$index] ?  strtoupper(str_replace('-', '', $validated['sab'][$index])):strtoupper($validated['sab'][$index]),
            'extSabado' => $validated['extra_sab'][$index],
            'domingo' =>$validated['dom'][$index] ?  strtoupper(str_replace('-', '', $validated['dom'][$index])): strtoupper($validated['dom'][$index]),
            'extDomingo' => $validated['extra_dom'][$index],
            'extras' => $validated['extra_lun'][$index] + $validated['extra_mar'][$index] + $validated['extra_mie'][$index] + $validated['extra_jue'][$index] + $validated['extra_vie'][$index] + $validated['extra_sab'][$index] + $validated['extra_dom'][$index],
        ];

        assistence::where('id_empleado', $id_empleado)
            ->where('week', $week)
            ->update($updateData);
    }
    //send a job to update rotacion
        UpdateRotacionJob::dispatch();


    return redirect()->route('rrhhDashBoard');
}


}

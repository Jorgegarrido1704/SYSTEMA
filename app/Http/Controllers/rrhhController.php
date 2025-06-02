<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\assistence;
use Illuminate\Http\Request;

class rrhhController extends Controller
{
    public function rrhhDashBoard()
    {
        $value=session('user');
        $cat=session('categoria');
        if($cat == 'RRHH'){
       $datosRHWEEK = assistence::changeInfo()->OrderBy('lider', 'desc')->get();
       $diasRegistro = ['','','','',''];

        }else{
            $datosRHWEEK = assistence::leader($value)->OrderBy('lider', 'desc')->get();
             $diasRegistro=['disabled','disabled','disabled','disabled','disabled'];
             $diaNum=carbon::now()->dayOfWeek; //

             if($diaNum == 5 or $diaNum == 6 or $diaNum == 7){
                 $diasRegistro[4]='';
             }else{
                 $diasRegistro[$diaNum-1]='';
             }

        return view('juntas/hrDocs/rrhhDashBoard',['diasRegistro'=>$diasRegistro,'datosRHWEEK'=>$datosRHWEEK,'value'=>$value,'cat'=>$cat]);
    }
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
            'lunes' => $validated['lun'][$index],
            'extLunes' => $validated['extra_lun'][$index],
            'martes' => $validated['mar'][$index],
            'extMartes' => $validated['extra_mar'][$index],
            'miercoles' => $validated['mie'][$index],
            'extMiercoles' => $validated['extra_mie'][$index],
            'jueves' => $validated['jue'][$index],
            'extJueves' => $validated['extra_jue'][$index],
            'viernes' => $validated['vie'][$index],
            'extViernes' => $validated['extra_vie'][$index],
            'sabado' => $validated['sab'][$index],
            'extSabado' => $validated['extra_sab'][$index],
            'domingo' => $validated['dom'][$index],
            'extDomingo' => $validated['extra_dom'][$index],
        ];

        assistence::where('id_empleado', $id_empleado)
            ->where('week', $week)
            ->update($updateData);
    }

    return redirect()->route('rrhhDashBoard');
}


}

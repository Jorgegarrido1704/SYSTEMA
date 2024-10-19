<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class bossController extends Controller
{
    public function __invoke()
    {
        $value = session('user');
        $cat=session('categoria');
        if ($cat!='Boss' or $value == '') {
            return view('login');
        } else {

            $homeController = new HomeController();
            $date = $homeController->fetchdata();
            $backlock=0;
        for($i=0;$i<13;$i++){
            $client[$i]=0;  }
        $buscarregistros=DB::select("SELECT * FROM registro WHERE Qty>'0'");
        foreach($buscarregistros as $reg){
            $price=$reg->price;
            $cant=$reg->Qty;
            if($reg->cliente=='BERGSTROM'){
                $client[0]=$client[0]+($price*$cant);
            }else if($reg->cliente=='ATLAS COPCO'){
                $client[1]+=($price*$cant);
            }else if($reg->cliente=='BLUE BIRD'){
                $client[2]+=($price*$cant);
            }else if($reg->cliente=='COLLINS'){
                $client[3]+=($price*$cant);
            }else if($reg->cliente=='EL DORADO CALIFORNIA'){
                $client[4]+=($price*$cant);
            }else if($reg->cliente=='FOREST' or $reg->cliente=='FOREST RIVER'){
                $client[5]+=($price*$cant);
            }else if($reg->cliente=='KALMAR'){
                $client[6]+=($price*$cant);
            }else if($reg->cliente=='MODINE'){
                $client[7]+=($price*$cant);
            }else if($reg->cliente=='PHOENIX MOTOR CARS' or $reg->cliente=='PROTERRA'){
                $client[8]+=($price*$cant);
            }else if($reg->cliente=='SPARTAN'){
                $client[9]+=($price*$cant);
            }else if($reg->cliente=='TICO MANUFACTURING' ){
                $client[10]+=($price*$cant);
            }else if($reg->cliente=='UTILIMASTER' ){
                $client[11]+=($price*$cant);
            }else if($reg->cliente=='ZOELLER' ){
                $client[12]+=($price*$cant);}
            $backlock+=($price*$cant); }
        for($i=0;$i<13;$i++){
            $client[$i]=round((($client[$i]*100)/$backlock),3);
        }
$i=0;
$info=[];
            $buscarInfo=DB::table('desvation')->where('fpro','')->where('count','!=',5)->orderBy('id','DESC')->get();
        foreach($buscarInfo as $rowInf){
            $info[$i][0]=$rowInf->fecha;
            $info[$i][1]=$rowInf->cliente;
            $info[$i][2]=$rowInf->quien;
            $info[$i][3]=$rowInf->Mafec;
            $info[$i][4]=$rowInf->porg;
            $info[$i][5]=$rowInf->psus;
            $info[$i][6]=$rowInf->clsus;
            $info[$i][7]=$rowInf->peridoDesv;
            $info[$i][8]=$rowInf->Causa;
            $info[$i][9]=$rowInf->accion;
            $info[$i][10]=$rowInf->evidencia;
            $info[$i][11]=$rowInf->id;
            $i++;
        }
        $fechaVenta=date("d-m-Y");
        $preReg = [];
$inform = [];
$i = 0;
$x = 0;

// Obtener todos los PN únicos para la fecha dada
$buscaprecio = DB::table('regsitrocalidad')
    ->distinct('pn')
    ->where('fecha', 'like', $fechaVenta . '%')
    ->orderBy('id', 'DESC')
    ->get();

// Almacenar los PN únicos en un array
foreach ($buscaprecio as $row) {
    $preReg[] = $row->pn;
}
$preReg = array_unique($preReg);
// Recorrer los PN y buscar la cantidad y el precio para cada uno
foreach ($preReg as $pns) {
    // Buscar todas las ocurrencias del PN en la misma fecha
    $buscarcant = DB::table('regsitrocalidad')
        ->where('fecha', 'like', $fechaVenta . '%')
        ->where('pn', $pns)
        ->count(); // Contamos las ocurrencias en lugar de obtener todos los registros

    // Buscar el precio más reciente de ese PN
    $buscarPrice = DB::table('precios')
        ->where('pn', $pns)
        ->orderBy('id', 'DESC')
        ->first();

    // Si se encuentra un precio, procedemos
    if ($buscarPrice) {
        $inform[$x][0] = $buscarPrice->client;  // Cliente del PN
        $inform[$x][1] = $pns;                 // Número de parte (PN)
        $inform[$x][2] = $buscarcant;          // Cantidad de ocurrencias
        $inform[$x][3] = $buscarPrice->price;  // Precio del PN
        $inform[$x][4] = $buscarPrice->price * $inform[$x][2];  // Total: precio * cantidad
        $x++;
    } else {
        // Si no se encuentra un precio, puedes optar por manejar esto de alguna forma
        // Ejemplo: establecer valores por defecto o registrar una advertencia.
        $inform[$x][0] = 'Cliente no encontrado';
        $inform[$x][1] = $pns;
        $inform[$x][2] = $buscarcant;
        $inform[$x][3] = 'Precio no disponible';
        $inform[$x][4] = 0; // Total sería 0 si no hay precio
        $x++;
    }
}


        $countReq=count($info);
            return view('boss', ['inform'=>$inform,'value' => $value, 'date' => $date,'countReq'=>$countReq,'cat'=>$cat,'client'=>$client]);

    }
}
    public function pending(Request $request){

        $value=session('user');
        $cat=session('categoria');
        if($cat==''){
            return view('login');
        }else{
        $info=[];
        $i=$id=0;
        $id=$request->input('id');
        if($id!=""){
            $date=date("d-m-Y");
            $updateId=DB::table('desvation')->where('id',$id)->update(['fpro'=>$date]);
            return redirect('boss');
        }
        $buscarInfo=DB::table('desvation')->where('fpro','')->where('count','!=',5)->orderBy('id','DESC')->get();
        foreach($buscarInfo as $rowInf){
            $info[$i][0]=$rowInf->fecha;
            $info[$i][1]=$rowInf->cliente;
            $info[$i][2]=$rowInf->quien;
            $info[$i][3]=$rowInf->Mafec;
            $info[$i][4]=$rowInf->porg;
            $info[$i][5]=$rowInf->psus;
            $info[$i][6]=$rowInf->clsus;
            $info[$i][7]=$rowInf->peridoDesv;
            $info[$i][8]=$rowInf->Causa;
            $info[$i][9]=$rowInf->accion;
            $info[$i][10]=$rowInf->evidencia;
            $info[$i][11]=$rowInf->id;
            $i++;
        }
        return view('/pending/pending',['value'=>$value,'info'=>$info,'cat'=>$cat]);
    }
    }

}

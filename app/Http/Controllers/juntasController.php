<?php

namespace App\Http\Controllers;

use App\Http\Controllers\calidadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class juntasController extends Controller
{
public function index_junta(){
    $value = session('user');
        $cat=session('categoria');
        if ($cat!='junta' or $value == '') {
            return view('login');
        } else {
            $backlock=$cal=0;
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
            //Stations
        $ventasStation = [];
        for($i=0;$i<13;$i++){
            $ventasStation[$i]=0;  }
        $BuscarVenta=DB::select("SELECT * FROM registro ");
        foreach($BuscarVenta as $reg){
            if($reg->count=='1'){
                $ventasStation[0]+=round($reg->Qty*$reg->price,2);
        }
        if($reg->count=='2' or $reg->count=='3' or $reg->count=='17'){
            $ventasStation[1]+=round($reg->Qty*$reg->price,2);
        }
        if($reg->count=='4' or $reg->count=='5' or $reg->count=='16'){
            $ventasStation[2]+=round($reg->Qty*$reg->price,2);
        }
        if($reg->count=='6' or $reg->count=='7' or $reg->count=='13'){
            $ventasStation[3]+=round($reg->Qty*$reg->price,2);
        }
        if($reg->count=='8' or $reg->count=='9' or $reg->count=='14'){
            $ventasStation[4]+=round($reg->Qty*$reg->price,2);
        }
        if($reg->count=='10' or $reg->count=='11' or $reg->count=='18'){
            $ventasStation[5]+=round($reg->Qty*$reg->price,2);
        }
        if($reg->count=='12'){
            $ventasStation[12]+=round($reg->Qty*$reg->price,2);
        }

    }
    if($ventasStation[0]!=0){
        $ventasStation[6]=round($ventasStation[0]/$backlock,2);
    }
    if($ventasStation[1]!=0){
        $ventasStation[7]=round($ventasStation[1]/$backlock,2);
    }
    if($ventasStation[2]!=0){
        $ventasStation[8]=round($ventasStation[2]/$backlock,2);
    }
    if($ventasStation[3]!=0){
        $ventasStation[9]=round($ventasStation[3]/$backlock,2);
    }
    if($ventasStation[4]!=0){
        $ventasStation[10]=round($ventasStation[4]/$backlock,2);
    }
    if($ventasStation[5]!=0){
        $ventasStation[11]=round($ventasStation[5]/$backlock,2);
    }
    if($ventasStation[12]!=0){
        $ventasStation[13]=round($ventasStation[12]/$backlock,2);
    }
        //desviations
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
        //ventas
        $fechaVenta=date("d-m-Y",strtotime("-1 days"));
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

        $buscarregistross=DB::select("SELECT * FROM registro WHERE Qty>'0'");
        foreach($buscarregistross as $reg){
            $price=$reg->price;
            $cant=$reg->Qty;
            $backlock+=($price*$cant);
        }
    $today = strtotime(date("d-m-Y 00:00", strtotime('-1 days')));
    $count = $preciot = $saldo = 0;
    $fecha = $info = $cliente = $pn = $cantidad = [];
    $tested = DB::select('SELECT * FROM regsitrocalidad ORDER BY id DESC'  );

    foreach ($tested as $registro) {
        $date = $registro->fecha;
        $code = $registro->info;
        $clients = $registro->client;
        $part = $registro->pn;
        $cant = $registro->resto;
        $fechacontrol = strtotime($date);

        if ($today < $fechacontrol) {
            if (in_array($code, $info)) {
                $index = array_search($code, $info);
                $cantidad[$index] += $cant;
            } else {
                $fecha[] = $date;
                $info[] = $code;
                $cliente[] = $clients;
                $pn[] = $part;
                $cantidad[] = $cant;
            }
        }

        $count = count($fecha);
    }

    for ($i = 0; $i < $count; $i++) {
        $precioparte = $pn[$i];
        $precio = DB::select("SELECT price FROM precios WHERE pn=?", [$precioparte]);
        foreach ($precio as $pricepn) {
            //$saldo += $pricepn->price * $cantidad[$i];
        }
    }

    // Prepare the updated table content
    $tableContent = '';
    for ($i = 0; $i < $count; $i++) {
        $tableContent .= '<tr>';
        $tableContent .= '<td>' . $fecha[$i] . '</td>';
        $tableContent .= '<td>' . $pn[$i] . '</td>';
        $tableContent .= '<td>' . $info[$i] . '</td>';
        $tableContent .= '<td>' . $cliente[$i] . '</td>';
        $tableContent .= '<td>' . $cantidad[$i] . '</td>';
        $tableContent .= '</tr>';
    }
    $diario=date("d-m-Y", strtotime('-1 days'));
    $ochoAm=$sieteAm=$nueveAm=$diesAm=$onceAm=$docePm=$unaPm=$dosPm=$tresPm=$cuatroPm=$cincoPm=$seisPm=$sietePm=0;

    $busPorTiemp=DB::table("regsitrocalidad")->where("fecha","LIKE","$diario 07:%")
                                            ->orwhere("fecha","LIKE","$diario 08:%")
                                            ->orwhere("fecha","LIKE","$diario 09:%")
                                            ->orwhere("fecha","LIKE","$diario 10:%")
                                            ->orwhere("fecha","LIKE","$diario 11:%")
                                            ->orwhere("fecha","LIKE","$diario 12:%")
                                            ->orwhere("fecha","LIKE","$diario 13:%")
                                            ->orwhere("fecha","LIKE","$diario 14:%")
                                            ->orwhere("fecha","LIKE","$diario 15:%")
                                            ->orwhere("fecha","LIKE","$diario 16:%")
                                            ->orwhere("fecha","LIKE","$diario 17:%")
                                            ->orwhere("fecha","LIKE","$diario 18:%")
                                            ->orwhere("fecha","LIKE","$diario 19:%")
                                            ->orwhere("fecha","LIKE","$diario 20:%")
                                                                             ->get();


    foreach($busPorTiemp as $rowstime){
        switch(substr($rowstime->fecha,11,2)){
            case '07':
                $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();

                $sieteAm+=$busarPrecio->price;
                break;
            case '08':
                $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                    $ochoAm+=$busarPrecio->price;
                break;
            case '09':
                 $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                  $nueveAm+=$busarPrecio->price;
                    break;
            case '10':
                    $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                            $diesAm+=$busarPrecio->price;
                    break;
                    case '11':
                         $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                            $onceAm+=$busarPrecio->price;
                                                break;
                    case '12':
                         $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                        $docePm+=$busarPrecio->price;
                        break;
                        case '13':
                             $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                            $unaPm+=$busarPrecio->price;
                            break;
                        case '14':
                             $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                            $dosPm+=$busarPrecio->price;
                            break;
                            case '15':
                                 $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                                $tresPm+=$busarPrecio->price;
                                break;
                            case '16':
                                 $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                                $cuatroPm+=$busarPrecio->price;
                                break;
                                case '17':
                                     $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                                    $cincoPm+=$busarPrecio->price;
                                    break;
                                case '18':
                                     $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                                    $seisPm+=$busarPrecio->price;
                                    break;
                                    case '19':
                                         $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                                        $sietePm+=$busarPrecio->price;
                                        break;
                                        case '20':
                                            $busarPrecio=DB::table('precios')->select('price')->where('pn',$rowstime->pn)->first();
                                           $sietePm+=$busarPrecio->price;
                                           break;

            }
    }
    $plan=$cort=$libe=$ensa=$cali=$espc=$loom=0;
    $buscarWoCount=DB::table("registro")->select('count')->where('count','<',20)->get();
    foreach($buscarWoCount as $rowReg){
        switch($rowReg->count){
            case '1':
                $plan++;
                break;
             case '2':
                $cort++;
                break;
             case '3':
                $cort++;
                break;
                case '4':
                    $libe++;
                    break;
                 case '5':
                    $libe++;
                    break;
                    case '6':
                        $ensa++;
                        break;
                     case '7':
                        $ensa++;
                        break;
                        case '15':
                            $espc++;
                            break;
                            case '8':
                                $loom++;
                                break;
                             case '9':
                                $loom++;
                                break;
                                case '10':
                                    $cali++;
                                    break;
                                 case '11':
                                    $cali++;
                                    break;


             }
    }
    $dato=[$plan,$cort,$libe,$ensa,$espc,$loom,$cali];
    $label=['Plannig','Cutting','Terminals','Assembly','Special Wire','Looming','Quality'];
    $labels=['07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15::00','16:00','17:00','18:00','19:00'];

        $tiemposPass[0]=$tiemposPass[1]=$tiemposPass[2]=0;
    $datos=[$sieteAm,$ochoAm,$nueveAm,$diesAm,$onceAm,$docePm,$unaPm,$dosPm,$tresPm,$cuatroPm,$cincoPm,$seisPm,$sietePm];
    $saldo=$sieteAm+$ochoAm+$nueveAm+$diesAm+$onceAm+$docePm+$unaPm+$dosPm+$tresPm+$cuatroPm+$cincoPm+$seisPm+$sietePm;
    $buscarPassView=DB::table('registro')->select('*')->get();
    foreach($buscarPassView as $rowPass){
        $fecha=strtotime(date("d-m-Y"));
        $entrega=strtotime($rowPass->reqday);
        $fecha7 = strtotime('+7 days');
        if($fecha>$entrega){
            $tiemposPass[0]+=1;
        }
        else if($fecha<=$entrega and $fecha7>=$entrega){
            $tiemposPass[1]+=1;
        }else if($fecha7<$entrega){
            $tiemposPass[2]+=1;
        }
    }


return view('juntas')->with(['ventasStation'=>$ventasStation,'inform'=>$inform,'value' => $value,'countReq'=>$countReq,'cat'=>$cat,'client'=>$client,
        'tableContent' => $tableContent,
        'saldo'=> $saldo,
        'backlock'=> $backlock,
        'labels'=>$labels,
        'data'=>$datos,
        'label'=>$label,
        'dato'=>$dato,
        'tiemposPass'=>$tiemposPass]);
}


}

public function calidad_junta(){
    $value=session('user');
    $cat=session('categoria');

        $datos = $etiq = [];
        $pareto[0]=$pareto[1]=0;
        $paretoresult[0]=$paretoresult[1]=0;
        if(date("N")==1){
            $datecontrol = strtotime(date("d-m-Y 00:00", strtotime("-3 days")));
        }else{
        $datecontrol = strtotime(date("d-m-Y 00:00", strtotime("-1 days")));
    }
        $buscarValoresMes = DB::table('regsitrocalidad')->get();
        foreach ($buscarValoresMes as $rows) {
            if (strtotime($rows->fecha) > $datecontrol) {
                if($rows->codigo!='TODO BIEN'){
                if (in_array($rows->codigo, $etiq)) {
                    $index = array_search($rows->codigo, $etiq);
                    $datos[$etiq[$index]] += $rows->resto;
                } else {
                    $etiq[] = $rows->codigo;
                    $index = count($etiq) - 1; // Index of the last added element
                    $datos[$etiq[$index]] = $rows->resto;
                     }
                }
            }
        }
        $buscarValorespareto=DB::table('regsitrocalidad')->get();
        foreach($buscarValorespareto as $rowPareto){
            if (strtotime($rowPareto->fecha) > $datecontrol) {
            if($rowPareto->codigo=='TODO BIEN'){
                $pareto[0]+=1;
            }else{
                $pareto[1]+=1;
            }
        }
        }
        $paretott=$pareto[1]+$pareto[0];
        if ($paretott != 0) {
            $paretoresult[0]=round(($pareto[0]*100)/$paretott,2);
            $paretoresult[1]=round(($pareto[1]*100)/$paretott,2);
        } else {
            $paretoresult[0]=0;
            $paretoresult[1]=0;
        }


       arsort($datos);

       $firstKey = key($datos);

       $i = 0;
       $datosF = [];

       // Query the database to retrieve records where 'codigo' column matches the $firstKey
       $buscardatosClientes = DB::table('regsitrocalidad')->where('codigo', $firstKey)->get();
       foreach ($buscardatosClientes as $rowDatos) {
           $fechaControl = strtotime($rowDatos->fecha);
           if ($fechaControl > $datecontrol) {
               if (in_array($rowDatos->client, array_column($datosF, 0))) {
                   $index = array_search($rowDatos->client, array_column($datosF, 0));
                   $datosF[$index][2] += $rowDatos->resto;
               } else {
                   $datosF[$i][0] = $rowDatos->client;
                   $datosF[$i][1] = $rowDatos->codigo;
                   $datosF[$i][2] = $rowDatos->resto;

                   $i++;
               }
           }
       }

       // Reset $i before the second loop
       $i = 0;
       $datosS = [];

       next($datos);
       $secondKey = key($datos);
       // Query the database to retrieve records where 'codigo' column matches the $secondKey
       $buscardatosClientes2 = DB::table('regsitrocalidad')->where('codigo', $secondKey)->get();
       foreach ($buscardatosClientes2 as $rowDatos2) {
           $fechaControl2 = strtotime($rowDatos2->fecha);
           if ($fechaControl2 > $datecontrol) {
               if (in_array($rowDatos2->client, array_column($datosS, 0))) {
                   $index = array_search($rowDatos2->client, array_column($datosS, 0));
                   $datosS[$index][2] += $rowDatos2->resto;
               } else {
                   $datosS[$i][0] = $rowDatos2->client;
                   $datosS[$i][1] = $rowDatos2->codigo;
                   $datosS[$i][2] = $rowDatos2->resto;

                   $i++;
               }
           }
       }

       // Reset $i before the third loop
       $i = 0;
       $datosT = [];

       next($datos);
       $thirdKey = key($datos);
       // Query the database to retrieve records where 'codigo' column matches the $thirdKey
       $buscardatosClientes3 = DB::table('regsitrocalidad')->where('codigo', $thirdKey)->get();
       foreach ($buscardatosClientes3 as $rowDatos3) {
           $fechaControl3 = strtotime($rowDatos3->fecha);
           if ($fechaControl3 > $datecontrol) {
               if (in_array($rowDatos3->client, array_column($datosT, 0))) {
                   $index = array_search($rowDatos3->client, array_column($datosT, 0));
                   $datosT[$index][2] += $rowDatos3->resto;
               } else {
                   $datosT[$i][0] = $rowDatos3->client;
                   $datosT[$i][1] = $rowDatos3->codigo;
                   $datosT[$i][2] = $rowDatos3->resto;

                   $i++;
               }
           }
       }

//quality Q
    $Qdays=$colorQ=$labelQ=[];
    $maxDays = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
    for($i=0;$i<$maxDays;$i++){
        $Qdays[$i]=1;
        $labelQ[$i]=$i+1;
            }
            $todayD=date('d');
        for($i=0;$i<$todayD;$i++)
            if($labelQ[$i]==32){
                $colorQ[$i]='red';
            }else{
                $colorQ[$i]='green';
            }

            ksort($datosT);
            ksort($datosS);
            ksort($datosF);

    $buscarCalidadRows=new caliController;
    $buscadorCal =$buscarCalidadRows->__invoke();
    $calidad=$buscadorCal->getData()['calidad'];
    $calidadControl=[];
    $j=0;
    $buscadorCal = DB::table('regsitrocalidad')->where('codigo','!=','TODO BIEN')->orderBy('id','DESC')->get();
    foreach ($buscadorCal as $rows) {
        $calidadControl[$j][0]=$rows->fecha;
        $calidadControl[$j][1]=$rows->client;
        $calidadControl[$j][2]=$rows->pn;
        $calidadControl[$j][3]=$rows->resto;
        $calidadControl[$j][4]=$rows->codigo;
        $j++;
    }

        return view('juntas/calidad',['calidadControl'=>$calidadControl,'calidad'=>$calidad,'datosT'=>$datosT,'datosS'=>$datosS,'datosF'=>$datosF,'labelQ'=>$labelQ,'colorQ'=>$colorQ,'value'=>$value,'cat'=>$cat,'datos'=>$datos,'pareto'=>$pareto,'paretoresult'=>$paretoresult,'Qdays'=>$Qdays]);

}

}

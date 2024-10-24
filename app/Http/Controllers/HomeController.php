<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __invoke()
    {
        $value = session('user');
        $cat = session('categoria');
if($value=='' or $cat==''){
    return view('login');
}else{
    $backlock=0;
        for($i=0;$i<13;$i++){
            $client[$i]=0;
        }
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
return view('admin',['value'=>$value,'cat'=>$cat,'client'=>$client]);
}
      }

    public function fetchData(){


        $backlock=$cal=0;

        $buscarregistros=DB::select("SELECT * FROM registro WHERE Qty>'0'");
        foreach($buscarregistros as $reg){
            $price=$reg->price;
            $cant=$reg->Qty;
            $backlock+=($price*$cant);
        }

    $today = strtotime(date("d-m-Y 00:00"));
    $count = $preciot = $saldo = 0;
    $fecha = $info = $cliente = $pn = $cantidad = [];
    $tested = DB::select('SELECT * FROM regsitrocalidad ORDER BY id DESC'  );

    foreach ($tested as $registro) {
        $date = $registro->fecha;
        $code = $registro->info;
        $client = $registro->client;
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
                $cliente[] = $client;
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
    $diario=date("d-m-Y");
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



    // Create the updated data array
    $updatedData = [
        'tableContent' => $tableContent,
        'saldo'=> $saldo,
        'backlock'=> $backlock,
        'labels'=>$labels,
        'data'=>$datos,
        'label'=>$label,
        'dato'=>$dato,
        'tiemposPass'=>$tiemposPass,
        


    ];

    // Return the updated data as JSON response
    return response()->json($updatedData,);
}





}

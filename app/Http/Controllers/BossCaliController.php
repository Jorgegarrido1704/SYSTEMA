<?php

namespace App\Http\Controllers;
use App\Http\Controllers\caliController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BossCaliController extends Controller
{
    public function __invoke(){
        $value=session('user');
    $cat=session('categoria');

        $datos = $etiq = [];
        $pareto[0]=$pareto[1]=0;
        $paretoresult[0]=$paretoresult[1]=0;
        $monthAndYear = date("m-Y");
        $today=date('d-m-Y 23:59');

        $datecontrol = strtotime(date("d-m-Y 00:00"));
        $buscarValoresMes = DB::table('regsitrocalidad')->get();
        foreach ($buscarValoresMes as $rows) {
            if ((strtotime($rows->fecha) > $datecontrol) AND (strtotime($rows->fecha) < strtotime($today))) {
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
            if ((strtotime($rowPareto->fecha) > $datecontrol)AND (strtotime($rowPareto->fecha) < strtotime($today))) {
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
           if (($fechaControl > $datecontrol)AND ($fechaControl < strtotime($today))) {
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
           if (($fechaControl2 > $datecontrol) AND ($fechaControl2 < strtotime($today))) {
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
           if (($fechaControl3 > $datecontrol) AND ($fechaControl3 < strtotime($today))) {
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
    $buscadorCal = DB::table('regsitrocalidad')
    ->where('codigo','!=','TODO BIEN')
    ->where('fecha','LIKE',date('d-m-Y').'%')
    ->orderBy('id','DESC')->get();
    foreach ($buscadorCal as $rows) {
        $calidadControl[$j][0]=$rows->fecha;
        $calidadControl[$j][1]=$rows->client;
        $calidadControl[$j][2]=$rows->pn;
        $calidadControl[$j][3]=$rows->resto;
        $calidadControl[$j][4]=$rows->codigo;
        $j++;
    }

        return view('BossCali',['calidadControl'=>$calidadControl,'calidad'=>$calidad,'datosT'=>$datosT,'datosS'=>$datosS,'datosF'=>$datosF,'labelQ'=>$labelQ,'colorQ'=>$colorQ,'value'=>$value,'cat'=>$cat,'datos'=>$datos,'pareto'=>$pareto,'paretoresult'=>$paretoresult,'Qdays'=>$Qdays]);




    }
   /* public function reference(Request $request){
        $days=$request->input('date');
        $value=session('user');
        $cat=session('categoria');
        if($cat==""){
            return redirect('login');
        }else{
            $datos = $etiq = [];
            $pareto[0]=$pareto[1]=0;
            $paretoresult[0]=$paretoresult[1]=0;
            $monthAndYear = date("m-Y");
            $today=(date('d-m-Y'));
            $yesterday = date('d-m-Y', strtotime('-1 days'));
            $week=date('d-m-Y', strtotime('-7 days'));
            $con3=date('d-m-Y', strtotime('-2 days'));
            $con4=date('d-m-Y', strtotime('-3 days'));
            $con5=date('d-m-Y', strtotime('-4 days'));
            $con6=date('d-m-Y', strtotime('-5 days'));
            $con7=date('d-m-Y', strtotime('-6 days'));
            $todays=date('d-m-Y H:i');
            $datecontrol = strtotime(date("$today 00:00"));
            $yestContI=strtotime(date("$yesterday 00:00"));
            $yestContF=strtotime(date("$yesterday 23:59"));
            $weekcontrol=strtotime(date("$week 00:00"));
            $mothControl=strtotime(date("01-$monthAndYear 00:00"));

            if($days=="Today" or $days=='today'){$buscarValoresMes = DB::table('regsitrocalidad')->where('fecha','LIKE',$today.'%%')->get();
                foreach ($buscarValoresMes as $rows) {
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

            }}
            else if($days=="Yesterday" or $days=='yesterday'){$buscarValoresMes = DB::table('regsitrocalidad')->where('fecha','LIKE',$yesterday.'%%')->get();
                foreach ($buscarValoresMes as $rows) {
                    if($rows->codigo!='TODO BIEN'){
                    if (in_array($rows->codigo, $etiq)) {
                        $index = array_search($rows->codigo, $etiq);
                        $datos[$etiq[$index]] += $rows->resto;
                    } else {
                        $etiq[] = $rows->codigo;
                        $index = count($etiq) - 1; // Index of the last added element
                        $datos[$etiq[$index]] = $rows->resto;
                         }
                        }}}
            else if($days=="Week" or $days=='week'){$buscarValoresMes = DB::table('regsitrocalidad')->get();
            foreach ($buscarValoresMes as $rows) {
                if(strtotime($rows->fecha)>$weekcontrol){
                if($rows->codigo!='TODO BIEN'){
                if (in_array($rows->codigo, $etiq)) {
                    $index = array_search($rows->codigo, $etiq);
                    $datos[$etiq[$index]] += $rows->resto;
                } else {
                    $etiq[] = $rows->codigo;
                    $index = count($etiq) - 1; // Index of the last added element
                    $datos[$etiq[$index]] = $rows->resto;
                     }
                }}
        }}
            else if($days=="Month" or $days=='month'){$buscarValoresMes = DB::table('regsitrocalidad')->get();
                foreach ($buscarValoresMes as $rows) {
                    if(strtotime($rows->fecha)>$mothControl){
                    if($rows->codigo!='TODO BIEN'){
                    if (in_array($rows->codigo, $etiq)) {
                        $index = array_search($rows->codigo, $etiq);
                        $datos[$etiq[$index]] += $rows->resto;
                    } else {
                        $etiq[] = $rows->codigo;
                        $index = count($etiq) - 1; // Index of the last added element
                        $datos[$etiq[$index]] = $rows->resto;
                         }
                    }}

            }
            }


            if($days=="Today" or $days=='today'){$buscarValorespareto = DB::table('regsitrocalidad')->where('fecha','LIKE',$today.'%%')->get();
                foreach($buscarValorespareto as $rowPareto){
                    if($rowPareto->codigo=='TODO BIEN'){
                        $pareto[0]+=1;
                    }else{
                        $pareto[1]+=1;
                    }}
            }
            else if($days=="Yesterday" or $days=='yesterday'){$buscarValorespareto = DB::table('regsitrocalidad')->where('fecha','LIKE',$yesterday.'%%')->get();
                foreach($buscarValorespareto as $rowPareto){
                    if($rowPareto->codigo=='TODO BIEN'){
                        $pareto[0]+=1;
                    }else{
                        $pareto[1]+=1;
                    }}
            }
            else if($days=="Week" or $days=='week'){$buscarValorespareto = DB::table('regsitrocalidad')->get();
                foreach($buscarValorespareto as $rowPareto){
                    if(strtotime($rowPareto->fecha)>$weekcontrol){
                    if($rowPareto->codigo=='TODO BIEN'){
                        $pareto[0]+=1;
                    }else{
                        $pareto[1]+=1;
                    }}}
            }
            else if($days=="Month" or $days=='month'){$buscarValorespareto = DB::table('regsitrocalidad')->get();
                   foreach($buscarValorespareto as $rowPareto){
                    if(strtotime($rowPareto->fecha)>$mothControl){
                    if($rowPareto->codigo=='TODO BIEN'){
                        $pareto[0]+=1;
                    }else{
                        $pareto[1]+=1;
                    }}}
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

            if($days=="Today" or $days=='today'){
            $buscardatosClientes = DB::table('regsitrocalidad')->where('codigo', $firstKey)
            ->where('fecha','LIKE',$today.'%')->get();
            foreach ($buscardatosClientes as $rowDatos) {

                    if (in_array($rowDatos->client, array_column($datosF, 0))) {
                        $index = array_search($rowDatos->client, array_column($datosF, 0));
                        $datosF[$index][2] += $rowDatos->resto;
                    } else {
                        $datosF[$i][0] = $rowDatos->client;
                        $datosF[$i][1] = $rowDatos->codigo;
                        $datosF[$i][2] = $rowDatos->resto;
                        $datosF[$i][3] = $rowDatos->pn;
                        $i++;
                    }
            }

            // Reset $i before the second loop
            $i = 0;
            $datosS = [];

            next($datos);
            $secondKey = key($datos);
            // Query the database to retrieve records where 'codigo' column matches the $secondKey
            $buscardatosClientes2 = DB::table('regsitrocalidad')->where('codigo', $secondKey)
            ->where('fecha','LIKE',$today.'%')->get();
            foreach ($buscardatosClientes2 as $rowDatos2) {

                    if (in_array($rowDatos2->client, array_column($datosS, 0))) {
                        $index = array_search($rowDatos2->client, array_column($datosS, 0));
                        $datosS[$index][2] += $rowDatos2->resto;
                    } else {
                        $datosS[$i][0] = $rowDatos2->client;
                        $datosS[$i][1] = $rowDatos2->codigo;
                        $datosS[$i][2] = $rowDatos2->resto;
                        $datosS[$i][3] = $rowDatos2->pn;
                        $i++;
                    }
                }
            // Reset $i before the third loop
            $i = 0;
            $datosT = [];

            next($datos);
            $thirdKey = key($datos);
            // Query the database to retrieve records where 'codigo' column matches the $thirdKey
            $buscardatosClientes3 = DB::table('regsitrocalidad')->where('codigo', $thirdKey)
            ->where('fecha','LIKE',$today.'%')->get();
            foreach ($buscardatosClientes3 as $rowDatos3) {

                    if (in_array($rowDatos3->client, array_column($datosT, 0))) {
                        $index = array_search($rowDatos3->client, array_column($datosT, 0));
                        $datosT[$index][2] += $rowDatos3->resto;
                    } else {
                        $datosT[$i][0] = $rowDatos3->client;
                        $datosT[$i][1] = $rowDatos3->codigo;
                        $datosT[$i][2] = $rowDatos3->resto;
                        $datosT[$i][3] = $rowDatos3->pn;
                        $i++;
                    }        }
                }else if($days=="Yesterday" or $days=='yesterday'){
                $buscardatosClientes = DB::table('regsitrocalidad')->where('codigo', $firstKey)
                ->where('fecha','LIKE',$yesterday.'%')->get();
                foreach ($buscardatosClientes as $rowDatos) {

                        if (in_array($rowDatos->client, array_column($datosF, 0))) {
                            $index = array_search($rowDatos->client, array_column($datosF, 0));
                            $datosF[$index][2] += $rowDatos->resto;
                        } else {
                            $datosF[$i][0] = $rowDatos->client;
                            $datosF[$i][1] = $rowDatos->codigo;
                            $datosF[$i][2] = $rowDatos->resto;
                            $datosF[$i][3] = $rowDatos->pn;
                            $i++;
                        }
                }

                // Reset $i before the second loop
                $i = 0;
                $datosS = [];

                next($datos);
                $secondKey = key($datos);
                // Query the database to retrieve records where 'codigo' column matches the $secondKey
                $buscardatosClientes2 = DB::table('regsitrocalidad')->where('codigo', $secondKey)
                ->where('fecha','LIKE',$yesterday.'%')->get();
                foreach ($buscardatosClientes2 as $rowDatos2) {

                        if (in_array($rowDatos2->client, array_column($datosS, 0))) {
                            $index = array_search($rowDatos2->client, array_column($datosS, 0));
                            $datosS[$index][2] += $rowDatos2->resto;
                        } else {
                            $datosS[$i][0] = $rowDatos2->client;
                            $datosS[$i][1] = $rowDatos2->codigo;
                            $datosS[$i][2] = $rowDatos2->resto;
                            $datosS[$i][3] = $rowDatos2->pn;
                            $i++;
                        }
                    }
                // Reset $i before the third loop
                $i = 0;
                $datosT = [];

                next($datos);
                $thirdKey = key($datos);
                // Query the database to retrieve records where 'codigo' column matches the $thirdKey
                $buscardatosClientes3 = DB::table('regsitrocalidad')->where('codigo', $thirdKey)
                ->where('fecha','LIKE',$yesterday.'%')->get();
                foreach ($buscardatosClientes3 as $rowDatos3) {

                        if (in_array($rowDatos3->client, array_column($datosT, 0))) {
                            $index = array_search($rowDatos3->client, array_column($datosT, 0));
                            $datosT[$index][2] += $rowDatos3->resto;
                        } else {
                            $datosT[$i][0] = $rowDatos3->client;
                            $datosT[$i][1] = $rowDatos3->codigo;
                            $datosT[$i][2] = $rowDatos3->resto;
                            $datosT[$i][3] = $rowDatos3->pn;
                            $i++;
                        }        }
                    }else if($days=='Week' or $days=='week'){
                    $buscardatosClientes = DB::table('regsitrocalidad')->where('codigo', $firstKey)->get();
                    foreach ($buscardatosClientes as $rowDatos) {
                        if(strtotime($rowDatos->fecha)>$weekcontrol ){
                            if (in_array($rowDatos->client, array_column($datosF, 0))) {
                                $index = array_search($rowDatos->client, array_column($datosF, 0));
                                $datosF[$index][2] += $rowDatos->resto;
                            } else {
                                $datosF[$i][0] = $rowDatos->client;
                                $datosF[$i][1] = $rowDatos->codigo;
                                $datosF[$i][2] = $rowDatos->resto;
                                $datosF[$i][3] = $rowDatos->pn;
                                $i++;
                            }
                    }}

                    // Reset $i before the second loop
                    $i = 0;
                    $datosS = [];

                    next($datos);
                    $secondKey = key($datos);
                    // Query the database to retrieve records where 'codigo' column matches the $secondKey
                    $buscardatosClientes2 = DB::table('regsitrocalidad')->where('codigo', $secondKey)->get();
                    foreach ($buscardatosClientes2 as $rowDatos2) {
                        if(strtotime($rowDatos2->fecha)>$weekcontrol ){
                            if (in_array($rowDatos2->client, array_column($datosS, 0))) {
                                $index = array_search($rowDatos2->client, array_column($datosS, 0));
                                $datosS[$index][2] += $rowDatos2->resto;
                            } else {
                                $datosS[$i][0] = $rowDatos2->client;
                                $datosS[$i][1] = $rowDatos2->codigo;
                                $datosS[$i][2] = $rowDatos2->resto;
                                $datosS[$i][3] = $rowDatos2->pn;
                                $i++;
                            }
                        }}
                    // Reset $i before the third loop
                    $i = 0;
                    $datosT = [];

                    next($datos);
                    $thirdKey = key($datos);
                    // Query the database to retrieve records where 'codigo' column matches the $thirdKey
                    $buscardatosClientes3 = DB::table('regsitrocalidad')->where('codigo', $thirdKey)->get();
                    foreach ($buscardatosClientes3 as $rowDatos3) {
                        if(strtotime($rowDatos3->fecha)>$weekcontrol ){
                            if (in_array($rowDatos3->client, array_column($datosT, 0))) {
                                $index = array_search($rowDatos3->client, array_column($datosT, 0));
                                $datosT[$index][2] += $rowDatos3->resto;
                            } else {
                                $datosT[$i][0] = $rowDatos3->client;
                                $datosT[$i][1] = $rowDatos3->codigo;
                                $datosT[$i][2] = $rowDatos3->resto;
                                $datosT[$i][3] = $rowDatos3->pn;
                                $i++;
                            }    }    }
                        }else if($days=='Month' or $days=='month'){
                            $buscardatosClientes = DB::table('regsitrocalidad')->where('codigo', $firstKey)
                        ->where('fecha','LIKE','%'.$monthAndYear.'%')->get();
                        foreach ($buscardatosClientes as $rowDatos) {

                                if (in_array($rowDatos->client, array_column($datosF, 0))) {
                                    $index = array_search($rowDatos->client, array_column($datosF, 0));
                                    $datosF[$index][2] += $rowDatos->resto;
                                } else {
                                    $datosF[$i][0] = $rowDatos->client;
                                    $datosF[$i][1] = $rowDatos->codigo;
                                    $datosF[$i][2] = $rowDatos->resto;
                                    $datosF[$i][3] = $rowDatos->pn;
                                    $i++;
                                }
                        }

                        // Reset $i before the second loop
                        $i = 0;
                        $datosS = [];

                        next($datos);
                        $secondKey = key($datos);
                        // Query the database to retrieve records where 'codigo' column matches the $secondKey
                        $buscardatosClientes2 = DB::table('regsitrocalidad')->where('codigo', $secondKey)
                        ->where('fecha','LIKE','%'.$monthAndYear.'%')->get();
                        foreach ($buscardatosClientes2 as $rowDatos2) {

                                if (in_array($rowDatos2->client, array_column($datosS, 0))) {
                                    $index = array_search($rowDatos2->client, array_column($datosS, 0));
                                    $datosS[$index][2] += $rowDatos2->resto;
                                } else {
                                    $datosS[$i][0] = $rowDatos2->client;
                                    $datosS[$i][1] = $rowDatos2->codigo;
                                    $datosS[$i][2] = $rowDatos2->resto;
                                    $datosS[$i][3] = $rowDatos2->pn;
                                    $i++;
                                }
                            }
                        // Reset $i before the third loop
                        $i = 0;
                        $datosT = [];

                        next($datos);
                        $thirdKey = key($datos);
                        // Query the database to retrieve records where 'codigo' column matches the $thirdKey
                        $buscardatosClientes3 = DB::table('regsitrocalidad')->where('codigo', $thirdKey)
                        ->where('fecha','LIKE','%'.$monthAndYear.'%')->get();
                        foreach ($buscardatosClientes3 as $rowDatos3) {

                                if (in_array($rowDatos3->client, array_column($datosT, 0))) {
                                    $index = array_search($rowDatos3->client, array_column($datosT, 0));
                                    $datosT[$index][2] += $rowDatos3->resto;
                                } else {
                                    $datosT[$i][0] = $rowDatos3->client;
                                    $datosT[$i][1] = $rowDatos3->codigo;
                                    $datosT[$i][2] = $rowDatos3->resto;
                                    $datosT[$i][3] = $rowDatos2->pn;
                                    $i++;
                                }        }
                            }
$j=0;
$calidadControl=[];
if ($days=='Today' or $days=='today') {
    $buscadorCal = DB::table('regsitrocalidad')->where('fecha','LIKE', $today.'%')->where('codigo','!=','TODO BIEN')->orderBy('id','DESC')->get();
    foreach ($buscadorCal as $rows) {
        $calidadControl[$j][0]=$rows->fecha;
        $calidadControl[$j][1]=$rows->client;
        $calidadControl[$j][2]=$rows->pn;
        $calidadControl[$j][3]=$rows->resto;
        $calidadControl[$j][4]=$rows->codigo;
        $j++;
    }
}else if ($days=='Yesterday' or $days=='yesterday') {
    $buscadorCal = DB::table('regsitrocalidad')->where('fecha','LIKE', $yesterday.'%')->where('codigo','!=','TODO BIEN')->orderBy('id','DESC')->get();
    foreach ($buscadorCal as $rows) {
        $calidadControl[$j][0]=$rows->fecha;
        $calidadControl[$j][1]=$rows->client;
        $calidadControl[$j][2]=$rows->pn;
        $calidadControl[$j][3]=$rows->resto;
        $calidadControl[$j][4]=$rows->codigo;
        $j++;
    }
}else if ($days=='Week' or $days=='week') {
    $buscadorCal = DB::table('regsitrocalidad')->where('codigo','!=','TODO BIEN')->orderBy('id','DESC')->get();
    foreach ($buscadorCal as $rows) {
        if(strtotime($rows->fecha)>$weekcontrol){
        $calidadControl[$j][0]=$rows->fecha;
        $calidadControl[$j][1]=$rows->client;
        $calidadControl[$j][2]=$rows->pn;
        $calidadControl[$j][3]=$rows->resto;
        $calidadControl[$j][4]=$rows->codigo;
        $j++;
    }
    }
    }else if ($days=='Month' or $days=='month') {
        $buscadorCal = DB::table('regsitrocalidad')->where('codigo','!=','TODO BIEN')->orderBy('id','DESC')->get();
        foreach ($buscadorCal as $rows) {
            if(strtotime($rows->fecha)>$mothControl){
            $calidadControl[$j][0]=$rows->fecha;
            $calidadControl[$j][1]=$rows->client;
            $calidadControl[$j][2]=$rows->pn;
            $calidadControl[$j][3]=$rows->resto;
            $calidadControl[$j][4]=$rows->codigo;
            $j++;
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

            return view('reference',['calidadControl'=>$calidadControl,'paretott'=>$paretott,'days'=>$days,'calidad'=>$calidad,'datosT'=>$datosT,'datosS'=>$datosS,'datosF'=>$datosF,'labelQ'=>$labelQ,'colorQ'=>$colorQ,'value'=>$value,'cat'=>$cat,'datos'=>$datos,'pareto'=>$pareto,'paretoresult'=>$paretoresult,'Qdays'=>$Qdays]);
        }

    }
*/
}

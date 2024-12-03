<?php

namespace App\Http\Controllers;
use App\Http\Controllers\caliController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Http\Controllers\juntasController;

class BossCaliController extends Controller
{
    public function __invoke(){
                $value=session('user');
        $cat=session('categoria');
        if($cat!='BCali'){
            return view('login');
        }else{
            $value=session('user');
            $cat=session('categoria');

                $datos = $etiq = [];

                $monthAndYear = date("m-Y");
                $today=date('d-m-Y 00:00');
                if(date("N")==1){
                    $datecontrol = strtotime(date("d-m-Y 00:00", strtotime("-3 days")));

                }else{
                $datecontrol = strtotime(date("d-m-Y 00:00", strtotime("-1 days")));
            }
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

                $regvg=$regvb=$regjg=$regjb=$regmg=$regmb=$regmtg=$regmtb=$reglg=$reglb=0;
                $pareto=[];
                $datosv = (date("d-m-Y", strtotime("-3 days")));
                $datosj = (date("d-m-Y", strtotime("-4 days")));
                $datosm = (date("d-m-Y", strtotime("-5 days")));
                $datosmt = (date("d-m-Y", strtotime("-6 days")));
                $datosl = (date("d-m-Y", strtotime("-7 days")));

                    $buscarValorespareto=DB::table('regsitrocalidad')
                    ->where('fecha', 'LIKE', "$datosv%")
                    ->orWhere('fecha', 'LIKE', "$datosj%")
                    ->orWhere('fecha', 'LIKE', "$datosm%")
                    ->orWhere('fecha', 'LIKE', "$datosmt%")
                    ->orWhere('fecha', 'LIKE', "$datosl%")
                    ->get();
                    foreach($buscarValorespareto as $rowPareto){
                        if (substr($rowPareto->fecha, 0, 10) == $datosv) {  if($rowPareto->codigo=='TODO BIEN'){ $regvg+=1; }else{$regvb+=1;}  }
                        if (substr($rowPareto->fecha, 0, 10) == $datosj) {  if($rowPareto->codigo=='TODO BIEN'){ $regjg+=1; }else{$regjb+=1;}  }
                        if (substr($rowPareto->fecha, 0, 10) == $datosm) {  if($rowPareto->codigo=='TODO BIEN'){ $regmg+=1; }else{$regmb+=1;}  }
                        if (substr($rowPareto->fecha, 0, 10) == $datosmt) {  if($rowPareto->codigo=='TODO BIEN'){ $regmtg+=1; }else{$regmtb+=1;}  }
                        if (substr($rowPareto->fecha, 0, 10) == $datosl) {  if($rowPareto->codigo=='TODO BIEN'){ $reglg+=1; }else{$reglb+=1;}  }

                    }
                    if(date("N")==1){
                        try{

                    $paretott=$regvg+$regvb;
                    $pareto[$datosv]=round($regvg/$paretott,2*100);
                    $paretott=$regjg+$regjb;
                    $pareto[$datosj]=round($regjg/$paretott,2*100);
                    $paretott=$regmg+$regmb;
                    $pareto[$datosm]=round($regmg/$paretott,2*100);
                    $paretott=$regmtg+$regmtb;
                    $pareto[$datosmt]=round($regmtg/$paretott,2*100);
                    $paretott=$reglg+$reglb;
                    $pareto[$datosl]=round($reglg/$paretott,2*100);
                    }catch(Exception $e){
                        $pareto[$datosv]=$pareto[$datosj]=$pareto[$datosm]=$pareto[$datosmt]=$pareto[$datosl]=0;
                    }
                }else if(date("N")==2){
                    try{
                    $paretott=$reglg+$reglb;
                    $pareto[$datosl]=round($reglg/$paretott,2)*100;
                    }catch(Exception $e){
                        $pareto[$datosl]=0;
                    }
                }elseif(date("N")==3){
                    try{
                    $paretott=$regmtg+$regmtb;
                    $pareto[$datosmt]=round($regmtg/$paretott*100,2);
                    $paretott=$reglg+$reglb;
                    $pareto[$datosl]=round($reglg/$paretott*100,2);
                    }catch(Exception $e){
                        $pareto[$datosmt]=$pareto[$datosl]=0;
                    }
                }elseif(date("N")==4){
                    try{
                        $paretott=$regmg+$regmb;
                        $pareto[$datosm]=round($regmg/$paretott*100,2);
                        $paretott=$regmtg+$regmtb;
                        $pareto[$datosmt]=round($regmtg/$paretott*100,2);
                        $paretott=$reglg+$reglb;
                        $pareto[$datosl]=round($reglg/$paretott*100,2);

                    }catch(Exception $e){
                        $pareto[$datosm]=$pareto[$datosmt]=$pareto[$datosl]=0;
                    }
                }elseif(date("N")==5){
                    try{
                        $paretott=$regjg+$regjb;
                        $pareto[$datosj]=round($regjg/$paretott*100,2);
                        $paretott=$regmg+$regmb;
                        $pareto[$datosm]=round($regmg/$paretott*100,2);
                        $paretott=$regmtg+$regmtb;
                        $pareto[$datosmt]=round($regmtg/$paretott*100,2);
                        $paretott=$reglg+$reglb;
                        $pareto[$datosl]=round($reglg/$paretott*100,2);
                    }catch(Exception $e){
                       $pareto[$datosj]=$pareto[$datosm]=$pareto[$datosmt]=$pareto[$datosl]=0;
                    }
                }
                $monthAndYearPareto = [];
                $yearGood=$yearBad=$monthGood=$monthBad=0;
                $monthAndYear=date("m-Y");
                $YearParto=date("Y");
                $buscarValorPareto=DB::table('regsitrocalidad')
                ->where('fecha', 'LIKE', "%$YearParto%")
                ->get();
                foreach($buscarValorPareto as $rowPareto){
                 if($rowPareto->codigo=='TODO BIEN'){$yearGood+=1;}else{$yearBad+=1;}
                    if(substr($rowPareto->fecha, 3, 7) == $monthAndYear){
                        if($rowPareto->codigo=='TODO BIEN'){$monthGood+=1;}else{$monthBad+=1;}}
                    }
                    try{
                        if ($monthGood == 0) {
                            throw new Exception("Cannot divide by zero.");
                        }else{
                        $monthAndYearPareto[$monthAndYear]=round($monthGood/($monthGood+$monthBad)*100,2);
                        $monthAndYearPareto[$YearParto]=round($yearGood/($yearGood+$yearBad)*100,2);
                        }
                    }catch(Exception $e){
                        $monthAndYearPareto[$monthAndYear]=0;
                        $monthAndYearPareto[$YearParto]=0;
                    }


        arsort($monthAndYearPareto);
        arsort($pareto);


               arsort($datos);

               $firstKey = key($datos);

               $i = 0;
               $datosF = [];

               // Query the database to retrieve records where 'codigo' column matches the $firstKey
               $buscardatosClientes = DB::table('regsitrocalidad')->where('codigo', $firstKey)->get();
               foreach ($buscardatosClientes as $rowDatos) {
                   $fechaControl = strtotime($rowDatos->fecha);
                   if (($fechaControl > $datecontrol) AND ($fechaControl < strtotime($today))) {
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
                    if($labelQ[$i]==12){
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
            ->where('fecha','LIKE',date('d-m-Y', strtotime("-1 days")).'%')
            ->orderBy('id','DESC')->get();
            foreach ($buscadorCal as $rows) {
                $calidadControl[$j][0]=$rows->fecha;
                $calidadControl[$j][1]=$rows->client;
                $calidadControl[$j][2]=$rows->pn;
                $calidadControl[$j][3]=$rows->resto;
                $calidadControl[$j][4]=$rows->codigo;
                $j++;
            }




            return view('BossCali',['calidadControl'=>$calidadControl,
            'monthAndYearPareto'=>$monthAndYearPareto,
            'calidad'=>$calidad,'datosT'=>$datosT,'datosS'=>$datosS,'datosF'=>$datosF,'labelQ'=>$labelQ,
            'colorQ'=>$colorQ,'value'=>$value,'cat'=>$cat,'datos'=>$datos,'pareto'=>$pareto,'Qdays'=>$Qdays]);

    }
}

}

<?php

namespace App\Http\Controllers;
use App\Models\Maintanance;
use App\Models\material;
use App\Models\Paros;
use App\Models\calidadRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Mail\Mailables;
use Illuminate\Support\Facades\Mail;


class caliController extends generalController
{
    //
    public function __invoke(){
        $value = session('user');
        $cat = session('categoria');
        if($cat=='' or $value==''){
            return view('login');
        }else{
        $buscarcalidad=DB::select("SELECT * FROM calidad");
        $i=0;
        $calidad=[];
        foreach($buscarcalidad as $rowcalidad){
            $calidad[$i][0]=$rowcalidad->np;
            $calidad[$i][1]=$rowcalidad->client;
            $calidad[$i][2]=$rowcalidad->wo;
            $calidad[$i][3]=$rowcalidad->po;
            $calidad[$i][4]=$rowcalidad->qty;
            $calidad[$i][5]=$rowcalidad->parcial;
            $calidad[$i][6]=$rowcalidad->id;
            $calidad[$i][7]=$rowcalidad->info;
            $i++;

        }
        $timesReg = strtotime(date("d-m-Y 00:00", strtotime('-1 day')));
        $registros=[];
        $i=0;
        $buscReg=DB::table('regsitrocalidad')->get();
        foreach($buscReg as $rowReg){
            if(strtotime($rowReg->fecha)>$timesReg){
                $registros[$i][0]=$rowReg->fecha;
                $registros[$i][1]=$rowReg->client;
                $registros[$i][2]=$rowReg->pn;
                $registros[$i][3]=$rowReg->resto;
                $registros[$i][4]=$rowReg->codigo;
                $registros[$i][5]=$rowReg->prueba;
                $i++;
            }

        }


        $Generalcontroller=new generalController;
        $generalresult=$Generalcontroller->__invoke();
        $week=$generalresult->getData()['week'];
        $assit=$generalresult->getData()['assit'];
        $paros=$generalresult->getData()['paros'];
        $desviations=$generalresult->getData()['desviations'];
        $materials=$generalresult->getData()['materials'];




        return view('cali',['registros'=>$registros,'cat'=>$cat,'value'=>$value,'calidad'=>$calidad,'week'=>$week,'assit'=>$assit,'paros'=>$paros,'desviations'=>$desviations,'materials'=>$materials]);

        }
    }
        public function baja(Request $request){
        $calicontroller = new generalController();
        $caliresult = $calicontroller->__invoke();
        $value = $caliresult->getData()['value'];
        $week = $caliresult->getData()['week'];
        $assit = $caliresult->getData()['assit'];
        $cat=$caliresult->getData()['cat'];
        $id=$request->input('id');
        $buscarInfo=DB::select("SELECT * FROM calidad WHERE id='$id'");
        foreach($buscarInfo as $rowInfo){
            $client=$rowInfo->client;
            $pn=$rowInfo->np;
            $wo=$rowInfo->wo;
            $info=$rowInfo->info;
            $qty=$rowInfo->qty;
        }

        return view('cali',['value'=>$value,'id'=>$id,
                    'client'=>$client,
                    'pn'=>$pn,
                    'wo'=>$wo,
                    'qty'=>$qty,
                    'info'=>$info,
                    'week'=>$week,
                    'assit'=>$assit,
                    'cat'=>$cat
                ]);

    }
    public function saveData(Request $request){
        $value = session('user');
        $diff=0;
        $today=date('d-m-Y H:i');
        $info=$request->input("infoCal");
        $pn=$request->input("pn_cali");
        $client=$request->input("clienteErr");
        $ok=$request->input('ok');
        $nok=$request->input('nok');
        $cod1=$request->input('rest_code1');
        $cod2=$request->input('rest_code2');
        $cod3=$request->input('rest_code3');
        $cod4=$request->input('rest_code4');
        $cod5=$request->input('rest_code5');
        $cant1=$request->input('1');
        $cant2=$request->input('2');
        $cant3=$request->input('3');
        $cant4=$request->input('4');
        $cant5=$request->input('5');
        $serial=$request->input('serial');
        if(substr($serial,0,2)=='0-0'){
            $ini='0-0';
            $serial = str_replace('0-0', '', $serial);
            $serial = (int)$serial;

        }else if(substr($serial,0,1)=='0-') {
        $serial = str_replace('0-', '', $serial);
        $serial = (int)$serial;
        $ini='0-';}
        $busquedainfo=DB::table('calidad')->select('qty','wo')->where('info',$info)->first();

        $wo=$busquedainfo->wo;

        $qty_cal=$busquedainfo->qty;
        $total=$ok+$nok;
        $totalCant=$cant1+$cant2+$cant3+$cant4+$cant5;
        if($total<=$qty_cal and $totalCant==$nok){
            //insert ok
            for($i=0;$i<$ok;$i++){

            $ok_reg= new calidadRegistro;
            $ok_reg->fecha=$today;
            $ok_reg->client=$client;
            $ok_reg->pn=$pn;
            $ok_reg->info=$info;
            $ok_reg->resto=1;
            $ok_reg->codigo="TODO BIEN";
            if(!empty($serial)){
                $ok_reg->prueba=$serial;
                $serial++;
            }else{
            $ok_reg->prueba="";}
            $ok_reg->usuario=$value;
            $ok_reg->save();}



            if(!empty($cant1)){
                for($i=0;$i<$cant1;$i++){
                    $nok_reg= new calidadRegistro;
                    $nok_reg->fecha=$today;
                    $nok_reg->client=$client;
                    $nok_reg->pn=$pn;
                    $nok_reg->info=$info;
                    $nok_reg->resto=1;
                    $nok_reg->codigo=$cod1;
                    if(!empty($serial)){
                        $nok_reg->prueba=$serial;
                        $serial++;
                    }else{
                    $nok_reg->prueba="";}
                    $nok_reg->usuario=$value;
                    $nok_reg->save();
                }
            }
            if(!empty($cant2)){
                for($i=0;$i<$cant2;$i++){
                    $nok_reg= new calidadRegistro;
                    $nok_reg->fecha=$today;
                    $nok_reg->client=$client;
                    $nok_reg->pn=$pn;
                    $nok_reg->info=$info;
                    $nok_reg->resto=1;
                    $nok_reg->codigo=$cod2;
                    if(!empty($serial)){
                        $nok_reg->prueba="0-0".$serial;
                        $serial++;
                    }else{
                    $nok_reg->prueba="";}
                    $nok_reg->usuario=$value;
                    $nok_reg->save();
                }
            }
            if(!empty($cant3)){
                for($i=0;$i<$cant3;$i++){
                    $nok_reg= new calidadRegistro;
                    $nok_reg->fecha=$today;
                    $nok_reg->client=$client;
                    $nok_reg->pn=$pn;
                    $nok_reg->info=$info;
                    $nok_reg->resto=1;
                    $nok_reg->codigo=$cod3;
                    if(!empty($serial)){
                        $nok_reg->prueba="0-0".$serial;
                        $serial++;
                    }else{
                    $nok_reg->prueba="";}
                    $nok_reg->usuario=$value;
                    $nok_reg->save();
                }
            }
            if(!empty($cant4)){
                for($i=0;$i<$cant4;$i++){
                    $nok_reg= new calidadRegistro;
                    $nok_reg->fecha=$today;
                    $nok_reg->client=$client;
                    $nok_reg->pn=$pn;
                    $nok_reg->info=$info;
                    $nok_reg->resto=1;
                    $nok_reg->codigo=$cod4;
                    if(!empty($serial)){
                        $nok_reg->prueba="0-0".$serial;
                        $serial++;
                    }else{
                    $nok_reg->prueba="";}
                    $nok_reg->usuario=$value;
                    $nok_reg->save();
                }
            }
            if(!empty($cant5)){
                for($i=0;$i<$cant5;$i++){
                    $nok_reg= new calidadRegistro;
                    $nok_reg->fecha=$today;
                    $nok_reg->client=$client;
                    $nok_reg->pn=$pn;
                    $nok_reg->info=$info;
                    $nok_reg->resto=1;
                    $nok_reg->codigo=$cod5;
                    if(!empty($serial)){
                        $nok_reg->prueba=$serial;
                        $serial++;
                    }else{
                    $nok_reg->prueba="";}
                    $nok_reg->usuario=$value;
                    $nok_reg->save();
                }
            }

            $rest=$qty_cal - ($ok+$nok);
            $updacalidad=DB::table('calidad')->where("info",$info)->update(['qty'=>$rest]);
            $updateToRegistro=DB::table('registro')->where("info",$info)->update(["paro"=>"Parcial prueba electrica"]);
            if($rest==0){
                $todays=(date('d-m-Y H:i'));
                $delteCalidad=DB::table('calidad')->where("info",$info)->delete();
                $updatetime=DB::table('timesharn')->where('bar',$info)->update(['cutF'=>$todays]);
                $tiempoUp=DB::table('tiempos')->where('info',$info)->update(['corte'=>$todays]);
                $updateToEmbarque=DB::table('registro')->where("info",$info)->update(["count"=>12,"donde"=>'En espera de embarque',"paro"=>""]);
                $buscarReg=DB::table('registro')->where("info",$info)->first();
                $rev=$buscarReg->rev;
                $np=$buscarReg->NumPart;
                if(substr($rev,0,4)=='PPAP' || substr($rev,0,4)=='PRIM'){
                    $subject= 'Salida '.substr($rev, 0, 4).' Numero de parte:'.$np.' Rev: '.substr($rev, 5);
                                $date = date('d-m-Y');
                            $time = date('H:i');
                            $content = 'Buen día,'."\n\n".'Les comparto que hoy ' . $date . ' a las ' . $time . "\n\n"."Salio la".substr($rev, 0, 4)."\n\n";
                            $content .= "\n\n"." Del cliente: " . $client;
                    $content .= "\n\n"." Con número de parte: " . $np;
                    $content .= "\n\n"." Con Work order: " . $wo;
                    $content .= "\n\n"." Esto para seguir con el proceso de producción y revision por parte de ingeniería y calidad.";


                                $recipients = [
                                   'jcervera@mx.bergstrominc.com',
                                    'jcrodriguez@mx.bergstrominc.com',
                                    'vestrada@mx.bergstrominc.com',
                                    'david-villa88@outlook.com',
                                    'egaona@mx.bergstrominc.com',
                                    'mvaladez@mx.bergstrominc.com',
                                    'jolaes@mx.bergstrominc.com',
                                    'lramos@mx.bergstrominc.com',
                                    'emedina@mx.bergstrominc.com',
                                   'jgarrido@mx.bergstrominc.com',
                                   'jlopez@mx.bergstrominc.com'
                                ];
                                Mail::to($recipients)->send(new \App\Mail\PPAPING($subject,$content));}


            }

    }

    return redirect()->route('calidad');
    }

    public function buscarcodigo(Request $request)
{
    $codig1 = $request->input('codigo1');
    $codigo2 = $request->input('codigo2');
    $codig3 = $request->input('codigo3');
    $codigo4 = $request->input('codigo4');
    $codigo5 = $request->input('codigo5');

    $buscar = DB::table('clavecali')->select('defecto')->where('clave', $codig1)->first();
    if($buscar->defecto != null){

        $restCodig = $buscar ;
    }
    return response()->json($restCodig);



}
public function codigoCalidad(request $request){
    $codigo=$request->input('code-bar');

    $buscar=DB::select("SELECT count,donde FROM registro WHERE info='$codigo'");
    if (!$buscar) {
        return redirect('calidad')->with('response', 'Record not found');
    }
    foreach($buscar as $rowb){
    $count=$rowb->count;
    $area=$rowb->donde;
}
    $donde='';
    $sesion=session('user');
    $sesionBus = DB::table('login')->where('user', $sesion)->pluck('category')->first();
    $donde = $sesionBus;
                   if($donde=='cali' and $count=='10'){
                        $count++;
                        $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'Proceso de corte']);
                        if ($update) { $resp = "TTesting process";
                        } else {   $resp = "Harness not updated, it is in $area";  }
                        return redirect('calidad')->with('response', $resp);
                    } else if($donde=='cali' and $count=='11'){
                        $count++;
                        $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'En espera de embarque']);
                        if ($update) { $resp = "This harness was updated to the next station";
                        } else {   $resp = "Harness not updated, it is in $area";  }
                        return redirect('calidad')->with('response', $resp); }

                        return redirect('calidad')->with('response', "Record in $area");

}

public function fetchDatacali(){
$i =$backlock =0;
$fecha = $info = $cliente = $pn = $cantidad =$serial=$issue= [];
$tested = DB::select('SELECT * FROM regsitrocalidad ORDER BY id DESC');

foreach ($tested as $registro) {
    $date = $registro->fecha;
    $code = $registro->info;
    $client = $registro->client;
    $part = $registro->pn;
    $cant = $registro->resto;
    $issue=$registro->codigo;
    $serial=$registro->prueba;
    $dates=strtotime($date);

    $fechacontrol = strtotime("01-01-2024 00:00");


    if($dates>$fechacontrol){


            $fecha[] = $date;
            $cliente[] = $client;
            $pn[] = $part;
            $cantidad[] = $cant;
            $codigo[]=$issue;
            $prueba[]=$serial;
            $i++;
    }

    }
$tableContent = '';
for ($j = 0; $j < $i; $j++) {
    $tableContent .= '<tr>';
    $tableContent .= '<td>' . $fecha[$j] . '</td>';
    $tableContent .= '<td>' . $pn[$j] . '</td>';
    $tableContent .= '<td>' . $cliente[$j] . '</td>';
    $tableContent .= '<td>' . $cantidad[$j] . '</td>';
    $tableContent .= '<td>' . $codigo[$j] . '</td>';
    $tableContent .= '<td>' . $prueba[$j] . '</td>';
    $tableContent .= '</tr>';
}
$labels=['Planning','Cutting','Terminal'];
$datos=[12,13,14];

$saldo=0;


// Create the updated data array
$updatedData = [
    'tableContent' => $tableContent,
    'saldo'=> $saldo,
    'backlock'=> $backlock,
    'labels'=>$labels,
    'data'=>$datos

];

// Return the updated data as JSON response
return response()->json($updatedData,);
}

public function mantCali(Request $request){

        $value=session('user');
        $equip=$request->input('equipo');
        $NomEq=$request->input('nom_equipo');
        $dano=$request->input('dano');
        $area=$request->input('area');
        $today = date('d-m-Y H:i');
        $maint= new Maintanance;
        $maint->fill([
            'fecha'=>$today,
            'equipo'=>$equip,
            'nombreEquipo'=>$NomEq,
            'dano'=>$dano,
            'quien'=>$value,
            'area'=>$area,
            'atiende'=>'Nadie aun',
            'trabajo'=>'',
            'Tiempo'=>'',
            'inimant'=>'',
            'finhora'=>''
        ]);


        if ($maint->save()) {
            $hoy=date('d-m-Y');
        $hora=date('H:i');
        $Paro= new Paros;
        $Paro->fill([
            'fecha'=>$hoy,
            'hora'=>$hora,
            'equipo'=>$equip,
            'nombreEquipo'=>$NomEq,
            'dano'=>$dano,
            'quien'=>$value,
            'area'=>$area,
            'atiende'=>'Nadie aun',
            'trabajo'=>'',
            'Tiempo'=>'',
            'finhora'=>''
        ]);
        if ($Paro->save()) {
            return redirect('/calidad')->with('success', 'Data successfully saved.');
        } else {
            return redirect('/calidad')->with('error', 'Failed to save data.');
        }}

}
    public function matCali(Request $request){

            $value=session('user');
            $today=date("d-m-Y");

            for($i=0;$i<5;$i++){
                $cant[$i]=$request->input('cant'.$i);
                $articulo[$i]=$request->input('articulo'.$i);
                $notas[$i]=$request->input('notas_adicionales'.$i);
            }
            $i=0;
            $foliant=DB::select("SELECT folio FROM material ORDER BY id DESC LIMIT 1 ");
            $folio=$foliant[0]->folio;
            $folio+=1;
            while( $i<5){
                if($cant[$i]>0){
                $newarticulo=new material;
                $newarticulo->folio=$folio;
                $newarticulo->fecha=$today;
                $newarticulo->who=$value;
                $newarticulo->description=$articulo[$i];
                $newarticulo->note=$notas[$i];
                $newarticulo->qty=$cant[$i];
                $newarticulo->aprovadaComp="";
                $newarticulo->negada="";
                if(!empty($cant[$i])){
                $newarticulo->save();}
                }
                $i++;
            }

            return redirect('/calidad');

    }

    public function assiscali(Request $request){
            $names = $request->input('name');
            $dlu = $request->input('dlu');
            $dma = $request->input('dma');
            $dmi = $request->input('dmi');
            $dju = $request->input('dju');
            $dvi = $request->input('dvi');
            $dsa = $request->input('dsa');
            $ddo = $request->input('ddo');
            $dba = $request->input('dba');
            $dbp = $request->input('dbp');
            $dex = $request->input('dex');
            $id=$request->input('id');




            for ($i = 0; $i < count($names); $i++) {
                $name = $names[$i];
                $value_dlu = $dlu[$i];
                $value_dma = $dma[$i];
                $value_dmi = $dmi[$i];
                $value_dju = $dju[$i];
                $value_dvi = $dvi[$i];
                $value_dsa = $dsa[$i];
                $value_ddo = $ddo[$i];
                $value_dba = $dba[$i];
                $value_dbp = $dbp[$i];
                $value_dex = $dex[$i];

            $update=DB::table('assistence')->where('id','=',$id[$i])
                                            ->update(['lunes'=>$value_dlu,
                                            'martes'=>$value_dma,
                                            'miercoles'=>$value_dmi,
                                            'jueves'=>$value_dju,
                                            'viernes'=>$value_dvi,
                                            'sabado'=>$value_dsa,
                                            'domingo'=>$value_ddo ,
                                            'bonoAsistencia'=>$value_dba,'bonoPuntualidad'=>$value_dbp,'extras'=>$value_dex]);

            }
            return redirect('/calidad');


    }

    }


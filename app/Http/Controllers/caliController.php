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
use App\Models\timeDead;


class caliController extends generalController
{
      public function __invoke(){
        $value = session('user');
        $cat = session('categoria');

        $buscarcalidad=DB::table("calidad")->get();
        $i=0;
        $calidad=[];
        $fallas=[];
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
        $timesReg = strtotime(date("d-m-Y 00:00"))-86400;
        $registros=[];
        $i=0;
        $buscReg=DB::table('regsitrocalidad')->orderBy('id','DESC')->limit(250)->get();
        foreach($buscReg as $rowReg){
               $registros[$i][0]=$rowReg->fecha;
                $registros[$i][1]=$rowReg->client;
                $registros[$i][2]=$rowReg->pn;
                $registros[$i][3]=$rowReg->resto;
                $registros[$i][4]=$rowReg->codigo;
                $registros[$i][5]=$rowReg->prueba;
                $registros[$i][6]=$rowReg->Responsable;
                $i++;
        }
        $i=0;
        $buscFallas=DB::table('timedead')->where('area','Calidad')->where('timeFin','=','No Aun')->orderBy('id','DESC')->get();
        foreach($buscFallas as $Fa){
            $fallas[$i][0]=$Fa->id;
            $fallas[$i][1]=$Fa->fecha;
            $fallas[$i][2]=$Fa->cliente;
            $fallas[$i][3]=$Fa->np;
            $fallas[$i][4]=$Fa->codigo;
            $fallas[$i][5]=$Fa->defecto;
            $fallas[$i][6]=$Fa->respArea;
            $i++;
        }

        $Generalcontroller=new generalController;
        $generalresult=$Generalcontroller->__invoke();
        $week=$generalresult->getData()['week'];
        $assit=$generalresult->getData()['assit'];
        $paros=$generalresult->getData()['paros'];
        $desviations=$generalresult->getData()['desviations'];
        $materials=$generalresult->getData()['materials'];




        return view('cali',['fallas'=>$fallas,'registros'=>$registros,'cat'=>$cat,'value'=>$value,'calidad'=>$calidad,'week'=>$week,'assit'=>$assit,'paros'=>$paros,'desviations'=>$desviations,'materials'=>$materials]);


    }
        public function baja(Request $request){
        $calicontroller = new generalController();
        $caliresult = $calicontroller->__invoke();
        $value = $caliresult->getData()['value'];
        $week = $caliresult->getData()['week'];
        $assit = $caliresult->getData()['assit'];
        $cat=$caliresult->getData()['cat'];
        $id=$request->input('id');
        $buscarInfo=DB::table('calidad')->where('id','=',$id)->get();
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
        $corteLibe=['Impresion de cable incorrecta','Cable sobrante','Strip fuera de tolerancia','Terminal mal aplicada',
        'Crimp no centrado',
        'Cable con exceso de strip',
        'Cable con strip insuficiente',
        'Filamentos fuera de la terminal',
        'Filamentos trozados',
        'Aislante-InsulaciÃ³n perforada',
        'Pestanas del cobre agarrando forro',
        'Sello trozado',
        'Terminal con exceso de presiÃ³n',
        'Terminal doblada',
        'Terminal no abraza forro',
        'Terminal perforando forro',
        'Terminal quebrada',
        'Terminal sin presion',
        'Empalme Incorrecto',
        'Diodos invertidos',
        'Tubo termocontractil mal colocado',
        'Exceso de soldadura',
        'Soldadura puenteada',
        'Escasez de soldadura'
    ];
    $loom=['Encintado defectuoso de cables y-o de looming',
    'Looming Corrugado danado',
    'Looming Corrugado mal colocado ',
    'Braid mal colocado y-o danado',
    'Etiquetas invertidas'
    ];
    $ensa=['Cables revueltos en los lotes',
    'Medidas fuera de tolerancias',
    'Componente Danado',
    'Componente Incorrecto',
    'Componente Faltante',
    'Ensamble Incorrecto',
    'Terminal o conector mal asentado',
    'Salidas invertidas',
    'Componentes sin atar al arnes',
    'Cables Invertidos en el conector',
    ' no tiene Continuidad Electrica',
    'Arnes con cortocircuito'
    ];
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
        $responsable1=$request->input('responsable1');
        $responsable2=$request->input('responsable2');
        $responsable3=$request->input('responsable3');
        $responsable4=$request->input('responsable4');
        $responsable5=$request->input('responsable5');
        if(strpos($responsable1,',')){
            $responsable1=str_replace(',',';',$responsable1);
        }
        if(strpos($responsable1,',')){
            $responsable1=str_replace(',',';',$responsable1);
        }
        if(strpos($responsable2,',')){
            $responsable2=str_replace(',',';',$responsable2);
        }
        if(strpos($responsable3,',')){
            $responsable3=str_replace(',',';',$responsable3);
        }
        if(strpos($responsable4,',')){
            $responsable4=str_replace(',',';',$responsable4);
        }
        if(strpos($responsable5,',')){
            $responsable5=str_replace(',',';',$responsable5);
        }
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
        $buscarPartial=DB::table('registroparcial')->where('codeBar','=',$info)->get();
        foreach($buscarPartial as $row){
            $test=$row->testPar;
            $emba=$row->embPar;
        }
        $upPartial=DB::table('registroparcial')->where('codeBar','=',$info)->update(['testPar'=>$test-$total,'embPar'=>$emba+$total]);

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
                    $nok_reg->Responsable=$responsable1;
                    $nok_reg->save();
                    if(strpos($cod1, ';') ) {
                        $cod = explode(';', $cod1);
                        for ($i = 0; $i < count($cod); $i++) {
                            $regTimes= new timedead;
                    $regTimes->fecha=$today;
                    $regTimes->cliente=$client;
                    $regTimes->np=$pn;
                    $regTimes->codigo=$info;
                    $regTimes->defecto=$cod[$i];
                    $regTimes->timeIni=strtotime($today);
                    $regTimes->whoDet=$value;
                    if($cod[$i]=='Mantenimiento'){
                    $regTimes->respArea="Javier Cervantes";
                    }else if(in_array($cod[$i],$loom)){
                        $regTimes->respArea="Miguel Gonzalez";
                    }else if(in_array($cod[$i],$corteLibe)){
                        $regTimes->respArea="Angel Gonzalez";
                    }else if(in_array($cod[$i],$ensa)){
                        if($client=='BERGSTROM' OR $client=='KALMAR' OR $client=='MODINE'){
                            $regTimes->respArea="Alejandra Gaona";
                    }else if($client=='EL DORADO CALIFORNIA' OR $client=='BLUE BIRD'){
                        $regTimes->respArea="Saul Castro";
                    }else if($client=='COLLINS' OR $client=='SHYFT' or $client=='PHOENIX MOTOR CARS' or $client=='PROTERRA'or $client=='SPARTAN'){
                        $regTimes->respArea="Brando Olvera";
                    }else if ($client=='UTILIMASTER' OR $client=='ATLAS COPCO'){
                        $regTimes->respArea="Salvador Galvan";
                    }else if ($client=='TICO MANUFACTURING' ){
                        $regTimes->respArea="Jessi Sanchez";
                    }else{  $regTimes->respArea="";      }
                    }
            $regTimes->area="Calidad";
            $regTimes->save();

                        }
                    }
                        else{
                    $regTimes= new timedead;
                    $regTimes->fecha=$today;
                    $regTimes->cliente=$client;
                    $regTimes->np=$pn;
                    $regTimes->codigo=$info;
                    $regTimes->defecto=$cod1;
                    $regTimes->timeIni=strtotime($today);
                    $regTimes->whoDet=$value;
                    if($cod1=='Mantenimiento'){
                    $regTimes->respArea="Javier Cervantes";
                    }else if(in_array($cod1,$loom)){
                        $regTimes->respArea="Miguel Gonzalez";
                    }else if(in_array($cod1,$corteLibe)){
                        $regTimes->respArea="Angel Gonzalez";
                    }else if(in_array($cod1,$ensa)){
                        if($client=='BERGSTROM' OR $client=='KALMAR' OR $client=='MODINE'){
                            $regTimes->respArea="Alejandra Gaona";
                    }else if($client=='EL DORADO CALIFORNIA' OR $client=='BLUE BIRD'){
                        $regTimes->respArea="Saul Castro";
                    }else if($client=='COLLINS' OR $client=='SHYFT' or $client=='PHOENIX MOTOR CARS' or $client=='PROTERRA'or $client=='SPARTAN'){
                        $regTimes->respArea="Brando Olvera";
                    }else if ($client=='UTILIMASTER' OR $client=='ATLAS COPCO'){
                        $regTimes->respArea="Salvador Galvan";
                    }else if ($client=='TICO MANUFACTURING' ){
                        $regTimes->respArea="Jessi Sanchez";
                    }else{  $regTimes->respArea="";      }
                    }
            $regTimes->area="Calidad";
            $regTimes->save();}

        }
            if(!empty($cant2)){

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
                    $nok_reg->Responsable=$responsable2;
                    $nok_reg->save();

                if(strpos($cod2, ';') ) {
                    $cod = explode(';', $cod2);
                    for ($i = 0; $i < count($cod); $i++) {
                        $regTimes= new timedead;
                $regTimes->fecha=$today;
                $regTimes->cliente=$client;
                $regTimes->np=$pn;
                $regTimes->codigo=$info;
                $regTimes->defecto=$cod[$i];
                $regTimes->timeIni=strtotime($today);
                $regTimes->whoDet=$value;
                if($cod[$i]=='Mantenimiento'){
                $regTimes->respArea="Javier Cervantes";
                }else if(in_array($cod[$i],$loom)){
                    $regTimes->respArea="Miguel Gonzalez";
                }else if(in_array($cod[$i],$corteLibe)){
                    $regTimes->respArea="Angel Gonzalez";
                }else if(in_array($cod[$i],$ensa)){
                    if($client=='BERGSTROM' OR $client=='KALMAR' OR $client=='MODINE'){
                        $regTimes->respArea="Alejandra Gaona";
                }else if($client=='EL DORADO CALIFORNIA' OR $client=='BLUE BIRD'){
                    $regTimes->respArea="Saul Castro";
                }else if($client=='COLLINS' OR $client=='SHYFT' or $client=='PHOENIX MOTOR CARS' or $client=='PROTERRA'or $client=='SPARTAN'){
                    $regTimes->respArea="Brando Olvera";
                }else if ($client=='UTILIMASTER' OR $client=='ATLAS COPCO'){
                    $regTimes->respArea="Salvador Galvan";
                }else if ($client=='TICO MANUFACTURING' ){
                    $regTimes->respArea="Jessi Sanchez";
                }else{  $regTimes->respArea="";      }
                }
        $regTimes->area="Calidad";
        $regTimes->save();

                    }
                }
                    else{
                $regTimes= new timedead;
                $regTimes->fecha=$today;
                $regTimes->cliente=$client;
                $regTimes->np=$pn;
                $regTimes->codigo=$info;
                $regTimes->defecto=$cod2;
                $regTimes->timeIni=strtotime($today);
                $regTimes->whoDet=$value;
                if($cod2=='Mantenimiento'){
                $regTimes->respArea="Javier Cervantes";
                }else if(in_array($cod2,$loom)){
                    $regTimes->respArea="Miguel Gonzalez";
                }else if(in_array($cod2,$corteLibe)){
                    $regTimes->respArea="Angel Gonzalez";
                }else if(in_array($cod2,$ensa)){
                    if($client=='BERGSTROM' OR $client=='KALMAR' OR $client=='MODINE'){
                        $regTimes->respArea="Alejandra Gaona";
                }else if($client=='EL DORADO CALIFORNIA' OR $client=='BLUE BIRD'){
                    $regTimes->respArea="Saul Castro";
                }else if($client=='COLLINS' OR $client=='SHYFT' or $client=='PHOENIX MOTOR CARS' or $client=='PROTERRA'or $client=='SPARTAN'){
                    $regTimes->respArea="Brando Olvera";
                }else if ($client=='UTILIMASTER' OR $client=='ATLAS COPCO'){
                    $regTimes->respArea="Salvador Galvan";
                }else if ($client=='TICO MANUFACTURING' ){
                    $regTimes->respArea="Jessi Sanchez";
                }else{  $regTimes->respArea="";      }
                }
        $regTimes->area="Calidad";
        $regTimes->save();}
            }
            if(!empty($cant3)){

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
                $nok_reg->Responsable=$responsable3;
                $nok_reg->save();

            if(strpos($cod3, ';') ) {
                $cod = explode(';', $cod3);
                for ($i = 0; $i < count($cod); $i++) {
                    $regTimes= new timedead;
            $regTimes->fecha=$today;
            $regTimes->cliente=$client;
            $regTimes->np=$pn;
            $regTimes->codigo=$info;
            $regTimes->defecto=$cod[$i];
            $regTimes->timeIni=strtotime($today);
            $regTimes->whoDet=$value;
            if($cod[$i]=='Mantenimiento'){
            $regTimes->respArea="Javier Cervantes";
            }else if(in_array($cod[$i],$loom)){
                $regTimes->respArea="Miguel Gonzalez";
            }else if(in_array($cod[$i],$corteLibe)){
                $regTimes->respArea="Angel Gonzalez";
            }else if(in_array($cod[$i],$ensa)){
                if($client=='BERGSTROM' OR $client=='KALMAR' OR $client=='MODINE'){
                    $regTimes->respArea="Alejandra Gaona";
            }else if($client=='EL DORADO CALIFORNIA' OR $client=='BLUE BIRD'){
                $regTimes->respArea="Saul Castro";
            }else if($client=='COLLINS' OR $client=='SHYFT' or $client=='PHOENIX MOTOR CARS' or $client=='PROTERRA'or $client=='SPARTAN'){
                $regTimes->respArea="Brando Olvera";
            }else if ($client=='UTILIMASTER' OR $client=='ATLAS COPCO'){
                $regTimes->respArea="Salvador Galvan";
            }else if ($client=='TICO MANUFACTURING' ){
                $regTimes->respArea="Jessi Sanchez";
            }else{  $regTimes->respArea="";      }
            }
    $regTimes->area="Calidad";
    $regTimes->save();

                }
            }
                else{
            $regTimes= new timedead;
            $regTimes->fecha=$today;
            $regTimes->cliente=$client;
            $regTimes->np=$pn;
            $regTimes->codigo=$info;
            $regTimes->defecto=$cod3;
            $regTimes->timeIni=strtotime($today);
            $regTimes->whoDet=$value;
            if($cod3=='Mantenimiento'){
            $regTimes->respArea="Javier Cervantes";
            }else if(in_array($cod3,$loom)){
                $regTimes->respArea="Miguel Gonzalez";
            }else if(in_array($cod3,$corteLibe)){
                $regTimes->respArea="Angel Gonzalez";
            }else if(in_array($cod3,$ensa)){
                if($client=='BERGSTROM' OR $client=='KALMAR' OR $client=='MODINE'){
                    $regTimes->respArea="Alejandra Gaona";
            }else if($client=='EL DORADO CALIFORNIA' OR $client=='BLUE BIRD'){
                $regTimes->respArea="Saul Castro";
            }else if($client=='COLLINS' OR $client=='SHYFT' or $client=='PHOENIX MOTOR CARS' or $client=='PROTERRA'or $client=='SPARTAN'){
                $regTimes->respArea="Brando Olvera";
            }else if ($client=='UTILIMASTER' OR $client=='ATLAS COPCO'){
                $regTimes->respArea="Salvador Galvan";
            }else if ($client=='TICO MANUFACTURING' ){
                $regTimes->respArea="Jessi Sanchez";
            }else{  $regTimes->respArea="";      }
            }
    $regTimes->area="Calidad";
    $regTimes->save();}
        }
        if(!empty($cant4)){

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
            $nok_reg->Responsable=$responsable4;
            $nok_reg->save();

        if(strpos($cod4, ';') ) {
            $cod = explode(';', $cod4);
            for ($i = 0; $i < count($cod); $i++) {
                $regTimes= new timedead;
        $regTimes->fecha=$today;
        $regTimes->cliente=$client;
        $regTimes->np=$pn;
        $regTimes->codigo=$info;
        $regTimes->defecto=$cod[$i];
        $regTimes->timeIni=strtotime($today);
        $regTimes->whoDet=$value;
        if($cod[$i]=='Mantenimiento'){
        $regTimes->respArea="Javier Cervantes";
        }else if(in_array($cod[$i],$loom)){
            $regTimes->respArea="Miguel Gonzalez";
        }else if(in_array($cod[$i],$corteLibe)){
            $regTimes->respArea="Angel Gonzalez";
        }else if(in_array($cod[$i],$ensa)){
            if($client=='BERGSTROM' OR $client=='KALMAR' OR $client=='MODINE'){
                $regTimes->respArea="Alejandra Gaona";
        }else if($client=='EL DORADO CALIFORNIA' OR $client=='BLUE BIRD'){
            $regTimes->respArea="Saul Castro";
        }else if($client=='COLLINS' OR $client=='SHYFT' or $client=='PHOENIX MOTOR CARS' or $client=='PROTERRA'or $client=='SPARTAN'){
            $regTimes->respArea="Brando Olvera";
        }else if ($client=='UTILIMASTER' OR $client=='ATLAS COPCO'){
            $regTimes->respArea="Salvador Galvan";
        }else if ($client=='TICO MANUFACTURING' ){
            $regTimes->respArea="Jessi Sanchez";
        }else{  $regTimes->respArea="";      }
        }
$regTimes->area="Calidad";
$regTimes->save();

            }
        }
            else{
        $regTimes= new timedead;
        $regTimes->fecha=$today;
        $regTimes->cliente=$client;
        $regTimes->np=$pn;
        $regTimes->codigo=$info;
        $regTimes->defecto=$cod4;
        $regTimes->timeIni=strtotime($today);
        $regTimes->whoDet=$value;
        if($cod4=='Mantenimiento'){
        $regTimes->respArea="Javier Cervantes";
        }else if(in_array($cod4,$loom)){
            $regTimes->respArea="Miguel Gonzalez";
        }else if(in_array($cod4,$corteLibe)){
            $regTimes->respArea="Angel Gonzalez";
        }else if(in_array($cod4,$ensa)){
            if($client=='BERGSTROM' OR $client=='KALMAR' OR $client=='MODINE'){
                $regTimes->respArea="Alejandra Gaona";
        }else if($client=='EL DORADO CALIFORNIA' OR $client=='BLUE BIRD'){
            $regTimes->respArea="Saul Castro";
        }else if($client=='COLLINS' OR $client=='SHYFT' or $client=='PHOENIX MOTOR CARS' or $client=='PROTERRA'or $client=='SPARTAN'){
            $regTimes->respArea="Brando Olvera";
        }else if ($client=='UTILIMASTER' OR $client=='ATLAS COPCO'){
            $regTimes->respArea="Salvador Galvan";
        }else if ($client=='TICO MANUFACTURING' ){
            $regTimes->respArea="Jessi Sanchez";
        }else{  $regTimes->respArea="";      }
        }
$regTimes->area="Calidad";
$regTimes->save();}
    }
    if(!empty($cant5)){

        $nok_reg= new calidadRegistro;
        $nok_reg->fecha=$today;
        $nok_reg->client=$client;
        $nok_reg->pn=$pn;
        $nok_reg->info=$info;
        $nok_reg->resto=1;
        $nok_reg->codigo=$cod5;
        if(!empty($serial)){
            $nok_reg->prueba="0-0".$serial;
            $serial++;
        }else{
        $nok_reg->prueba="";}
        $nok_reg->usuario=$value;
        $nok_reg->Responsable=$responsable5;
        $nok_reg->save();

    if(strpos($cod5, ';') ) {
        $cod = explode(';', $cod5);
        for ($i = 0; $i < count($cod); $i++) {
            $regTimes= new timedead;
    $regTimes->fecha=$today;
    $regTimes->cliente=$client;
    $regTimes->np=$pn;
    $regTimes->codigo=$info;
    $regTimes->defecto=$cod[$i];
    $regTimes->timeIni=strtotime($today);
    $regTimes->whoDet=$value;
    if($cod[$i]=='Mantenimiento'){
    $regTimes->respArea="Javier Cervantes";
    }else if(in_array($cod[$i],$loom)){
        $regTimes->respArea="Miguel Gonzalez";
    }else if(in_array($cod[$i],$corteLibe)){
        $regTimes->respArea="Angel Gonzalez";
    }else if(in_array($cod[$i],$ensa)){
        if($client=='BERGSTROM' OR $client=='KALMAR' OR $client=='MODINE'){
            $regTimes->respArea="Alejandra Gaona";
    }else if($client=='EL DORADO CALIFORNIA' OR $client=='BLUE BIRD'){
        $regTimes->respArea="Saul Castro";
    }else if($client=='COLLINS' OR $client=='SHYFT' or $client=='PHOENIX MOTOR CARS' or $client=='PROTERRA'or $client=='SPARTAN'){
        $regTimes->respArea="Brando Olvera";
    }else if ($client=='UTILIMASTER' OR $client=='ATLAS COPCO'){
        $regTimes->respArea="Salvador Galvan";
    }else if ($client=='TICO MANUFACTURING' ){
        $regTimes->respArea="Jessi Sanchez";
    }else{  $regTimes->respArea="";      }
    }
$regTimes->area="Calidad";
$regTimes->save();

        }
    }
        else{
    $regTimes= new timedead;
    $regTimes->fecha=$today;
    $regTimes->cliente=$client;
    $regTimes->np=$pn;
    $regTimes->codigo=$info;
    $regTimes->defecto=$cod5;
    $regTimes->timeIni=strtotime($today);
    $regTimes->whoDet=$value;
    if($cod5=='Mantenimiento'){
    $regTimes->respArea="Javier Cervantes";
    }else if(in_array($cod5,$loom)){
        $regTimes->respArea="Miguel Gonzalez";
    }else if(in_array($cod5,$corteLibe)){
        $regTimes->respArea="Angel Gonzalez";
    }else if(in_array($cod5,$ensa)){
        if($client=='BERGSTROM' OR $client=='KALMAR' OR $client=='MODINE'){
            $regTimes->respArea="Alejandra Gaona";
    }else if($client=='EL DORADO CALIFORNIA' OR $client=='BLUE BIRD'){
        $regTimes->respArea="Saul Castro";
    }else if($client=='COLLINS' OR $client=='SHYFT' or $client=='PHOENIX MOTOR CARS' or $client=='PROTERRA'or $client=='SPARTAN'){
        $regTimes->respArea="Brando Olvera";
    }else if ($client=='UTILIMASTER' OR $client=='ATLAS COPCO'){
        $regTimes->respArea="Salvador Galvan";
    }else if ($client=='TICO MANUFACTURING' ){
        $regTimes->respArea="Jessi Sanchez";
    }else{  $regTimes->respArea="";      }
    }
$regTimes->area="Calidad";
$regTimes->save();}
}

            $rest=$qty_cal - ($ok+$nok);

            if($rest>0){
            $updacalidad=DB::table('calidad')->where("info",$info)->update(['qty'=>$rest]);
            $updateToRegistro=DB::table('registro')->where("info",$info)->update(["paro"=>"Parcial prueba electrica"]);
            return redirect()->route('calidad');
            }else if($rest<=0){
                $todays=(date('d-m-Y H:i'));
                $buscarReg=DB::table('registro')->where("info",$info)->first();
                $rev=$buscarReg->rev;
                $np=$buscarReg->NumPart;
                if(substr($rev,0,4)=='PPAP' || substr($rev,0,4)=='PRIM'){
                    $delteCalidad=DB::table('calidad')->where("info",$info)->delete();
                    $updatetime=DB::table('timesharn')->where('bar',$info)->update(['qlyF'=>$todays]);
                    $tiempoUp=DB::table('tiempos')->where('info',$info)->update(['calidad'=>$todays]);
                    $updateToEmbarque=DB::table('registro')->where("info",$info)->update(["count"=>18,"donde"=>'En espera de ingenieria',"paro"=>""]);
                                return redirect()->route('calidad');
            }else{
                $delteCalidad=DB::table('calidad')->where("info",$info)->delete();
                $updatetime=DB::table('timesharn')->where('bar',$info)->update(['cutF'=>$todays]);
                $tiempoUp=DB::table('tiempos')->where('info',$info)->update(['calidad'=>$todays]);
                $updateToEmbarque=DB::table('registro')->where("info",$info)->update(["count"=>12,"donde"=>'En espera de embarque',"paro"=>""]);
                return redirect()->route('calidad');
            }
            }
        }else{
            return redirect()->route('calidad');
        }



    }

    public function buscarcodigo(Request $request)
{
    $codig1 = $request->input('codigo1');
    $cod1=[];
$restCodig="";
if(strpos($codig1, ',') ) {
    $cod1=explode(",",$codig1);
    for($i=0;$i<count($cod1);$i++){
        $rest = DB::table('clavecali')->select('defecto')->where('clave', $cod1[$i])->first();
        if($i<count($cod1)-1){

            $restCodig = $restCodig.$rest->defecto.';';
        }else{
            $restCodig = $restCodig.$rest->defecto;
        }


    }
    return response()->json($restCodig);
}else{
    $buscar = DB::table('clavecali')->select('defecto')->where('clave', $codig1)->first();
    if($buscar->defecto != null){

        $restCodig = $buscar ;
    }
    return response()->json($restCodig);
}




}
public function codigoCalidad(request $request){
    $codigo=$request->input('code-bar');
    if(strpos($codigo, "'") ) {
        $codigo = str_replace("'", "-", $codigo);
    }

    $buscar=DB::select("SELECT count,donde FROM registro WHERE info='$codigo'");
    if (!$buscar) {
        return redirect('calidad')->with('response', 'Record not found');
    }else{
        foreach($buscar as $rowb){
            $count=$rowb->count;
            $area=$rowb->donde;

            return redirect('calidad')->with('response', "Record in $area");
    }

}



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
            return redirect('/calidad')->with('error', 'Failed to save data.');
        }

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

    public function timesDead(Request $request){
        $id=$request->input('id');
        $timeNow=strtotime(date('d-m-Y H:i'));
        $buscar=DB::table('timedead')->where('id','=',$id)->first();
        $timeIni=$buscar->timeIni;
        $Totaltime=$timeNow-$timeIni;
        $total=round($Totaltime/60,2);
        $update=DB::table('timedead')->where('id','=',$id)->update(['timeFin'=>$timeNow,'total'=>$total]);
        return redirect('/calidad');
    }

    }


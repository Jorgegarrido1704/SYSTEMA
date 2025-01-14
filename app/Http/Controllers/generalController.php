<?php

namespace App\Http\Controllers;
use App\Models\assistence;
use App\Models\KitsAlmcen;
use App\Models\listaCalidad;
use App\Models\material;
use App\Models\timesHarn;
use Illuminate\Support\Facades\Redirect;
use App\Models\Maintanance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Wo;
use App\Models\login;
use App\Models\desviation;
use App\Models\Paros;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables;
use App\Models\regfull;
use App\Models\ParosProd;
use App\Models\regPar;
use App\Models\regParTime;
use App\Models\errores;



class generalController extends Controller
{

    public function __invoke(){
        $week=date('W');
        $value = session('user');
        $cat = session('categoria');
        if($cat=='' OR $value==''){
            return view('login');
        }else{

        $registros=[];
        $buscauser=DB::select("SELECT category FROM login WHERE user='$value'");
        foreach($buscauser as $rowuser){
            $categoria=$rowuser->category;
        }if($categoria=='ensa'){
               $buscarporid=DB::select("SELECT * FROM registro INNER JOIN registroparcial ON registro.info=registroparcial.codeBar WHERE ensaPar>0  ORDER BY NumPart");
                $registros=[];
                $i=0;
                foreach($buscarporid as $idrow){
                    $registros[$i][0]=$idrow->id;
                    $registros[$i][1]=$idrow->NumPart;
                    $registros[$i][2]=$idrow->rev;
                    $registros[$i][3]=$idrow->wo;
                    $registros[$i][4]=$idrow->ensaPar;
                    $registros[$i][5]=$idrow->paro;
                    $registros[$i][6]=$idrow->tiempototal;
                    $i++;
                }

        }else if($categoria=='emba'){
            $buscarporid=DB::select("SELECT * FROM registro INNER JOIN registroparcial ON registro.info=registroparcial.codeBar WHERE embPar>0  ORDER BY NumPart");
            $registros=[];
            $i=0;
            foreach($buscarporid as $idrow){
                $registros[$i][0]=$idrow->id;
                $registros[$i][1]=$idrow->NumPart;
                $registros[$i][2]=$idrow->rev;
                $registros[$i][3]=$idrow->wo;
                $registros[$i][4]=$idrow->embPar;
                $registros[$i][5]=$idrow->paro;
                $registros[$i][6]=$idrow->tiempototal;
                $i++;
            }

        }else if($categoria=='libe'){
            $buscarporid=DB::select("SELECT * FROM registro INNER JOIN registroparcial ON registro.info=registroparcial.codeBar WHERE libePar>0  ORDER BY NumPart");
                $registros=[];
                $i=0;
                foreach($buscarporid as $idrow){
                    $registros[$i][0]=$idrow->id;
                    $registros[$i][1]=$idrow->NumPart;
                    $registros[$i][2]=$idrow->rev;
                    $registros[$i][3]=$idrow->wo;
                    $registros[$i][4]=$idrow->libePar;
                    $registros[$i][5]=$idrow->paro;
                    $registros[$i][6]=$idrow->tiempototal;
                    $i++;
                }

        }else if($categoria=='loom'){
            $buscarporid=DB::select("SELECT * FROM registro INNER JOIN registroparcial ON registro.info=registroparcial.codeBar WHERE loomPar>0  ORDER BY NumPart");
            $registros=[];
            $i=0;
            foreach($buscarporid as $idrow){
                $registros[$i][0]=$idrow->id;
                $registros[$i][1]=$idrow->NumPart;
                $registros[$i][2]=$idrow->rev;
                $registros[$i][3]=$idrow->wo;
                $registros[$i][4]=$idrow->loomPar;
                $registros[$i][5]=$idrow->paro;
                $registros[$i][6]=$idrow->tiempototal;
                $i++;
            }


        }else if($categoria=='cort'){
            $buscarporid=DB::select("SELECT * FROM registro INNER JOIN registroparcial ON registro.info=registroparcial.codeBar WHERE cortPar>0  ORDER BY NumPart");
                $registros=[];
                $i=0;
                foreach($buscarporid as $idrow){
                    $registros[$i][0]=$idrow->id;
                    $registros[$i][1]=$idrow->NumPart;
                    $registros[$i][2]=$idrow->rev;
                    $registros[$i][3]=$idrow->wo;
                    $registros[$i][4]=$idrow->cortPar;
                    $registros[$i][5]=$idrow->paro;
                    $registros[$i][6]=$idrow->tiempototal;
                    $i++;
                }
        } $assis=DB::select("SELECT * FROM assistence WHERE week='$week' and  lider='$value'");
            $i=0;
            $assit=[];
            foreach($assis as $rowassis){
                $assit[$i][0]=$rowassis->week;
                $assit[$i][1]=$rowassis->lider;
                $assit[$i][2]=$rowassis->name;
                $assit[$i][3]=$rowassis->lunes;
                $assit[$i][4]=$rowassis->martes;
                $assit[$i][5]=$rowassis->miercoles;
                $assit[$i][6]=$rowassis->jueves;
                $assit[$i][7]=$rowassis->viernes;
                $assit[$i][8]=$rowassis->sabado;
                $assit[$i][9]=$rowassis->domingo;
                $assit[$i][10]=$rowassis->bonoAsistencia;
                $assit[$i][11]=$rowassis->bonoPuntualidad;
                $assit[$i][12]=$rowassis->extras;
                $assit[$i][13]=$rowassis->id;
                $i++;
            }
            $buscarparo=DB::table("registro_paro")->select("fecha","equipo","nombreEquipo","dano","atiende","id")->where('finHora', '=','')->where('quien',"=", $value)->get();
            $i=0;
            $paros=[];
            foreach($buscarparo as $rowparo){
                $paros[$i][0]=$rowparo->fecha;
                $paros[$i][1]=$rowparo->equipo;
                $paros[$i][2]=$rowparo->nombreEquipo;
                $paros[$i][3]=$rowparo->dano;
                if($rowparo->atiende!="Nadie aun"){$paros[$i][4]="En Proceso";}
                else if($rowparo->atiende=="Nadie aun"){$paros[$i][4]="En espera";     }
                $paros[$i][5]=$rowparo->id;
                $i++;
            }
            $buscardesv=DB::table("desvation")->select("*")->where('quien','=',$value)->get();
            $i=0;$desviations=[];
            foreach($buscardesv as $rowdes){
                $desviations[$i][0]=$rowdes->id;
                $desviations[$i][1]=$rowdes->Mafec;
                $desviations[$i][2]=$rowdes->porg;
                $desviations[$i][3]=$rowdes->psus;
                $desviations[$i][4]=$rowdes->cliente;
                if($rowdes->fcom==""){
                    $desviations[$i][5]="Sin Firmar";
                }else{
                    $desviations[$i][5]="Firmada";
                }if($rowdes->fing==""){
                    $desviations[$i][6]="Sin Firmar";
                }else{
                    $desviations[$i][6]="Firmada";
                }if($rowdes->fcal==""){
                    $desviations[$i][7]="Sin Firmar";
                }else{
                    $desviations[$i][7]="Firmada";
                }if($rowdes->fpro==""){
                    $desviations[$i][8]="Sin Firmar";
                }else{
                    $desviations[$i][8]="Firmada";
                }
                if($rowdes->fimm==""){
                    $desviations[$i][9]="Sin Firmar";
                }else{
                    $desviations[$i][9]="Firmada";
                }
                $desviations[$i][10]=$rowdes->fecha;


                $i++;
            }
            $buscarreqM=DB::table('material')->select("*")->where('who','=',$value)->get();
            $i=0;$materials=[];
            foreach($buscarreqM as $rowMat){
                $materials[$i][0]=$rowMat->folio;
                $materials[$i][1]=$rowMat->description;
                $materials[$i][2]=$rowMat->note;
                $materials[$i][3]=$rowMat->qty;
                if($rowMat->aprovadaComp!='' and $rowMat->negada==""){
                $materials[$i][4]="Aprovada por Compras";
                }else if($rowMat->aprovadaComp=='' and $rowMat->negada==""){
                    $materials[$i][4]="En espera de respuesta";
                }else if($rowMat->aprovadaComp=='' and $rowMat->negada!=""){
                    $materials[$i][4]="cancelada";
                }else if($rowMat->aprovadaComp!='' and $rowMat->negada!=""){
                    $materials[$i][4]="cancelada";
                }    $i++;      }
                $fulls=[];
                $i=0;
        $buscarfull=DB::table('registrofull')->where('estatus','!=','finalizado')->get();
        foreach($buscarfull as $full){
            $fulls[$i][0]=$full->fechaSolicitud;
            $fulls[$i][1]=$full->np;
            $fulls[$i][2]=$full->rev;
            $fulls[$i][3]=$full->cliente;
            $fulls[$i][4]=$full->Cuantos;
            $fulls[$i][5]=$full->estatus;
            $i++;
        }

        return view("general",['fulls'=>$fulls,'cat'=>$cat,'value'=>$value,'registros'=>$registros,'week'=>$week,'assit'=>$assit,'paros'=>$paros,'desviations'=>$desviations,'materials'=>$materials]);
    }

}
    public function codigo(request $request){
        $cat=session('categoria');        $value=session('user');        if($cat=='' OR $value==''){
            return view('login');
        }else{
        $cantidad=$request->input('cantidad');
        $codigo=$request->input('code-bar');
        $codigo=str_replace("'","-",$codigo);
        $buscarCantidad=DB::table('registroparcial')->where('codeBar','=',$codigo)->get();
        if(empty($buscarCantidad)){ $resp="Recod not found";}
        else{
            foreach($buscarCantidad as $rowCantidad){
                $cortePar=$rowCantidad->cortPar;
                $libePar=$rowCantidad->libePar;
                $ensaPar=$rowCantidad->ensaPar;
                $loomPar=$rowCantidad->loomPar;
                $testPar=$rowCantidad->testPar;
                $embPar=$rowCantidad->embPar;
            $resp="Cutting: $cortePar, Terminals: $libePar, Assembly: $ensaPar, Looming: $loomPar, Testing: $testPar, Shipping: $embPar";
        }}
            $todays=date('d-m-Y H:i');
            $buscar=DB::select("SELECT count,wo,donde,NumPart,rev,Qty,po,cliente FROM registro WHERE info='$codigo'");
            if (!$buscar) { return redirect('general')->with('response', 'Record not found');  }else{
            foreach($buscar as $rowb){
            $count=$rowb->count;
            $area=$rowb->donde;
            $pnReg=$rowb->NumPart;
            $rev=$rowb->rev;
            $wo=$rowb->wo;
            $orgQty=$rowb->Qty;
            $cli=$rowb->cliente;
            $poReg=$rowb->po;
        }}
        function updateCount($codigo,$upCant,$sesion,$donde,$todays){
            $registroTiempo=new regParTime();
                    $registroTiempo->codeBar=$codigo;
                    $registroTiempo->qtyPar=$upCant;
                    $registroTiempo->area=$sesion.'/'.$donde;
                    $registroTiempo->fechaReg=$todays;
                    $registroTiempo->save();
        }
        function upRegistros($count,$codigo,$process,$todays,$place){
                $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => $process]);
                $updatetime=DB::table('timesharn')->where('bar',$codigo)->update([$place=>$todays]);
                    }
        function Resp($codigo){
            $buscarCantidad=DB::table('registroparcial')->where('codeBar','=',$codigo)->get();
            if(empty($buscarCantidad)){ $resp="Recod not found";}
            else{
                foreach($buscarCantidad as $rowCantidad){
                    $cortePar=$rowCantidad->cortPar;
                    $libePar=$rowCantidad->libePar;
                    $ensaPar=$rowCantidad->ensaPar;
                    $loomPar=$rowCantidad->loomPar;
                    $testPar=$rowCantidad->testPar;
                    $embPar=$rowCantidad->embPar;
                $resp="Cutting: $cortePar, Terminals: $libePar, Assembly: $ensaPar, Looming: $loomPar, Testing: $testPar, Shipping: $embPar";
            }}
            return $resp;
        }
            $donde=$rep='';
            $sesion=session('user');
            $sesionBus = DB::table('login')->select('category')->where('user', $sesion)->limit(1)->first();
            $donde = $sesionBus->category;
                 if($cantidad<=0 or $cantidad==NULL){
                    if($count===1){ return redirect('general')->with('response', 'Plannig Station, Harness Not update');
                    }else  if($donde==='loom' and $count===8){
                        $rep="Looming Process";
                        upRegistros(9,$codigo,"Looming Process",$todays,'loom');
                    }else if($donde==='ensa' and ($count===6 or $count===15) ){
                        $rep="Assembly Process";
                        upRegistros(7,$codigo,'Assembly Process',$todays,'ensa');
                    }else if(($donde==='libe') and $count===4){
                        $rep="Looming Process";
                        upRegistros($count,$codigo,"Terminals Process",$todays,'term');
                    }else if(($donde==='cort' or $donde==='libe') and $count==2){
                        $rep="Looming Process";
                        upRegistros(3,$codigo,"Cutting Process",$todays,'cut');
                    } 
                    $resp = Resp($codigo)."  ".$rep;
                    return redirect('general')->with('response', $resp);
                      }else{
                          if($count===1){ return redirect('general')->with('response', 'Plannig Station, Harness Not update');
                        }else if(($donde==='loom' and $count===9) or ($donde==='loom' and $loomPar>0)){
                           if( $cantidad>=($loomPar)){
                                if(substr($rev,0,4)=='PRIM' or substr($rev,0,4)=='PPAP' ){
                                    upRegistros(14,$codigo,'En espera de Ingenieria Loom',$todays,'loomF');
                                    $resp=Resp($codigo);
                                    return redirect('general')->with('response', $resp);
                                }else{
                                 $nuevo=$testPar+$loomPar;
                                $update = DB::table('registroparcial')->where('codeBar', "=",$codigo)->update(['loomPar' => '0','testPar' => $nuevo]);
                                updateCount($codigo,$cantidad, $sesion,$donde,$todays);
                                upRegistros(10,$codigo,'Testing Process',$todays,'loomF');
                                  $tiempoUp=DB::table('tiempos')->where('info',$codigo)->update(['loom'=>$todays]);
                                }
                        } else  if($cantidad<($loomPar) and (substr($rev,0,4)!='PRIM' or substr($rev,0,4)!='PPAP' )){
                            $restoAnt=$loomPar-$cantidad; $nuevo=$testPar+$cantidad;
                            $update = DB::table('registroparcial')->where('codeBar', "=",$codigo)->update(['loomPar' => $restoAnt,'testPar' => $nuevo]);
                            updateCount($codigo,$cantidad,$sesion,$donde,$todays);
                        }
                        if($cantidad<$loomPar){
                            $nuevo=$cantidad;
                        }else if($cantidad>=$loomPar){
                            $nuevo=$loomPar;                            
                        }
                        $buscarcalidad=DB::table('calidad')->where("info",$codigo)->first();
                        if($buscarcalidad){
                            $regcalidad=$buscarcalidad->qty;
                            $nueva=$regcalidad+$nuevo;
                            $update = DB::table('calidad')->where('info', $codigo)->update(['qty' => $nueva]);
                        }else{
                            $calReg=new listaCalidad;
                            $calReg->np=$pnReg;
                            $calReg->client=$cli;
                            $calReg->wo=$wo;
                            $calReg->po=$poReg;
                            $codigo=strtoupper($codigo);
                            $calReg->info=$codigo;
                            $calReg->qty=$nuevo;
                            $calReg->parcial="Si";
                            $calReg->save();
                        }
                    }else if(($donde==='ensa' and $count===7) or ($donde==='ensa' and $ensaPar>0)){
                        if( $cantidad<($ensaPar) and (substr($rev,0,4)!='PRIM' or substr($rev,0,4)!='PPAP' )){
                            $restoAnt=$ensaPar-$cantidad;             $nuevo=$loomPar+$cantidad;
                            $update = DB::table('registroparcial')->where('codeBar', "=",$codigo)->update(['ensaPar' => $restoAnt,'loomPar' => $nuevo]);
                            updateCount($codigo,$cantidad,$sesion,$donde,$todays);
                        }else if($cantidad>=($ensaPar)){
                            if(substr($rev,0,4)=='PRIM' or substr($rev,0,4)=='PPAP' ){
                            $ensaPar;     $nuevo=$loomPar+$cantidad;
                            $update = DB::table('registroparcial')->where('codeBar', "=",$codigo)->update(['ensaPar' => '0','loomPar' => $nuevo]);
                            updateCount($codigo,$cantidad,$sesion,$donde,$todays);
                            upRegistros(13,$codigo,'En espera de Ingenieria ensamble',$todays,'ensaF');
                            $resp=Resp($codigo); return redirect('general')->with('response', $resp);
                        }else{
                        $nuevo=$loomPar+$ensaPar;
                        $update = DB::table('registroparcial')->where('codeBar', "=",$codigo)->update(['ensaPar' => '0','loomPar' => $nuevo]);
                        updateCount($codigo,$cantidad,$sesion,$donde,$todays);
                        upRegistros(8,$codigo,'Looming Process',$todays,'ensaF');
                        $tiempoUp=DB::table('tiempos')->where('info',$codigo)->update(['ensamble'=>$todays]);
                    }    }
            }else if((($donde==='libe' ) and $count===5) or (($donde==='libe') and $libePar>0)){
                if( $cantidad<($libePar) and (substr($rev,0,4)!='PRIM' or substr($rev,0,4)!='PPAP' )){
                    $restoAnt=$libePar-$cantidad; $nuevo=$ensaPar+$cantidad;
                    $update = DB::table('registroparcial')->where('codeBar', "=",$codigo)->update(['libePar' => $restoAnt,'ensaPar' => $nuevo]);
                    updateCount($codigo,$cantidad,$sesion,$donde,$todays);
                }else if( $cantidad>=($libePar)){
                    $restoAnt=0; $nuevo=$ensaPar+$libePar;
                    if(substr($rev,0,4)=='PRIM' or substr($rev,0,4)=='PPAP' ){
                        $update = DB::table('registroparcial')->where('codeBar', "=",$codigo)->update(['libePar' => $restoAnt,'ensaPar' => $nuevo]);
                        updateCount($codigo,$cantidad,$sesion,$donde,$todays);
                        if ( upRegistros(16,$codigo,'Engineering Terminals',$todays,'termF')) {
                            $buscarinfo=DB::table('registro_pull')->where('wo',substr($wo,2))
                            ->orWhere('wo',$wo)->get();
                            if(count($buscarinfo)<=0){
                            $subject= 'Urgente se necesita pull test para  NP: '.$pnReg.' con Work Order:'.$wo;
                            $date = date('d-m-Y');
                        $time = date('H:i');
                        $content = 'Buen día,'."\n\n".'Les comparto que el día ' . $date . ' a las ' . $time . "\n\n"."Salió de liberacion el"."\n\n";
                $content .= "\n\n"." número de parte: " . $pnReg;
                $content .= "\n\n"." Con Work order: " . $wo;
                $content .= "\n\n"." Se solicita de su apoyo para revisar el motivo por el cual no se realizo la prueba de pull";
                            $recipients = [
                               'jcervera@mx.bergstrominc.com',
                                'dvillalpando@mx.bergstrominc.com',
                                'egaona@mx.bergstrominc.com',
                                'mvaladez@mx.bergstrominc.com',
                                'jolaes@mx.bergstrominc.com',
                                'lramos@mx.bergstrominc.com',
                                'emedina@mx.bergstrominc.com',
                                'jgarrido@mx.bergstrominc.com',
                                'jlopez@mx.bergstrominc.com'
                            ];
                            Mail::to($recipients)->send(new \App\Mail\PPAPING($subject,$content));}
                        }  $resp=Resp($codigo);
                        return redirect('general')->with('response', $resp);
                    }else {
                    $update = DB::table('registroparcial')->where('codeBar', "=",$codigo)->update(['libePar' => $restoAnt,'ensaPar' => $nuevo]);
                    updateCount($codigo,$cantidad,$sesion,$donde,$todays);
                    if (upRegistros(6,$codigo,'Waiting Assembly',$todays,'termF')) {
                        $buscarinfo=DB::table('registro_pull')->where('wo',substr($wo,2))
                        ->orWhere('wo',$wo)->get();
                        if(count($buscarinfo)<=0){
                        $subject= 'Urgente se necesita pull test para  NP: '.$pnReg.' con Work Order:'.$wo;
                        $date = date('d-m-Y');
                    $time = date('H:i');
                    $content = 'Buen día,'."\n\n".'Les comparto que el día ' . $date . ' a las ' . $time . "\n\n"."Salió de liberacion el"."\n\n";
                    $content .= "\n\n"." número de parte: " . $pnReg;
                    $content .= "\n\n"." Con Work order: " . $wo;
                    $content .= "\n\n"." Se solicita de su apoyo para revisar el motivo por el cual no se realizo la prueba de pull";


                                $recipients = [

                                'jcervera@mx.bergstrominc.com',
                                'jcrodriguez@mx.bergstrominc.com',
                                    'jguillen@mx.bergstrominc.com',
                                    'jolaes@mx.bergstrominc.com',
                                    'dvillalpando@mx.bergstrominc.com',
                                    'lramos@mx.bergstrominc.com',
                                    'emedina@mx.bergstrominc.com',
                                    'jgarrido@mx.bergstrominc.com',
                                    'jlopez@mx.bergstrominc.com'


                                ];
                                Mail::to($recipients)->send(new \App\Mail\PPAPING($subject,$content));}
                            }
                            }}
            }else if(((  $donde==='cort' or $donde==='libe' ) and $count===3 ) or ((  $donde==='cort' or $donde==='libe') and $cortePar>0)){
                if( $cantidad<$cortePar and (substr($rev,0,4)!='PRIM' or substr($rev,0,4)!='PPAP' )){
                    $restoAnt=$cortePar-$cantidad;      $nuevo=$libePar+$cantidad;
                    updateCount($codigo,$cantidad,$sesion,$donde,$todays);
                    $update = DB::table('registroparcial')->where('codeBar', "=",$codigo)->update(['cortPar'=> $restoAnt,'libePar' => $nuevo]);
                }else if( $cantidad>=($cortePar)){
                    $restoAnt=0; $nuevo=$libePar+$cortePar;
                if(substr($rev,0,4)=='PRIM' or substr($rev,0,4)=='PPAP' ){
                    updateCount($codigo,$cantidad,$sesion,$donde,$todays);
                    $update = DB::table('registroparcial')->where('codeBar', "=",$codigo)->update(['cortPar'=> $restoAnt,'libePar' => $nuevo]);
                    upRegistros(17,$codigo,'Engineering Cutting',$todays,'cutF');
                    $resp=Resp($codigo);
                    return redirect('general')->with('response', $resp);
                }else{
                    updateCount($codigo,$cantidad,$sesion,$donde,$todays);
                    $update = DB::table('registroparcial')->where('codeBar', "=",$codigo)->update(['cortPar'=> $restoAnt,'libePar' => $nuevo]);
                    upRegistros(4,$codigo,'Waitting for Terminals',$todays,'cutF');
                    $tiempoUp=DB::table('tiempos')->where('info',$codigo)->update(['corte'=>$todays]);
                    }}
                }else  if($donde==='loom' and $count===8){
                $rep="Looming Process";
                upRegistros(9,$codigo,"Looming Process",$todays,'loom');
            }else if($donde==='ensa' and ($count===6 or $count===15) ){
                $rep="Assembly Process";
                upRegistros(7,$codigo,'Assembly Process',$todays,'ensa');
            }else if(($donde==='libe') and $count===4){
                $rep="Looming Process";
                upRegistros($count,$codigo,"Terminals Process",$todays,'term');
            }else if(($donde==='cort' or $donde==='libe') and $count==2){
                $rep="Looming Process";
                upRegistros(3,$codigo,"Cutting Process",$todays,'cut');
            }
            $resp = Resp($codigo)."  ".$rep;
            return redirect('general')->with('response', $resp);
                }
                }
    }
    public function Bom(Request $request){
        $boms = $request->input('partnum');
        $value=session('user');
        if($value=='Brando O'){
            $results = DB::table('datos')
            ->select('item', 'qty')
            ->where('part_num', '=', $boms)
            ->where(function ($query) {
                $query->where('item', 'LIKE', '%T1-%')
                    ->orWhere('item', 'LIKE', '%T2-%')
                    ->orWhere('item', 'LIKE', '%T3-%')
                    ->orWhere('item', 'LIKE', '%T4-%')
                    ->orWhere('item', 'LIKE', '%T5-%')
                    ->orWhere('item', 'LIKE', '%TA2-%')
                    ->orWhere('item', 'LIKE', '%DA2-%')
                    ->orWhere('item', 'LIKE', '%EA2-%')
                    ->orWhere('item', 'LIKE', '%YA2-%');
            })
            ->get();

    }else{
        $results = DB::table('datos')->select('item', 'qty')->where('part_num', $boms)->get();
    }
        $resps = [];
        foreach ($results as $rest) {
            $resps[] = [$rest->item, $rest->qty];
        }

        $invokeController = new generalController();
        $invokeResult = $invokeController->__invoke();

        // Extract the values from the invoke result
        $value = $invokeResult->getData()['value'];
        $registros = $invokeResult->getData()['registros'];
        $week = $invokeResult->getData()['week'];
        $assit = $invokeResult->getData()['assit'];
        $paros=$invokeResult->getData()['paros'];
        $desviations=$invokeResult->getData()['desviations'];
        $materials=$invokeResult->getData()['materials'];
        $cat=$invokeResult->getData()['cat'];
        // Return the view with the retrieved values
        return view("general", ['cat'=>$cat,'value' => $value, 'registros' => $registros,'resps'=>$resps,'week'=>$week,'assit'=>$assit,'paros'=>$paros,'desviations'=>$desviations,'materials'=>$materials]);



    }
    public function desviation(Request $request){
    $value = session('user');
    $modelo = $request->input('modelo');
    $npo = $request->input('numPartOrg');
    $nps = $request->input('numPartSus');
    $time = $request->input('time');
    $cant = $request->input('cant');
    $text = $request->input('text');
    $evi = $request->input('evi');
    $acc = $request->input('acc');
    $busclient = DB::select("SELECT client FROM precios WHERE pn='$modelo'");
    foreach ($busclient as $row) {
        $cliente = $row->client;    }
    $user = session('user');
    $today = date('d-m-Y H:i');
    $desv = new desviation();
    if(empty($cliente)){
        $cliente='';
    }
    $desv->fill([
        'fecha'=>$today,
        'cliente'=>$cliente,
        'quien'=>$user,
        'Mafec' => $modelo,
        'porg' => $npo,
        'psus' => $nps,
        'peridoDesv' => $time,
        'clsus' => $cant,
        'Causa' => $text,
        'accion' => $acc,
        'evidencia' => $evi,
        'fcal'=>"",
        'fcom'=>"",
        'fpro'=>"",
        'fing'=>"",
        'fimm'=>"",
        'rechazo'=>"",    ]);

    if ($desv->save()) {
        return redirect('/general')->with('success', 'Data successfully saved.');
    } else {
        return redirect('/general')->with('error', 'Failed to save data.');
    }
}
    public function maintananceGen(Request $request){
        $value=session('user');
        $NomEq=$request->input('nom_equipo');
        $dano=$request->input('dano');
        $area=$request->input('area');
        $quien=$request->input('quien');
        $today = date('d-m-Y H:i');
        $maint= new Maintanance;
        $maint->fill([
            'fecha'=>$today,
            'equipo'=>'Mantenimiento',
            'nombreEquipo'=>$NomEq,
            'dano'=>$dano,
            'quien'=>$quien,
            'area'=>$area,
            'atiende'=>'Nadie aun',
            'trabajo'=>'',
            'Tiempo'=>'',
            'inimant'=>'',
            'finhora'=>''
        ]);


        if ($maint->save()) {
            $idUlt=DB::table('registro_paro')->where('equipo','Mantenimiento')->orderBy('id','desc')->first();
            $id_f=$idUlt->id;
            $hoy=date('d-m-Y');
        $hora=date('H:i');
        $Paro= new Paros;
        $Paro->fill([
            'id_maquina'=>$NomEq,
            'area'=>$area,
            'tipoMant'=>'',
            'periMant'=>'',
            'descTrab'=>'',
            'equipo'=>$NomEq,
            'estatus'=>'',
            'comentarios'=>'',
            'fechReq'=>$hoy,
            'fechaProg'=>'',
            'fechaEntre'=>'',
            'horaIniServ'=>'',
            'horaFinServ'=>'',
            'ttServ'=>0,
            'solPor'=>$quien,
            'SupMant'=>'Javier Cervantes',
            'tecMant'=>'',
            'ValGer'=>'',
            'id_falla'=>$id_f
        ]);
        if ($Paro->save()) {
            return redirect('/general')->with('success', 'Data successfully saved.');
        } else {
            return redirect('/general')->with('error', 'Failed to save data.');
        }}
    }

    public function assistence(Request $request) {

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
        return redirect('/general');

    }
    public function material(Request $request){
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

        return redirect('/general');
        }

    public function pause(Request $request){
        $id=$request->input('id_but');
        $funcion=$request->input('funcion');
        $motivo =$request->input('motivo');

        $cat=session('categoria');
        $tiempo=date('d-m-Y H:i');
        $id_Cominezo=$request->input('id_butC');
        if($motivo==""){
            $motivo="Sin motivo Por " .$cat;

        }
        if(!empty($id_Cominezo)){
            switch($cat){
                case 'cort':
                    $update=DB::table('timesharn')->where('wo','=',$id_Cominezo)->update(['cut'=>$tiempo]);
                    break;
                case 'ensa':
                    $update=DB::table('timesharn')->where('wo','=',$id_Cominezo)->update(['ensa'=>$tiempo]);

                case 'libe':
                    $update=DB::table('timesharn')->where('wo','=',$id_Cominezo)->update(['term'=>$tiempo]);
                    break;
                case 'loom':
            $update=DB::table('timesharn')->where('wo','=',$id_Cominezo)->update(['loom'=>$tiempo]);
            case 'cali':
                $update=DB::table('timesharn')->where('wo','=',$id_Cominezo)->update(['qly'=>$tiempo]);
                break;
            case 'emba':
        $update=DB::table('timesharn')->where('wo','=',$id_Cominezo)->update(['emba'=>$tiempo]);
        break;
    } $alta=DB::table('registro')->where('wo','=',$id_Cominezo)->update(['paro'=>'En proceso']);

        }
        if(!empty($id) && $funcion=="pausar"){
            switch($cat){
                case 'cort':
                    $update=DB::table('timesharn')->where('wo','=',$id)->update(['cutF'=>$tiempo]);
                    $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>$motivo]);
                    $prod= new ParosProd();
                    $prod->fecha=$tiempo;
                    $prod->area='Corte';
                    $prod->trabajo=$motivo;
                    $prod->finhora='';
                    $prod->id_request=$id;
                    $prod->save();
                    break;
                case 'ensa':
                    $update=DB::table('timesharn')->where('wo','=',$id)->update(['ensaF'=>$tiempo]);
                    $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>$motivo]);
                    $prod= new ParosProd();
                    $prod->fecha=$tiempo;
                    $prod->area='Ensamble';
                    $prod->trabajo=$motivo;
                    $prod->finhora='';
                    $prod->id_request=$id;
                    $prod->save();
                    break;
                case 'libe':
                    $update=DB::table('timesharn')->where('wo','=',$id)->update(['termF'=>$tiempo]);
                    $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>$motivo]);
                    $prod= new ParosProd();
                    $prod->fecha=$tiempo;
                    $prod->area='Liberacion';
                    $prod->trabajo=$motivo;
                    $prod->finhora='';
                    $prod->id_request=$id;
                    $prod->save();
                    break;
                case 'loom':
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['loomF'=>$tiempo]);
            $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>$motivo]);
            $prod= new ParosProd();
                    $prod->fecha=$tiempo;
                    $prod->area='Loom';
                    $prod->trabajo=$motivo;
                    $prod->finhora='';
                    $prod->id_request=$id;
                    $prod->save();
            case 'cali':
                $update=DB::table('timesharn')->where('wo','=',$id)->update(['qlyF'=>$tiempo]);
                $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>$motivo]);
                $prod= new ParosProd();
                    $prod->fecha=$tiempo;
                    $prod->area='Calidad';
                    $prod->trabajo=$motivo;
                    $prod->finhora='';
                    $prod->id_request=$id;
                    $prod->save();
                break;
            case 'emba':
        $update=DB::table('timesharn')->where('wo','=',$id)->update(['embaF'=>$tiempo]);
        $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>$motivo]);
        $prod= new ParosProd();
                    $prod->fecha=$tiempo;
                    $prod->area='Embarque';
                    $prod->trabajo=$motivo;
                    $prod->finhora='';
                    $prod->id_request=$id;
                    $prod->save();
            break;
        default:
            break;
    }

}else if(!empty($id) && $funcion=="continuar"){
    switch($cat){
        case 'cort':
            $select=DB::table('timesharn')->where( 'wo','=',$id)->first();
            $ini=$select->cut;
            $fin=$select->cutF;
            $tiempodiff=strtotime($fin) - strtotime($ini);
            $newTime=date('d-m-Y h:i',(strtotime($tiempo)-$tiempodiff));
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['cut'=>$newTime,'cutF'=>'']);
            $buscarReg=DB::table('registro')->where('wo','=',$id)->first();
            if($buscarReg){
                $registro=DB::table('registro_paro_corte')->where('id_request','=',$id)->orderBy('id','desc')->limit(1)->update(['finhora'=>$newTime]);
                $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>'En proceso']);
            }
            break;
        case 'ensa':
            $select=DB::table('timesharn')->where( 'wo','=',$id)->first();
            $ini=$select->ensa;
            $fin=$select->ensaF;
            $tiempodiff=strtotime($fin) - strtotime($ini);
            $newTime=date('d-m-Y h:i',(strtotime($tiempo)-$tiempodiff));
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['ensa'=>$newTime,'ensaF'=>'']);
            $buscarReg=DB::table('registro')->where('wo','=',$id)->first();
            if($buscarReg){
                $registro=DB::table('registro_paro_corte')->where('id_request','=',$id)->orderBy('id','desc')->limit(1)->update(['finhora'=>$newTime]);
                $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>'En proceso']);
            }
            break;
        case 'libe':
            $select=DB::table('timesharn')->where( 'wo','=',$id)->first();
            $ini=$select->term;
            $fin=$select->termF;
            $tiempodiff=strtotime($fin) - strtotime($ini);
            $newTime=date('d-m-Y h:i',(strtotime($tiempo)-$tiempodiff));
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['term'=>$newTime,'termF'=>'']);
            $buscarReg=DB::table('registro')->where('wo','=',$id)->first();
            if($buscarReg){
                $registro=DB::table('registro_paro_corte')->where('id_request','=',$id)->orderBy('id','desc')->limit(1)->update(['finhora'=>$newTime]);
                $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>'En proceso']);
            }
            break;
        case 'loom':
            $select=DB::table('timesharn')->where( 'wo','=',$id)->first();
            $ini=$select->loom;
            $fin=$select->loomF;
            $tiempodiff=strtotime($fin) - strtotime($ini);
            $newTime=date('d-m-Y h:i',(strtotime($tiempo)-$tiempodiff));
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['loom'=>$newTime,'loomF'=>'']);
            $buscarReg=DB::table('registro')->where('wo','=',$id)->first();
            if($buscarReg){
                $registro=DB::table('registro_paro_corte')->where('id_request','=',$id)->orderBy('id','desc')->limit(1)->update(['finhora'=>$newTime]);
                $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>'En proceso']);
            }
    case 'cali':
        $select=DB::table('timesharn')->where( 'wo','=',$id)->first();
            $ini=$select->qly;
            $fin=$select->qlyF;
            $tiempodiff=strtotime($fin) - strtotime($ini);
            $newTime=date('d-m-Y h:i',(strtotime($tiempo)-$tiempodiff));
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['qly'=>$newTime,'qlyF'=>'']);
            $buscarReg=DB::table('registro')->where('wo','=',$id)->first();
            if($buscarReg){
                $registro=DB::table('registro_paro_corte')->where('id_request','=',$id)->orderBy('id','desc')->limit(1)->update(['finhora'=>$newTime]);
                $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>'En proceso']);
            }
        break;
    case 'emba':
        $select=DB::table('timesharn')->where( 'wo','=',$id)->first();
        $ini=$select->emba;
        $fin=$select->embaF;
        $tiempodiff=strtotime($fin) - strtotime($ini);
        $newTime=date('d-m-Y h:i',(strtotime($tiempo)-$tiempodiff));
        $update=DB::table('timesharn')->where('wo','=',$id)->update(['emba'=>$newTime,'embaF'=>'']);
        $buscarReg=DB::table('registro')->where('wo','=',$id)->first();
        if($buscarReg){
            $registro=DB::table('registro_paro_corte')->where('id_request','=',$id)->orderBy('id','desc')->limit(1)->update(['finhora'=>$newTime]);
            $alta=DB::table('registro')->where('wo','=',$id)->update(['paro'=>'En proceso']);
        }
        break;
    default:
        break;
}


}
return redirect('/general');
}

public function finishWork(Request $request){
    $id=$request->input('id_but');
    $today = date('d-m-Y H:i');
    $uptimes=DB::table('registro_paro')->where('id','=',$id)->update(['finhora'=>$today,'trabajo'=>'Finalizado']);
return redirect('/general');
}


public function KitsReq(Request $request){
    $cat=session('categoria');
    $value=session('user');
    $work=$request->input('workO');
    $nivel=$request->input('equipo');
    $time=date('d-m-Y H:i');
    if($work!="" && $nivel!=""){
        $buscar=DB::table('kitenespera')->where('wo','=',$work)->first();
        if(!empty($buscar)){
            $update=DB::table('kitenespera')->where('wo','=',$work)->update(['QuienSolicita'=>$value,'Area'=>'Ensamble','horaSolicitud'=>$time,'nivel'=>$nivel]);
            return redirect('/general');
        }else{
            $buscarWOReg=DB::table('registro')->where('wo','=',$work)->first();
            $np=$buscarWOReg->NumPart;
            $addKit= new KitsAlmcen();
            $addKit->np=$np;
            $addKit->wo=$work;
            $addKit->status='En espera';
            $addKit->fechaCreation='No Aun';
            $addKit->Quien='No Aun';
            $addKit->fechaSalida='No Aun';
            $addKit->QuienSolicita=$value;
            $addKit->Area='Ensamble';
            $addKit->horaSolicitud=$time;
            $addKit->nivel=$nivel;
           if($addKit->save()){
            return redirect('/general');
           }



        }
    }
}

public function regfull(Request $request){
    $value = session('user');
    $client=$request->input('cliente');
    $pn=$request->input('parte');
    $rev=$request->input('rev');
    $cant=$request->input('cant');
    $tablero=$request->input('tablero');
    $time=date('d-m-Y H:i');
    $pn=strtoupper($pn);
    $rev=strtoupper($rev);
    $tablero=strtoupper($tablero);
    $addfull= new regfull();
    $addfull->SolicitadoPor=$value;
    $addfull->fechaSolicitud=$time;
    $addfull->np=$pn;
    $addfull->rev=$rev;
    $addfull->cliente=$client;
    $addfull->Cuantos=$cant;
    $addfull->estatus='Pendiente';
    $addfull->fechaColocacion='No Aun';
    $addfull->QuienIng='No Aun';
    $addfull->fechaMant='No Aun';
    $addfull->fechaPiso='No Aun';
    $addfull->fechaCalidad='No Aun';
    $addfull->tablero = $tablero;
    if($addfull->save()){
        return redirect('/general');
    }

}
public function problemas_general(Request $request){
$value=session('user');
$date = date("d-m-Y");
$pn=$request->input('pnIs');
$wo=$request->input('workIs');
$rev=$request->input('revIs');
$prob=$request->input('probIs');
$descIs=$request->input('descIs');
$answer=$request->input('answer');
$val=$request->input('val');

$wo=substr($wo,0,6);
$addProb=new errores;
$addProb->pn=$pn;
$addProb->wo=$wo;
$addProb->rev=$rev;
$addProb->problem=$prob;
if($prob=="Paper work" || $prob="Both(Prosses Error and Paper work)"){
    $addProb->mostrar_ing=1;
}
$addProb->descriptionIs=$descIs;
$addProb->resp=$answer;
$addProb->WhoReg=$value;
$addProb->DateIs=$date;
$addProb->validator=$val;
if($addProb->save()){
    return redirect('/general');

}
}

}

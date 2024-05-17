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
               $buscarporid=DB::select("SELECT * FROM registro WHERE count='6' or count='7' ORDER BY cliente");
                $registros=[];
                $i=0;
                foreach($buscarporid as $idrow){
                    $registros[$i][0]=$idrow->id;
                    $registros[$i][1]=$idrow->NumPart;
                    $registros[$i][2]=$idrow->cliente;
                    $registros[$i][3]=$idrow->rev;
                    $registros[$i][4]=$idrow->wo;
                    $registros[$i][5]=$idrow->po;
                    $registros[$i][6]=$idrow->Qty;
                    $registros[$i][7]=$idrow->donde;
                    $registros[$i][8]=$idrow->paro;
                    $buscartime=DB::table('timesharn')->select('ensa', 'ensaF')->where('wo', $idrow->wo)->first();
                    $registros[$i][9]=$buscartime->ensa;
                    $registros[$i][10]=$buscartime->ensaF;
                    $i++;
                }

        }else if($categoria=='emba'){
            $buscarporid=DB::select("SELECT * FROM registro WHERE count='12' or paro!=''  ORDER BY cliente");
            $registros=[];
            $i=0;
            foreach($buscarporid as $idrow){
                $registros[$i][0]=$idrow->id;
                $registros[$i][1]=$idrow->NumPart;
                $registros[$i][2]=$idrow->cliente;
                $registros[$i][3]=$idrow->rev;
                $registros[$i][4]=$idrow->wo;
                $registros[$i][5]=$idrow->po;
                $registros[$i][6]=$idrow->Qty;
                $registros[$i][7]=$idrow->donde;
                $registros[$i][8]=$idrow->paro;
                $buscartime=DB::table('timesharn')->select('emba', 'embaF')->where('wo', $idrow->wo)->first();
                    $registros[$i][9]=$buscartime->emba;
                    $registros[$i][10]=$buscartime->embaF;
                $i++;
            }

        }else if($categoria=='libe'){
            $buscarporid=DB::select("SELECT * FROM registro WHERE count='2' or count='3' or count='4' or count='5'  ORDER BY cliente");
            $registros=[];
            $i=0;
            foreach($buscarporid as $idrow){
                $registros[$i][0]=$idrow->id;
                $registros[$i][1]=$idrow->NumPart;
                $registros[$i][2]=$idrow->cliente;
                $registros[$i][3]=$idrow->rev;
                $registros[$i][4]=$idrow->wo;
                $registros[$i][5]=$idrow->po;
                $registros[$i][6]=$idrow->Qty;
                $registros[$i][7]=$idrow->donde;
                $registros[$i][8]=$idrow->paro;
                if($idrow->count=='4' or $idrow->count=='5'){
                $buscartime=DB::table('timesharn')->select('term', 'termF')->where('wo', $idrow->wo)->first();
                    $registros[$i][9]=$buscartime->term;
                    $registros[$i][10]=$buscartime->termF;
                $i++;
            }else if($idrow->count=='2' or $idrow->count=='3'){
                $buscartime=DB::table('timesharn')->select('cut', 'cutF')->where('wo', $idrow->wo)->first();
                $registros[$i][9]=$buscartime->cut;
                $registros[$i][10]=$buscartime->cutF;
            $i++;
                }
            }

        }else if($categoria=='loom'){
            $buscarporid=DB::select("SELECT * FROM registro WHERE count='8' or count='9' ORDER BY cliente");
            $registros=[];
            $i=0;
            foreach($buscarporid as $idrow){
                $registros[$i][0]=$idrow->id;
                $registros[$i][1]=$idrow->NumPart;
                $registros[$i][2]=$idrow->cliente;
                $registros[$i][3]=$idrow->rev;
                $registros[$i][4]=$idrow->wo;
                $registros[$i][5]=$idrow->po;
                $registros[$i][6]=$idrow->Qty;
                $registros[$i][7]=$idrow->donde;
                $registros[$i][8]=$idrow->paro;
                $buscartime=DB::table('timesharn')->select('loom', 'loomF')->where('wo', $idrow->wo)->first();

                    $registros[$i][9]=$buscartime->loom;
                    $registros[$i][10]=$buscartime->loomF;

                $i++;
            }


        }else if($categoria=='plan'){
            $buscarporid=DB::select("SELECT * FROM registro WHERE count='1'   ORDER BY cliente");
            $registros=[];
            $i=0;
            foreach($buscarporid as $idrow){
                $registros[$i][0]=$idrow->id;
                $registros[$i][1]=$idrow->NumPart;
                $registros[$i][2]=$idrow->cliente;
                $registros[$i][3]=$idrow->rev;
                $registros[$i][4]=$idrow->wo;
                $registros[$i][5]=$idrow->po;
                $registros[$i][6]=$idrow->Qty;
                $registros[$i][7]=$idrow->donde;
                $registros[$i][8]=$idrow->paro;
                $i++;
            }

        }else if($categoria=='cort'){
            $buscarporid=DB::select("SELECT * FROM registro WHERE count='2' or count='3'   ORDER BY cliente");
            $registros=[];
            $i=0;
            foreach($buscarporid as $idrow){
                $registros[$i][0]=$idrow->id;
                $registros[$i][1]=$idrow->NumPart;
                $registros[$i][2]=$idrow->cliente;
                $registros[$i][3]=$idrow->rev;
                $registros[$i][4]=$idrow->wo;
                $registros[$i][5]=$idrow->po;
                $registros[$i][6]=$idrow->Qty;
                $registros[$i][7]=$idrow->donde;
                $registros[$i][8]=$idrow->paro;
                $buscartime=DB::table('timesharn')->select('cut', 'cutF')->where('wo', $idrow->wo)->first();
                    $registros[$i][9]=$buscartime->cut;
                    $registros[$i][10]=$buscartime->cutF;
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
        return view("general",['cat'=>$cat,'value'=>$value,'registros'=>$registros,'week'=>$week,'assit'=>$assit,'paros'=>$paros,'desviations'=>$desviations,'materials'=>$materials]);
    }}
    public function codigo(request $request){
        $cat=session('categoria');
        $value=session('user');
        if($cat=='' OR $value==''){
            return view('login');
        }else{

           $codigo=$request->input('code-bar');
            $todays=date('d-m-Y H:i');
            $buscar=DB::select("SELECT count,wo,donde,NumPart,rev FROM registro WHERE info='$codigo'");
            if (!$buscar) {
                return redirect('general')->with('response', 'Record not found');
            }
            foreach($buscar as $rowb){
            $count=$rowb->count;
            $area=$rowb->donde;
            $pnReg=$rowb->NumPart;
            $rev=$rowb->rev;
            $wo=$rowb->wo;
        }
            $donde='';
            $sesion=session('user');
            $sesionBus = DB::table('login')->select('category')->where('user', $sesion)->limit(1)->first();
            $donde = $sesionBus->category;
            if(($donde==='plan' or $donde==='Admin') and $count===1){
                $count=2;
                $tiempoUp=DB::table('tiempos')->where('info',$codigo)->update(['planeacion'=>$todays]);
                $busqueda = array('2664-GG5A-007','621180','1002707335','1001233873','1001234967','1001333091','910985','910987','91304','90863','90843','90844','910966','911021','91318','60744','60745','91267','910958','91277','90833','910988','910992','90836','91315','920628','40742','90943','910956','40741','91175','91164','910980','910982','90834','910508','91194','90835','91583','910968','910350','910651','911028','91195','910886','910965','910962','910824','910887','910964','910659','40304','91222','91518','91518-1','910957','91135','910974','910577','91138','91221','910792','910978','90841','90842','910908','910910','910444','91525','910981','910967','40601','91211','91682','910621','90798','91517','91516','91681','91133','91212','91224','910975','910325','910347','910907','910909','910979','910326','910960','91137','910511','910821','910940','91139','90839','90877','91223','910400','910410','910955','90837','910953','90840','910678','910914','40199','40200','910971','910399','910969','91165','910661','40488','910972','40640','40599','910411','910913','91177','910973','40639','910954','910348','910650','911022','40602','91162','91163','910666','40600','910951','91176','910349','911024','910984','910702','910580','910784','910952','911023','910983','910970','910581','910733','910785','910976','910579','910701','910601','910611','910977','910610','910598','910786','910959','910609','910608','910961','910597','910600','910599','910536','910820','910664','910735','910512','910513','40747','910912','61522','90838','910911','91136','910390','910668','40801','60977','61615','61820','61821','90860','90886','90942','91132','91134','91143','91144','91145','91171','91173','91203','91232','91233','91278','91279','91305','91306','91307','91308','91309','91313','91314','91317','910324','920040','920041','920042','920043','910327','910439','910440','910441','910442','910443','910509','910510','910515','910516','910564','910568','910578','910585','910586','910596','910622','910637','910654','910655','910656','910657','910658','910662','910663','910665','910674','910679','910788','910832','910939','910963','910989','910990','910991','911025','911026','911027','CTT00002437','146-4448','40297A','CTT00002437');
             if(in_array($pnReg,$busqueda)){
                $update = DB::table('registro')->where('info', $codigo)->update(['count' => 15, 'donde' => 'En espera de Cables Especiales']);
                if ($update) { $resp = "This harness was updated to the next station";
                } else {   $resp = "Harness not updated, it is in $area";  }
                return redirect('general')->with('response', $resp);
            }else { $panel=array('26013301','0031539-104','0032192-70','0032192-175');
            if(in_array($pnReg,$panel)){  $update = DB::table('registro')->where('info', $codigo)->update(['count' => 6, 'donde' => 'En espera de Ensamble']);
                if ($update) { $resp = "This harness was updated to the next station";
                } else {   $resp = "Harness not updated, it is in $area";  }
                return redirect('general')->with('response', $resp);
            }
                $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'En espera de corte']);
                if ($update) { $resp = "This harness was updated to the next station";
                } else {   $resp = "Harness not updated, it is in $area";  }
                return redirect('general')->with('response', $resp); }
            }else if(($donde==='cort' or $donde==='libe') and $count===2){
                $count=3;
                $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'Proceso de corte']);
                if ($update) { $resp = "Cutting process";
                } else {   $resp = "Harness not updated, it is in $area";  }
                return redirect('general')->with('response', $resp);
            }else if(($donde==='libe' or $donde==='cort') and $count===3){
                if(substr($rev,0,4)=='PRIM' or substr($rev,0,4)=='PPAP' ){
                     $buscar=DB::table('timesharn')->select('cut','fecha')->where('bar',$codigo)->first();
                                $lasDate=$buscar->fecha;
                                if($buscar->cut==NULL){
                                    $update = DB::table('timesharn')->where('bar', $codigo)->update(['cut' => $lasDate]);
                                }
                    $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['cutF'=>$todays]);
                    $update = DB::table('registro')->where('info', $codigo)->update(['count' => 17, 'donde' => 'En espera de Ingenieria Corte']);
                    if ($update) { $resp = "Waitting for enginney";
                    } else {   $resp = "Harness not updated, it is in $area";  }
                    return redirect('general')->with('response', $resp);
                }else{
                $count=4;
                $buscar=DB::table('timesharn')->select('cut','fecha')->where('bar',$codigo)->first();
                $lasDate=$buscar->fecha;
                if($buscar->cut==NULL){
                    $update = DB::table('timesharn')->where('bar', $codigo)->update(['cut' => $lasDate]);
                }
                $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['cutF'=>$todays]);
                $tiempoUp=DB::table('tiempos')->where('info',$codigo)->update(['corte'=>$todays]);
                $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'En espera de liberacion']);
                if ($update) { $resp = "This harness was updated to the next station";
                } else {   $resp = "Harness not updated, it is in $area";  }
                return redirect('general')->with('response', $resp);}
            }else if(($donde==='libe' or $donde==='cort') and $count===4){
                    $count=5;
                    $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'Proceso de liberacion']);
                    if ($update) {
                        $buscarinfo=DB::table('registro_pull')->where('wo',substr($wo,2))
                        ->orWhere('wo',$wo)->get();
                        if(count($buscarinfo)<=0){$resp = "Precaution You need to make a Pull Test";}
                        else{$resp = "Terminal Process";}
                    } else {   $resp = "Harness not updated, it is in $area";  }
                    return redirect('general')->with('response', $resp);
            }else if(($donde==='libe' or $donde==='cort') and $count===5){
                    if(substr($rev,0,4)=='PRIM' or substr($rev,0,4)=='PPAP' ){
                        $buscar=DB::table('timesharn')->select('term','cutF')->where('bar',$codigo)->first();
                        $lasDate=$buscar->cutF;
                        if($buscar->term==NULL){
                            $update = DB::table('timesharn')->where('bar', $codigo)->update(['term' => $lasDate]);
                        }
                        $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['termF'=>$todays]);
                        $update = DB::table('registro')->where('info', $codigo)->update(['count' => 16, 'donde' => 'En espera de Ingenieria Liberacion']);
                        if ($update) { $resp = "Waitting for enginney";
                            $buscarinfo=DB::table('registro_pull')->where('wo',substr($wo,2))
                            ->orWhere('wo',$wo)->get();
                            if(count($buscarinfo)<=0){
                            $subject= 'Urgente se necesita pull test para  NP: '.$pnReg.' con Work Order:'.$wo;
                            $date = date('d-m-Y');
                        $time = date('H:i');
                        $content = 'Buen día,'."\n\n".'Les comparto que el día ' . $date . ' a las ' . $time . "\n\n"."Salió de liberacion el"."\n\n";
                $content .= "\n\n"." número de parte: " . $pnReg;
                $content .= "\n\n"." Con Work order: " . $wo;
                $content .= "\n\n"." Se solicita de su apoyo para revisar el motivo por el cual no se realizo la prueba";


                            $recipients = [
                               'jcervera@mx.bergstrominc.com',
                                'vestrada@mx.bergstrominc.com',
                                'egaona@mx.bergstrominc.com',
                                'mvaladez@mx.bergstrominc.com',
                                'jolaes@mx.bergstrominc.com',
                                'lramos@mx.bergstrominc.com',
                                'emedina@mx.bergstrominc.com',
                                'jgarrido@mx.bergstrominc.com',
                                'jlopez@mx.bergstrominc.com',
                                'gonzalez.fast.turn4@outlook.com'

                            ];
                            Mail::to($recipients)->send(new \App\Mail\PPAPING($subject,$content));}
                        } else {   $resp = "Harness not updated, it is in $area";  }
                        return redirect('general')->with('response', $resp);
                    }else{
                    $count=6;
                    $buscar=DB::table('timesharn')->select('term','cutF')->where('bar',$codigo)->first();
                    $lasDate=$buscar->cutF;
                    if($buscar->term==NULL){
                        $update = DB::table('timesharn')->where('bar', $codigo)->update(['term' => $lasDate]);
                    }
                    $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['termF'=>$todays]);
                    $tiempoUp=DB::table('tiempos')->where('info',$codigo)->update(['liberacion'=>$todays]);
                    $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'En espera de ensamble']);
                    if ($update) {
                        $buscarinfo=DB::table('registro_pull')->where('wo',substr($wo,2))
                        ->orWhere('wo',$wo)->get();
                        if(count($buscarinfo)<=0){
                        $subject= 'Urgente se necesita pull test para  NP: '.$pnReg.' con Work Order:'.$wo;
                        $date = date('d-m-Y');
                    $time = date('H:i');
                    $content = 'Buen día,'."\n\n".'Les comparto que el día ' . $date . ' a las ' . $time . "\n\n"."Salió de liberacion el"."\n\n";
            $content .= "\n\n"." número de parte: " . $pnReg;
            $content .= "\n\n"." Con Work order: " . $wo;
            $content .= "\n\n"." Se solicita de su apoyo para revisar el motivo por el cual no se realizo la prueba";


                        $recipients = [
                           'jcervera@mx.bergstrominc.com',
                           'jcrodriguez@mx.bergstrominc.com',
                            'vestrada@mx.bergstrominc.com',
                            'jolaes@mx.bergstrominc.com',
                            'david-villa88@outlook.com',
                            'lramos@mx.bergstrominc.com',
                            'emedina@mx.bergstrominc.com',
                            'jgarrido@mx.bergstrominc.com',
                            'jlopez@mx.bergstrominc.com'


                        ];
                        Mail::to($recipients)->send(new \App\Mail\PPAPING($subject,$content));}
                        $resp = "This harness was updated to the next station";
                    } else { $resp = "Harness not updated, it is in $area";
                    }  return redirect('general')->with('response', $resp);  }
            }else if($donde==='ensa' and $count===6){
                        $count=7;
                        $buscarregistro=DB::table('registro')->select('*')->where("info",$codigo)->get();
                        foreach($buscarregistro as $reg){
                        $np=$reg->NumPart;
                        $cli=$reg->cliente;
                        $woreg=$reg->wo;
                        $poReg=$reg->po;
                        $qtyReg=$reg->Qty;}
                            $calReg=new listaCalidad;
                            $calReg->np=$np;
                            $calReg->client=$cli;
                            $calReg->wo=$woreg;
                            $calReg->po=$poReg;
                            $codigo=strtoupper($codigo);
                            $calReg->info=$codigo;
                            $calReg->qty=$qtyReg;
                            $calReg->parcial="No";
                         if($calReg->save()){
                            $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'Proceso de ensable']);
                        if ($update) { $resp = "Assembly process";
                        } else {   $resp = "Harness not updated, it is in $area";  }
                        return redirect('general')->with('response', $resp);}
                        else{$resp = "Call ENGINNER CI (JORGE)";
                            return redirect('general')->with('response', $resp);
                        }
            } else if($donde==='ensa' and $count===15){
                        $update = DB::table('registro')->where('info', $codigo)->update(['count' => 7, 'donde' => 'Proceso de Cables especiales']);
                        $buscarregistro=DB::table('registro')->select('*')->where("info",$codigo)->limit(1)->get();
                        $reg = $buscarregistro->first();
                        $np=$reg->NumPart;
                        $cli=$reg->cliente;
                        $woreg=$reg->wo;
                        $poReg=$reg->po;
                        $qtyReg=$reg->Qty;
                            $calReg=new listaCalidad;
                            $calReg->np=$np;
                            $calReg->client=$cli;
                            $calReg->wo=$woreg;
                            $calReg->po=$poReg;
                            $calReg->info=$codigo;
                            $calReg->qty=$qtyReg;
                            $calReg->parcial="No";
                            $calReg->save();
                        if ($update) { $resp = "Assembly process";
                        } else {   $resp = "Harness not updated, it is in $area";  }
                        return redirect('general')->with('response', $resp);
            }else if($donde==='ensa' and $count===7){
                        if(substr($rev,0,4)=='PRIM' or substr($rev,0,4)=='PPAP' ){
                            $buscar=DB::table('timesharn')->select('ensa','termF')->where('bar',$codigo)->first();
                            $lasDate=$buscar->termF;
                            if($buscar->ensa==NULL){
                                $update = DB::table('timesharn')->where('bar', $codigo)->update(['ensa' => $lasDate]);
                            }
                            $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['ensaF'=>$todays]);
                            $update = DB::table('registro')->where('info', $codigo)->update(['count' => 13, 'donde' => 'En espera de Ingenieria ensamble']);
                            if ($update) { $resp = "Waitting for enginney";
                            } else {   $resp = "Harness not updated, it is in $area";  }
                            return redirect('general')->with('response', $resp);
                        }else{
                        $count=8;
                        $buscar=DB::table('timesharn')->select('ensa','termF')->where('bar',$codigo)->first();
                        $lasDate=$buscar->termF;
                        if($buscar->ensa==NULL){
                            $update = DB::table('timesharn')->where('bar', $codigo)->update(['ensa' => $lasDate]);
                        }
                        $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['ensaF'=>$todays]);
                        $tiempoUp=DB::table('tiempos')->where('info',$codigo)->update(['ensamble'=>$todays]);
                        $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'En espera de loom']);
                        if ($update) { $resp = "This harness was updated to the next station";
                        } else {   $resp = "Harness not updated, it is in $area";  }
                        return redirect('general')->with('response', $resp);
                      }
            }else if($donde==='loom' and $count===8){
                            $count=9;
                            $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'Proceso de loom']);
                            if ($update) { $resp = "Looming process";
                            } else {   $resp = "Harness not updated, it is in $area";  }
                            return redirect('general')->with('response', $resp);
            } else if($donde==='loom' and $count===9){
                            if(substr($rev,0,4)=='PRIM' or substr($rev,0,4)=='PPAP' ){
                                $buscar=DB::table('timesharn')->select('loom','ensaF')->where('bar',$codigo)->first();
                                $lasDate=$buscar->ensaF;
                                if($buscar->loom==NULL){
                                    $update = DB::table('timesharn')->where('bar', $codigo)->update(['loom' => $lasDate]);
                                }
                                $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['loomF'=>$todays]);
                                $update = DB::table('registro')->where('info', $codigo)->update(['count' => 14, 'donde' => 'En espera de Ingenieria Loom']);
                                if ($update) { $resp = "Waitting for enginney";
                                } else {   $resp = "Harness not updated, it is in $area";  }
                                return redirect('general')->with('response', $resp);
                            }else{

                                $buscarcalidad=DB::table('calidad')->where("info",$codigo)->first();
                                if($buscarcalidad){
                                    $count=10;
                                    $buscar=DB::table('timesharn')->select('loom','ensaF')->where('bar',$codigo)->first();
                                $lasDate=$buscar->ensaF;
                                if($buscar->loom==NULL){
                                    $update = DB::table('timesharn')->where('bar', $codigo)->update(['loom' => $lasDate]);
                                }
                                    $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['loomF'=>$todays]);
                                    $tiempoUp=DB::table('tiempos')->where('info',$codigo)->update(['loom'=>$todays]);
                                    $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'En espera de prueba electrica']);
                                    if ($update) { $resp = "This harness was updated to the next station";
                                    } else {   $resp = "Harness not updated, it is in $area";  }
                                    return redirect('general')->with('response', $resp);
                                 }else{
                                $buscarregistro=DB::table('registro')->select('*')->where("info",$codigo)->get();
                                foreach($buscarregistro as $reg){
                                $np=$reg->NumPart;
                                $cli=$reg->cliente;
                                $woreg=$reg->wo;
                                $poReg=$reg->po;
                                $qtyReg=$reg->Qty;}
                                    $calReg=new listaCalidad;
                                    $calReg->np=$np;
                                    $calReg->client=$cli;
                                    $calReg->wo=$woreg;
                                    $calReg->po=$poReg;
                                    $codigo=strtoupper($codigo);
                                    $calReg->info=$codigo;
                                    $calReg->qty=$qtyReg;
                                    $calReg->parcial="No";
                                 if($calReg->save()){
                            $count=10;
                            $buscar=DB::table('timesharn')->select('loom','ensaF')->where('bar',$codigo)->first();
                                $lasDate=$buscar->ensaF;
                                if($buscar->loom==NULL){
                                    $update = DB::table('timesharn')->where('bar', $codigo)->update(['loom' => $lasDate]);
                                }
                            $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['loomF'=>$todays]);
                            $tiempoUp=DB::table('tiempos')->where('info',$codigo)->update(['loom'=>$todays]);
                            $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'En espera de prueba electrica']);
                            if ($update) { $resp = "This harness was updated to the next station";
                            } else {   $resp = "Harness not updated, it is in $area";  }
                            return redirect('general')->with('response', $resp);  }else{
                                $resp = "Contact to CI(Jorge)";
                                return redirect('general')->with('response', $resp);
                            }

                        }}
                }else if($donde==='cali' and $count===10){
                                $count=11;
                                $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'Proceso de corte']);
                                if ($update) { $resp = "Testing process";
                                } else {   $resp = "Harness not updated, it is in $area";  }
                                return redirect('general')->with('response', $resp);
                } else if($donde==='cali' and $count===11){
                                if(substr($rev,0,4)=='PRIM' or substr($rev,0,4)=='PPAP' ){
                                    $buscar=DB::table('timesharn')->select('qly','loomF')->where('bar',$codigo)->first();
                                $lasDate=$buscar->loomF;
                                if($buscar->qly==NULL){
                                    $update = DB::table('timesharn')->where('bar', $codigo)->update(['qly' => $lasDate]);
                                }
                                    $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['qlyF'=>$todays,'emba'=>$todays]);
                                    $update = DB::table('registro')->where('info', $codigo)->update(['count' => 18, 'donde' => 'En espera de Ingenieria Prueba Electrica']);
                                    if ($update) { $resp = "Waitting for enginney";
                                    } else {   $resp = "Harness not updated, it is in $area";  }
                                    return redirect('general')->with('response', $resp);
                                }else{
                                $count=12;
                                $buscar=DB::table('timesharn')->select('qly','loomF')->where('bar',$codigo)->first();
                                $lasDate=$buscar->loomF;
                                if($buscar->qly==NULL){
                                    $update = DB::table('timesharn')->where('bar', $codigo)->update(['qly' => $lasDate]);
                                }
                                $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['qlyF'=>$todays,'emba'=>$todays]);
                                $tiempoUp=DB::table('tiempos')->where('info',$codigo)->update(['calidad'=>$todays]);
                                $update = DB::table('registro')->where('info', $codigo)->update(['count' => $count, 'donde' => 'En espera de embarque']);
                                if ($update) { $resp = "This harness was updated to the next station";
                                } else {   $resp = "Harness not updated, it is in $area";  }
                                return redirect('general')->with('response', $resp); }
                }else if($donde==='emba' and $count===12){
                                $tiempoUp=DB::table('tiempos')->where('info',$codigo)->update(['embarque'=>$todays]);
                                $updatetime=DB::table('timesharn')->where('bar',$codigo)->update(['embaF'=>$todays]);
                                    $update = DB::table('registro')->where('info', $codigo)->update(['count' => '20', 'donde' => 'Proceso de embarque']);
                                    if ($update) { $resp = "Shipped";
                                    } else {   $resp = "Harness not updated, it is in $area";  }
                                    return redirect('general')->with('response', $resp);
                } $resp = "Harness not updated, it is in $area";
                return redirect('general')->with('response', $resp);

    }
}
    public function Bom(Request $request){
        $boms = $request->input('partnum');
        $value=session('user');
        if($value=='Angel_G'){
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
            'inimant'=>$today,
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
        $cat=session('categoria');
        $tiempo=date('d-m-Y H:i');
        $id_Cominezo=$request->input('id_butC');
        if(!empty($id_Cominezo)){
            switch($cat){
                case 'cort':
                    $update=DB::table('timesharn')->where('wo','=',$id_Cominezo)->update(['cort'=>$tiempo]);
                    break;
                case 'ensa':
                    $update=DB::table('timesharn')->where('wo','=',$id_Cominezo)->update(['ensa'=>$tiempo]);

                    break;
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
    }
        }
        if(!empty($id) && $funcion=="pausar"){
            switch($cat){
                case 'cort':
                    $update=DB::table('timesharn')->where('wo','=',$id)->update(['cortF'=>$tiempo]);
                    break;
                case 'ensa':
                    $update=DB::table('timesharn')->where('wo','=',$id)->update(['ensaF'=>$tiempo]);
                    break;
                case 'libe':
                    $update=DB::table('timesharn')->where('wo','=',$id)->update(['termF'=>$tiempo]);
                    break;
                case 'loom':
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['loomF'=>$tiempo]);
            case 'cali':
                $update=DB::table('timesharn')->where('wo','=',$id)->update(['qlyF'=>$tiempo]);
                break;
            case 'emba':
        $update=DB::table('timesharn')->where('wo','=',$id)->update(['embaF'=>$tiempo]);
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
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['cut'=>$newTime,'cortF'=>'']);
            break;
        case 'ensa':
            $select=DB::table('timesharn')->where( 'wo','=',$id)->first();
            $ini=$select->ensa;
            $fin=$select->ensaF;
            $tiempodiff=strtotime($fin) - strtotime($ini);
            $newTime=date('d-m-Y h:i',(strtotime($tiempo)-$tiempodiff));
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['ensa'=>$newTime,'ensaF'=>'']);
            break;
        case 'libe':
            $select=DB::table('timesharn')->where( 'wo','=',$id)->first();
            $ini=$select->term;
            $fin=$select->termF;
            $tiempodiff=strtotime($fin) - strtotime($ini);
            $newTime=date('d-m-Y h:i',(strtotime($tiempo)-$tiempodiff));
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['term'=>$newTime,'termF'=>'']);
            break;
        case 'loom':
            $select=DB::table('timesharn')->where( 'wo','=',$id)->first();
            $ini=$select->loom;
            $fin=$select->loomF;
            $tiempodiff=strtotime($fin) - strtotime($ini);
            $newTime=date('d-m-Y h:i',(strtotime($tiempo)-$tiempodiff));
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['loom'=>$newTime,'loomF'=>'']);
    case 'cali':
        $select=DB::table('timesharn')->where( 'wo','=',$id)->first();
            $ini=$select->qly;
            $fin=$select->qlyF;
            $tiempodiff=strtotime($fin) - strtotime($ini);
            $newTime=date('d-m-Y h:i',(strtotime($tiempo)-$tiempodiff));
            $update=DB::table('timesharn')->where('wo','=',$id)->update(['qly'=>$newTime,'qlyF'=>'']);
        break;
    case 'emba':
        $select=DB::table('timesharn')->where( 'wo','=',$id)->first();
        $ini=$select->emba;
        $fin=$select->embaF;
        $tiempodiff=strtotime($fin) - strtotime($ini);
        $newTime=date('d-m-Y h:i',(strtotime($tiempo)-$tiempodiff));
        $update=DB::table('timesharn')->where('wo','=',$id)->update(['emba'=>$newTime,'embaF'=>'']);
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

}

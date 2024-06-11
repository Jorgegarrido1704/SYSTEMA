<?php

namespace App\Http\Controllers;

use App\Models\ingAct;
use App\Models\PPAPandPRIM;
use App\Models\ppapIng;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables;
use App\Models\listaCalidad;

class PpapIngController extends Controller
{

    public function __invoke()
    {
            $value=session('user');
            $cat=session('categoria');
            if($cat==''){return view('login'); }else if($cat!='inge'){ return view('login');}else{
        $i=0;
        $inges=[];
        $activ=[];
        $answer=[];
        $buscarinfor=DB::table('registro')->select("*")->where('count','=','13')
        ->orwhere('count','=','17')->orwhere('count','=','14')->orwhere('count','=','16')
        ->orwhere('count','=','18')->get();
        foreach($buscarinfor as $rowInge){
            $inges[$i][0]=$rowInge->NumPart;
            $inges[$i][1]=$rowInge->cliente;
            $inges[$i][2]=$rowInge->rev;
            $inges[$i][3]=$rowInge->wo;
            $inges[$i][4]=$rowInge->po;
            $inges[$i][5]=$rowInge->Qty;
            $inges[$i][6]=$rowInge->id;
            $inges[$i][7]=$rowInge->count;
            $inges[$i][8]=$rowInge->info;
        $i++;        }
        $i=0;
        $SearchAct=DB::table('ingactividades')->select("*")->where('count','<','4')->get();
        foreach($SearchAct as $rowAct){
            $enginners[$i][0]=$rowAct->id;
            $enginners[$i][1]=$rowAct->Id_request;
            $control=strtotime($rowAct->fecha);
            $dateControl=strtotime(date('d-m-Y H:i'));
            $controlTotal=round((($dateControl-$control)/60/60),2)." Horas";

            $enginners[$i][2]=$controlTotal;
            $enginners[$i][3]=$rowAct->actividades;
            $enginners[$i][4]=$rowAct->desciption;
            $enginners[$i][5]=$rowAct->fechaEncuesta;
            $i++;
        }
$i=0;
        $busarResp=DB::table('ppapandprim')->where('count','<','2')->get();
        foreach($busarResp as $respPPAP){
        $answer[$i][0]=$respPPAP->tp;
        $answer[$i][1]=$respPPAP->client;
        $answer[$i][2]=$respPPAP->pn;
        $answer[$i][3]=$respPPAP->REV1;
        $answer[$i][4]=$respPPAP->REV2;
        $answer[$i][5]=$respPPAP->cambios;
        $answer[$i][6]=$respPPAP->fecha;
        $answer[$i][7]=$respPPAP->eng;
        $answer[$i][8]=$respPPAP->quality;
        $answer[$i][9]=$respPPAP->ime;
        $answer[$i][10]=$respPPAP->test;
        $answer[$i][11]=$respPPAP->production;
        $answer[$i][12]=$respPPAP->compras;
        $answer[$i][13]=$respPPAP->gernete;
        $i++;
        }



        return view('/ing',['cat'=>$cat,'inges'=>$inges,'value'=>$value,'enginners'=>$enginners,'answer'=>$answer]);    }

}
    public function create()
    {
        //
    }
    public function store(Request $request)    {
        $value=session('user');
        $idIng=$request->input('iding');
        $cuenta=$request->input('count');
        $info=$request->input('info');
        $today=date('d-m-Y H:i');

        if($cuenta==17){$count=4; $donde='En espera de liberacion';$area='Corte';
            $updateTiempo=DB::table('tiempos')->where('info',$info)->update(['corte'=>$today]);
            $updateInge=DB::table('registro')->where('id','=',$idIng)->update(['count'=>$count,'donde'=>$donde]);
            $regIng=new ppapIng;
        $regIng->info=$info;
        $regIng->fecha=$today;
        $regIng->codigo=$value;
        $regIng->area=$area;
        $regIng->save();
            return redirect('/ing');
        }else if($cuenta==14){
            //Registrar a calidad..
            $buscarReg=DB::table('registro')->where('info','=',$info)->first();
            $np=$buscarReg->NumPart;
            $cli=$buscarReg->cliente;
            $woreg=$buscarReg->wo;
            $poReg=$buscarReg->po;
            $qtyReg=$buscarReg->Qty;
            $calReg=new listaCalidad;
            $calReg->np=$np;
            $calReg->client=$cli;
            $calReg->wo=$woreg;
            $calReg->po=$poReg;
            $codigo=strtoupper($info);
            $calReg->info=$codigo;
            $calReg->qty=$qtyReg;
            $calReg->parcial="No";
            $calReg->save();
                $count=10;$donde='En espera de prueba electrica';$area='loom';
                $updateInge=DB::table('registro')->where('id','=',$idIng)->update(['count'=>$count,'donde'=>$donde]);
                $regIng=new ppapIng;
        $regIng->info=$info;
        $regIng->fecha=$today;
        $regIng->codigo=$value;
        $regIng->area=$area;
        $regIng->save();
        return redirect('/ing');
        }else if($cuenta==13){$count=8;$donde='En espera de loom';$area='Ensamble';
            $updateTiempo=DB::table('tiempos')->where('info',$info)->update(['ensamble'=>$today]);
            $updateInge=DB::table('registro')->where('id','=',$idIng)->update(['count'=>$count,'donde'=>$donde]);
            $regIng=new ppapIng;
        $regIng->info=$info;
        $regIng->fecha=$today;
        $regIng->codigo=$value;
        $regIng->area=$area;
        $regIng->save();
            return redirect('/ing');
        }else if($cuenta==16){$count=6;$donde='En espera de ensamble';$area='Libreracion';
            $updateTiempo=DB::table('tiempos')->where('info',$info)->update(['liberacion'=>$today]);
            $updateInge=DB::table('registro')->where('id','=',$idIng)->update(['count'=>$count,'donde'=>$donde]);
            $regIng=new ppapIng;
        $regIng->info=$info;
        $regIng->fecha=$today;
        $regIng->codigo=$value;
        $regIng->area=$area;
        $regIng->save();
            return redirect('/ing');
        }else if($cuenta==18){$count=12;$donde='En espera de embarque';$area='Prueba electrica';
            $buscarinfo=DB::table('registro')->where('info',$info)->first();
            $revin=substr($buscarinfo->rev,0,4);
            $emailcliente=$buscarinfo->cliente;
            $emailpn=$buscarinfo->NumPart;
            $revf=substr($buscarinfo->rev,4);
            $emailwo=$buscarinfo->wo;
            $emailpo=$buscarinfo->po;
            $emailQty=$buscarinfo->Qty;
            $messageData = [
                'revin' => $revin,
                'emailcliente' => $emailcliente,
                'emailpn' => $emailpn,
                'revf' => $revf,
                'emailwo' => $emailwo,
                'emailpo' => $emailpo,
                'emailQty' => $emailQty,
                // Add any other necessary data here
            ];
            $subject= $revin.' PRUEBA ELECTRICA  '.$emailcliente.' NP '.$emailpn.' en REV '.$revf;
            $date = date('d-m-Y');
        $time = date('H:i');

        $content =  $revin . ' liberada y en embarque '."\n\n";
        $content .= 'Buen día,'."\n\n".'Les comparto que el día ' . $date . ' a las ' . $time . "\n\n"."Salió de prueba la siguiente PPAP:"."\n\n";
$content .= "\n\n"." Cliente: " . $emailcliente;
$content .= "\n\n"." Número de parte: " . $emailpn;
$content .= "\n\n"." PPAP en revisión: " . $revf;
$content .= "\n\n"." Con Work order: " . $emailwo;
$content .= "\n\n"." Con Sono order: " . $emailpo;
$content .= "\n\n"." Por la cantidad de: " . $emailQty;
$content .= "\n\n"." Con las siguientes anotaciones:";
$calidad=DB::table('regsitrocalidad')->where('info',$info)->get();
foreach($calidad as $regcal){

    $content .= "<br>".$regcal->codigo;
}

            $recipients = [
                'jcervera@mx.bergstrominc.com',

                'jcrodriguez@mx.bergstrominc.com',
                'egaona@mx.bergstrominc.com',
                'mvaladez@mx.bergstrominc.com',
                'david-villa88@outlook.com',
                'jolaes@mx.bergstrominc.com',
                'lramos@mx.bergstrominc.com',
                'emedina@mx.bergstrominc.com'

            ];
            Mail::to($recipients)->send(new \App\Mail\PPAPING($subject,$content));

        }

        $regIng=new ppapIng;
        $regIng->info=$info;
        $regIng->fecha=$today;
        $regIng->codigo=$value;
        $regIng->area=$area;
        $regIng->save();
        $updateInge=DB::table('registro')->where('id','=',$idIng)->update(['count'=>$count,'donde'=>$donde]);
        return redirect('/ing');
    }


    public function action(Request $request){
        $id=$request->input('id');
        $todayIng=date('d-m-Y H:i');
        $id_f=$request->input('id_f');

        if(!empty($id)){
        $buscarIng=DB::table('ingactividades')->where('id',$id)->first();
        if($buscarIng->fechaEncuesta!='pausado'){
        $upIng=DB::table('ingactividades')->where('id',$id)->update(['finT'=>$todayIng,'fechaEncuesta'=>'pausado']);
        }else if($buscarIng->fechaEncuesta=='pausado'){
            $tiempoFin=strtotime($buscarIng->finT);
            $tiempoIni=strtotime($buscarIng->fecha);
            $tiempo=$tiempoFin-$tiempoIni;
            $tiempoactual=strtotime($todayIng);
            $tiempoTotal=$tiempoactual-$tiempo;
            $resto=date('d-m-Y H:i', $tiempoTotal);
            $upIng=DB::table('ingactividades')->where('id',$id)->update(['finT'=>'','fechaEncuesta'=>'','fecha'=>$resto]);

        }
       return redirect ('/ing');
    }else if(!empty($id_f)){
        $buscarFin=DB::table('ingactividades')->where('id',$id_f)->first();
        if($buscarFin){
        $upIng=DB::table('ingactividades')->where('id',$id_f)->update(['finT'=>$todayIng,'fechaEncuesta'=>'finalizado','count'=>4]);

        return redirect ('/ing');}
    }
}
    public function tareas(Request $request){

        $activiad=$request->input('act');
        $desc=$request->input('info');
        $eng=$request->input('Inge');
        $today=date('d-m-Y H:i');
        $regIng=new ingAct;
        $regIng->Id_request=$eng;
        $regIng->fecha=$today;
        $regIng->finT='';
        $regIng->actividades=$activiad;
        $regIng->desciption=$desc;
        $regIng->count=0;
        $regIng->analisisPlano='';
        $regIng->bom='';
        $regIng->AyudasVizuales='';
        $regIng->bomRmp='';
        $regIng->fullSize='';
        $regIng->fechaEncuesta='';
        $regIng->listaCort='';
        if($regIng->save()){
            return redirect ('/ing');
        }
    }

    public function REgPPAP(Request $request){
        $tipo=$request->input('Tipo');
        $client=$request->input('Client');
        $tipoA=$request->input('tipoArnes');
        $pn=$request->input('pn');
        $rev1=$request->input('rev1');
        $rev2=$request->input('rev2');
        $cambios=$request->input('cambios');
        $eng=$request->input('quien');
        $today=date('d-m-Y H:i');
      $buscarIguales=DB::table('ppapandprim')->where('pn',$pn)->where('REV1',$rev1)->where('REV2',$rev2)->first();
      if($buscarIguales){
        return redirect('/ing')->with('error','Ya existe esta Revision');
      }else{


        if($tipo=='PPAP'){
            $tp='NUEVA PPAP (Hoja Verde)';
        }else if($tipo=='PRIM'){
            $tp='LiberacionPrimeraPieza (Hoja Amarilla)';
        }else if ($tipo=='NO PPAP') {
            $tp='NO PPAP';
        }else  if($tipo=='Change PPAP'){
            $tp='Cambio REV PPAP (Hoja Verde)';
        }else if($tipo=='Change PRIM'){
            $tp='Cambio REV PrimeraPieza (Hoja Amarilla)';
        }
        $registro= new PPAPandPRIM;
        $registro->tp=$tp;
        $registro->client=$client;
        $registro->tipo=$tipoA;
        $registro->pn=$pn;
        $registro->REV1=$rev1;
        $registro->REV2=$rev2;
        $registro->cambios=$cambios;
        $registro->fecha=$today;
        $registro->eng=$eng;
        $registro->quality='';
        $registro->ime='';
        $registro->test='';
        $registro->production='';
        $registro->compras='';
        $registro->gernete='';
        $registro->count=0;
        if($registro->save()){
            return redirect ('/ing');
    }
}
    }
}

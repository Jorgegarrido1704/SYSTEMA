<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\accionesCorrectivas;
use App\Mail\accionesCorrectivasRecordatorio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\PPAPandPRIM;
use App\Mail\firmasCompletas;
use App\Models\workScreduleModel ;
use App\Models\desviation;
use App\Mail\desviacionesEmails;
use App\Models\registroVacacionesModel;

class mailsController extends Controller
{
    public function accionesCorrectivas()
    {
        $accion = accionesCorrectivas::where('status', 'etapa 2 - Accion Correctiva')
            ->first();
        return view('emails.accionesCorrectivasMail', ['accion' => $accion]);
    }
    public function firmasNPI(){
        $accion = PPAPandPRIM::where('count','=',0)->orderby('id','desc')->first();
        return view('emails.firmasNPIMail', ['accion' => $accion]);
    }

    public function index(){
        $value = session('user');
        $cat=session('categoria');
        if($value=='Rocio F' or $value=='Fatima S' ){
        $registroFirmas=PPAPandPRIM::where('count','=',1)->where('ime','=','')->orderby('id','desc')->get();
        }else if($value=='Edward M' or $value=='Luis R' or $value=='Goretti Ro'){
            $registroFirmas=PPAPandPRIM::where('count','=',1)->where('quality','=','')->orderby('id','desc')->get();
        }else if($value=='Jose Luis' ){
            $registroFirmas=PPAPandPRIM::where('count','=',1)->where('test','=','')->orderby('id','desc')->get();
        }else if($value=='Valeria P' Or $value=='Julio R' ){
             $registroFirmas=PPAPandPRIM::where('count','=',1)->where('compras','=','')->orderby('id','desc')->get();
        }else if($value=='Juan O' or $value=='David V'){
            $registroFirmas=PPAPandPRIM::where('count','=',1)->where('production','=','')->orderby('id','desc')->get();
        }else if($value== 'Estela G' or $value=='Gamboa J'){
            $registroFirmas=PPAPandPRIM::where('count','=',1)->where('gernete','=','')->orderby('id','desc')->get();
        }
        else {
            $registroFirmas=[];
        }
        if($value=='Jesus_C' or $value=='Carlos R' or $value=='Nancy A' or $value=='Admin' or $value=='Jorge G'){
            $desviations=desviation::Where('fing','=','')->where('count','<',4)->get();
        }else if($value=='Edward M' or $value=='Luis R' or $value=='Goretti Ro'){
            $desviations=desviation::Where('fing','!=','')->where('fcal','=','')->where('count','<',4)->get();
        }else {
            $desviations=[];
        }
        if($value=='Admin' or $value=='Juan G'){
            $vacaciones=registroVacacionesModel::where('estatus','=','Pendiente')->get();

        }elseif($value=='Paola A' or $value=='Angy B'){
            $vacaciones=registroVacacionesModel::where('estatus','=','Pendiente RH')->get();
        }else{
            $vacaciones=[];
        }
        


        return view('firmas.npi.npi', ['vacaciones' => $vacaciones,'desviations' => $desviations,'registroFirmas' => $registroFirmas,'value' => $value, 'cat' => $cat]);
    }

    public function update(Request $request){
        $id=$request->input('id');
        $value=session('user');
         if($value=='Rocio F' or $value=='Fatima S' ){
        PPAPandPRIM::where('id','=',$id)->update(['ime' => carbon::now()->format('d-m-y H:i')]);
        }else if($value=='Edward M' or $value=='Luis R' or $value=='Goretti Ro'){
            PPAPandPRIM::where('id','=',$id)->update(['quality' => carbon::now()->format('d-m-y H:i')]);
        }else if($value=='Jose Luis' ){
            PPAPandPRIM::where('id','=',$id)->update(['test' => carbon::now()->format('d-m-y H:i')]);
        }else if($value=='Valeria P' Or $value=='Julio R' ){
             PPAPandPRIM::where('id','=',$id)->update(['compras' => carbon::now()->format('d-m-y H:i')]);
        }else if($value=='Juan O' or $value=='David V'){
            PPAPandPRIM::where('id','=',$id)->update(['production' => carbon::now()->format('d-m-y H:i')]);
        }else if($value== 'Estela G' or $value=='Gamboa J'){
            PPAPandPRIM::where('id','=',$id)->update(['gernete' => carbon::now()->format('d-m-y H:i')]);
        }
        if(PPAPandPRIM::where('id','=',$id)->where('ime','!=','')->where('quality','!=','')->where('test','!=','')->where('compras','!=','')->where('production','!=','')->where('gernete','!=','')->update(['count' => 2])){
           $accion = PPAPandPRIM::where('id','=',$id)->first();
           $receivers=['jcervera@mx.bergstrominc.com','jamoreno@mx.bergstrominc.com','jgarrido@mx.bergstrominc.com',
           'jcrodriguez@mx.bergstrominc.com'];
            workScreduleModel::where('pn','=',$accion->pn)->orderby('id','desc')->first()->update(['documentsApproved' => carbon::now()->format('Y-m-d')]);

            Mail::to($receivers )->send(new firmasCompletas($accion,'Firmas Completas NPI'));
        }
        return redirect('/Pendigs');

    }

    public function desviationUpdate(Request $request){
        $input=$request->validate([
            'id' => 'required|integer',
            'who'=>'required|string|max:12',
        ]);
        $id=$input['id'];
        $who=$input['who'];
        if($who=='Edward M' or $who=='Luis R' or $who=='Goretti Ro'){
             desviation::where('id','=',$id)->update(['fcal' => carbon::now()->format('d-m-y H:i'),'count' => 4]);
            $accion= desviation::where('id','=',$id)->first();
            $receivers=['jcervera@mx.bergstrominc.com','jamoreno@mx.bergstrominc.com','jgarrido@mx.bergstrominc.com',
            'apacheco@mx.bergstrominc.com','jcrodriguez@mx.bergstrominc.com','lramos@mx.bergstrominc.com','emedina@mx.bergstrominc.com',
            'drocha@mx.bergstrominc.com','enunez@mx.bergstrominc.com','fsuarez@mx.bergstrominc.com','rfandino@mx.bergstrominc.com',
            'vpichardo@mx.bergstrominc.com','dflores@mx.bergstrominc.com','jrodriguez@mx.bergstrominc.com','jgamboa@mx.bergstrominc.com',
            'jguillen@mx.bergstrominc.com'];
            Mail::to($receivers)->send(new desviacionesEmails($accion,'Desviacion aprobada'));
        }else  if($who=='Jesus_C' or $who=='Carlos R' or $who=='Nancy A' or $who=='Admin' or $who=='Jorge G'){
            desviation::where('id','=',$id)->update(['fing' => carbon::now()->format('d-m-y H:i')]);
        }

        return redirect('/Pendigs');
    }
    public function desviationDenied(Request $request){

        $idq=$request->input('idq');
        $rechaso=$request->input('rechaso');
         $receivers=['jcervera@mx.bergstrominc.com','jamoreno@mx.bergstrominc.com','jgarrido@mx.bergstrominc.com',
            'apacheco@mx.bergstrominc.com','jcrodriguez@mx.bergstrominc.com','lramos@mx.bergstrominc.com','emedina@mx.bergstrominc.com',
            'drocha@mx.bergstrominc.com','enunez@mx.bergstrominc.com','fsuarez@mx.bergstrominc.com','rfandino@mx.bergstrominc.com',
            'vpichardo@mx.bergstrominc.com','dflores@mx.bergstrominc.com','jrodriguez@mx.bergstrominc.com','jgamboa@mx.bergstrominc.com',
            'jguillen@mx.bergstrominc.com'];
        desviation::where('id','=',$idq)->update(['fing' => carbon::now()->format('d-m-y H:i'),'fcal' => carbon::now()->format('d-m-y H:i'),'count' => 5,'rechazo' => $rechaso]);
        $accion= desviation::where('id','=',$idq)->first();
        Mail::to($receivers)->send(new desviacionesEmails($accion,'Desviacion Rechazada  '));

        return redirect('/Pendigs');
    }

    public function vacacionesUpdate(Request $request){
        $id=$request->input('id');
        $datos=$request->input('datos');
        $value=session('user');
         if($value=='Admin' or $value=='Juan G'){
        registroVacacionesModel::where('id','=',$id)->update(['estatus' => 'Pendiente RH']);
        }else if($value=='Paola A' or $value=='Angy B'){
            registroVacacionesModel::where('id','=',$id)->update(['estatus' => 'Confirmado']);
        }
        return redirect('/Pendigs');
    }

}

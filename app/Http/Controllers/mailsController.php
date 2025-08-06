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
        if($value=='Rocio F' ){
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
        return view('firmas.npi.npi', ['registroFirmas' => $registroFirmas,'value' => $value, 'cat' => $cat]);
    }

    public function update(Request $request){
        $id=$request->input('id');
        $value=session('user');
         if($value=='Rocio F' ){
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

            //$accion = PPAPandPRIM::where('id','=',$id)->first();
          //  Mail::to($accion->email)->send(new accionesCorrectivasRecordatorio($accion));
        }
        return redirect('/Pendigs');

    }



}


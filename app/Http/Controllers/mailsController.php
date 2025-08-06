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
        $registroFirmas=PPAPandPRIM::where('count','=',1)->orderby('id','desc')->first();
        }else {
            $registroFirmas=[];
        }
        return view('firmas.npi.npi', ['registroFirmas' => $registroFirmas,'value' => $value, 'cat' => $cat]);
    }



}

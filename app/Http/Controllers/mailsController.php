<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\accionesCorrectivas;
use Carbon\Carbon;

class mailsController extends Controller
{
    public function accionesCorrectivas()
    {
        $accionesCorrectivas = accionesCorrectivas::where('status', 'etapa 2 - Accion Correctiva')
       ->where('email', '!=', carbon::now())->first();

        return view('emails.accionesCorrectivasMail',['accion' => $accionesCorrectivas]);
    }



}

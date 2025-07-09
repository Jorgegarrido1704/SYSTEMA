<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\accionesCorrectivas;
use App\Mail\accionesCorrectivasRecordatorio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class mailsController extends Controller
{
    public function accionesCorrectivas()
    {
        $accion = accionesCorrectivas::where('status', 'etapa 2 - Accion Correctiva')
            ->whereNotNull('email')
            ->first();

        if ($accion) {
            Mail::to($accion->email)->send(new accionesCorrectivasRecordatorio($accion));
        }

        return view('emails.accionesCorrectivasMail', ['accion' => $accion]);
    }



}

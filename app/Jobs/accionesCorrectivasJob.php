<?php

namespace App\Jobs;

use App\Mail\accionesCorrectivasRecordatorio;
use App\Models\accionesCorrectivas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class accionesCorrectivasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        $acciones = accionesCorrectivas::where('status', 'etapa 1 - inicio')
            ->first();
        $mailto = personalBergsModel::where('employeeName', $acciones->resposableAccion)->first();
        if ($mailto) {
            $mailaddress = $mailto->email;
        } else {
            $mailaddress = 'jgarrido@mx.bergstrominc.com';
        }
        $mailaddress = 'jgarrido@mx.bergstrominc.com';

        Mail::to($mailaddress)->send(new accionesCorrectivasRecordatorio($acciones, 'Acciones Correctivas Recordatorio'));

    }
}

<?php

namespace App\Jobs;

use App\Mail\accionesCorrectivas\contencion;
use App\Mail\accionesCorrectivasRecordatorio;
use App\Models\accionesCorrectivas;
use App\Models\personalBergsModel;
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
        $accioness = accionesCorrectivas::where('status', '!=', 'finalizada')
            ->get();

        foreach ($accioness as $acciones) {
            $mailaddress = 'jgarrido@mx.bergstrominc.com,maleman@mx.bergstrominc.com';
            $mailto = personalBergsModel::where('employeeName', $acciones->resposableAccion)->first();
            if ($mailto) {
                $mailaddress .= ','.$mailto->email;
            }
            if ($acciones->status == 'etapa 1 - inicio') {
                Mail::to($mailaddress)->send(new accionesCorrectivasRecordatorio($acciones, 'Acciones Correctivas Recordatorio'));
            } elseif ($acciones->status == 'etapa 1 - Contención') {
                Mail::to($mailaddress)->send(new contencion('Acciones Correctivas Contencion', $acciones));
            }
        }

    }
}

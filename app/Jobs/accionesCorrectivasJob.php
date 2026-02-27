<?php

namespace App\Jobs;

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
            $mailto = personalBergsModel::where('employeeName', $acciones->resposableAccion)->first();
            $mailaddress = [
                'jgarrido@mx.bergstrominc.com',
                'maleman@mx.bergstrominc.com',
            ];
            if ($mailto) {
                $mailaddress[] = $mailto->email;
            }
            if (Carbon) {
                if (strpos($acciones->status, 'etapa 1') !== false) {
                    Mail::to($mailaddress)->send(new recordatorio($acciones, ' Recordatorio "Acciones Correctivas"'));
                }
            }
        }

    }
}

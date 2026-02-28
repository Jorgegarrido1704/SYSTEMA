<?php

namespace App\Jobs;

use App\Mail\pruebasElectricas\recordatorio;
use App\Models\accionesCorrectivas;
use App\Models\personalBergsModel;
use Carbon\Carbon;
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
        $accioness = accionesCorrectivas::where('status', 'LIKE', 'etapa 1%')
            ->get();

        foreach ($accioness as $acciones) {
            $mailto = personalBergsModel::select('email', 'employeeLider')->where('employeeName', $acciones->resposableAccion)->first();
            $mailaddress = [
                'jgarrido@mx.bergstrominc.com',
                'maleman@mx.bergstrominc.com',
            ];
            if ($mailto) {
                $mailaddress[] = $mailto->email;
            }

            if (Carbon::parse($acciones->fechaAccion)->addWeekDays(2)->isPast()) {
                $leaderMailto = personalBergsModel::select('email')->where('employeeName', $mailto->employeeLider)->first();
                if ($leaderMailto) {
                    $mailaddress[] = $leaderMailto->email;
                }

            }

            Mail::to($mailaddress)->send(new recordatorio($acciones, ' Recordatorio "Acciones Correctivas"'));
        }
    }
}

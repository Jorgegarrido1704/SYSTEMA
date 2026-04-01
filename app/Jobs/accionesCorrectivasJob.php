<?php

namespace App\Jobs;

use App\Mail\accionesCorrectivas\recordatorio;
use App\Mail\accionesCorrectivas\recordatorioSubacciones;
use App\Models\accionesCorrectivas;
use App\Models\personalBergsModel;
use App\Models\sub_acciones_model;
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
        $accioness = accionesCorrectivas::where('status', 'LIKE', 'etapa 1%')->where('ultimoEmail', '<', Carbon::now()->format('Y-m-d'))
            ->get();
        $verificaciones = accionesCorrectivas::where('status', 'LIKE', 'etapa 2%')->where('ultimoEmail', '<', Carbon::now()->format('Y-m-d'))
            ->get();
        foreach ($verificaciones as $verificacion) {
            $mailto = personalBergsModel::select('email', 'employeeLider')->where('employeeName', $verificacion->resposableAccion)->first();
            $mailaddress = [
                'jgarrido@mx.bergstrominc.com',
                'maleman@mx.bergstrominc.com',
            ];
            if ($mailto) {
                $mailaddress[] = $mailto->email;
            }

            if (Carbon::parse($verificacion->fechaAccion)->addWeekDays(3)->isPast()) {
                $leaderMailto = personalBergsModel::select('email')->where('employeeName', $mailto->employeeLider)->first();
                if ($leaderMailto) {
                    $mailaddress[] = $leaderMailto->email;
                }
            }
            Mail::to($mailaddress)->send(new recordatorio($verificacion, ' Recordatorio "Acciones Correctivas"'));

            accionesCorrectivas::where('folioAccion', $verificacion->folioAccion)->update([
                'ultimoEmail' => Carbon::now()->format('Y-m-d'),
            ]);
        }

        foreach ($accioness as $acciones) {
            $mailto = personalBergsModel::select('email', 'employeeLider')->where('employeeName', $acciones->resposableAccion)->first();
            $mailaddress = [
                'jgarrido@mx.bergstrominc.com',
                'maleman@mx.bergstrominc.com',
            ];
            if ($mailto) {
                $mailaddress[] = $mailto->email;
            }

            if (Carbon::parse($acciones->fechaAccion)->addWeekDays(3)->isPast()) {
                $leaderMailto = personalBergsModel::select('email')->where('employeeName', $mailto->employeeLider)->first();
                if ($leaderMailto) {
                    $mailaddress[] = $leaderMailto->email;
                }
            }
            Mail::to($mailaddress)->send(new recordatorio($acciones, ' Recordatorio "Acciones Correctivas"'));

            accionesCorrectivas::where('folioAccion', $acciones->folioAccion)->update([
                'ultimoEmail' => Carbon::now()->format('Y-m-d'),
            ]);
        }
        // recordatorio para recoleccion de evidencia planes de accion
        $subacciones = sub_acciones_model::where('statusSubAccion', 'Open')->get();
        foreach ($subacciones as $subaccion) {

            // $mailto = personalBergsModel::select('email', 'employeeLider')->where('employeeName', $acciones->resposableAccion)->first();
            $mailaddress = [
                'jgarrido@mx.bergstrominc.com',
                'maleman@mx.bergstrominc.com',
            ];
            /* if ($mailto) {
                 $mailaddress[] = $mailto->email;
             }*/

            if (Carbon::parse($acciones->fechaAccion)->addWeekDays(3)->isPast()) {
                $subject = 'recoleccion de evidencia planes de accion';
                Mail::to($mailaddress)->send(new recordatorioSubacciones($subaccion, $subject));
            }
        }

    }
}

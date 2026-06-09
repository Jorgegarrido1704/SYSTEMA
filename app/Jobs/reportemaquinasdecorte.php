<?php

namespace App\Jobs;

use App\Mail\maquinasCorte\mailmaquinascorte;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class reportemaquinasdecorte implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Puedes pasarle una máquina específica al Job o buscar todas dentro del handle
    public function __construct() {}

    public function handle(): void
    {
        $maquinas = ['M1', 'M2', 'M3', 'M4', 'M5', 'M6'];
        foreach ($maquinas as $maquina) {

            $ultimaLectura = DB::connection('toi')->table('lecturas')
                ->where('maquina', '=', $maquina)
                ->orderby('id', 'desc')
                ->first();

            if ($ultimaLectura) {

                $fechaLectura = date('Y-m-d H:i:s', strtotime($ultimaLectura->fecha));
                $ahora = date('Y-m-d H:i:s');

                $diferencia = abs(strtotime($ahora) - strtotime($fechaLectura));
                $diferencia = $diferencia / 60;
                if ($diferencia > 30) {
                    $asunto = "ALERTA: La máquina {$maquina} lleva más de 30 minutos parada";
                    $correoDestino = ['jgarrido@mx.bergstrominc.com'];
                    Mail::to($correoDestino)->send(new mailmaquinascorte($ultimaLectura, $asunto));
                }

            } else {

                $asunto = "ALERTA: La máquina {$maquina} lleva más de 30 minutos parada";
                $correoDestino = ['jgarrido@mx.bergstrominc.com'];
                Mail::to($correoDestino)->send(new mailmaquinascorte($ultimaLectura, $asunto));
            }
        }
    }
}

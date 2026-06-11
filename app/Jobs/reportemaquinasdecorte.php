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
        $maquinas = ['M1', 'M2', 'M3', 'M4', 'M5'];
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
                switch ($ultimaLectura->maquina) {
                    case 'M1':
                        $ultimaLectura->maquina = 'MCUT-4';
                        break;
                    case 'M2':
                        $ultimaLectura->maquina = 'MCUT-5';
                        break;
                    case 'M3':
                        $ultimaLectura->maquina = 'MCUT-6';
                        break;
                    case 'M4':
                        $ultimaLectura->maquina = 'MCUT-10';
                        break;
                    case 'M5':
                        $ultimaLectura->maquina = 'MCUT-1';
                        break;
                    case 'M6':
                        $ultimaLectura->maquina = 'MCUT-7';
                        break;
                }
                if ($diferencia > 90) {
                    $asunto = "ALERTA: La máquina {$maquina} lleva más de 90 minutos parada";
                    $correoDestino = ['jgarrido@mx.bergstrominc.com', 'jcrodriguez@mx.bergstrominc.com', 'jruiz@mx.bergstrominc.com', 'ediaz@mx.bergstrominc.com',
                        'JPereida@mx.bergstrominc.com', 'AnGonzalez@mx.bergstrominc.com', 'jolaes@mx.bergstrominc.com', 'dvillalpando@mx.bergstrominc.com',
                        'lramos@mx.bergstrominc.com', 'jcervantes@mx.bergstrominc.com', 'jguillen@mx.bergstrominc.com', 'hsuarez@mx.bergstrominc.com'];
                    Mail::to($correoDestino)->send(new mailmaquinascorte($ultimaLectura, $asunto));
                } elseif ($diferencia > 60) {
                    $asunto = "ALERTA: La máquina {$maquina} lleva más de 60 minutos parada";
                    $correoDestino = ['jgarrido@mx.bergstrominc.com', 'jcrodriguez@mx.bergstrominc.com', 'jruiz@mx.bergstrominc.com', 'ediaz@mx.bergstrominc.com',
                        'JPereida@mx.bergstrominc.com', 'AnGonzalez@mx.bergstrominc.com'];
                    Mail::to($correoDestino)->send(new mailmaquinascorte($ultimaLectura, $asunto));
                } elseif ($diferencia > 20) {
                    $asunto = "ALERTA: La máquina {$maquina} lleva más de 30 minutos parada";
                    $correoDestino = ['jgarrido@mx.bergstrominc.com', 'jcrodriguez@mx.bergstrominc.com', 'jruiz@mx.bergstrominc.com'];
                    Mail::to($correoDestino)->send(new mailmaquinascorte($ultimaLectura, $asunto));
                }

            } else {

                $ultimaLectura = (object) [
                    'maquina' => $maquina,
                    'fecha' => 'No hay lecturas de hoy',
                    'id' => 'No hay lecturas de hoy',
                    'valor' => 'No hay lecturas de hoy',
                    'estado' => 'No hay lecturas de hoy',
                ];

                $asunto = "ALERTA: La máquina {$maquina} lleva más de 30 minutos parada";
                $correoDestino = ['jgarrido@mx.bergstrominc.com'];
                Mail::to($correoDestino)->send(new mailmaquinascorte($ultimaLectura, $asunto));
            }
        }
    }
}

<?php

namespace App\Jobs;

use App\Mail\maquinasCorte\mailmaquinascorte;
use Carbon\Carbon;
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
                ->where('maquina', '=', $this->maquina)
                ->orderby('id', 'desc')
                ->first();

            if ($ultimaLectura) {

                $fechaLectura = Carbon::parse($ultimaLectura->fecha);
                $ahora = Carbon::now('America/Mexico_City');

                if ($fechaLectura->diffInMinutes($ahora) > 30) {
                    $asunto = "ALERTA: La máquina {$this->maquina} lleva más de 30 minutos parada";
                    $correoDestino = ['jgarrido@mx.bergstrominc.com', 'jcrodriguez@mx.bergstrominc.com'];

                    Mail::to($correoDestino)->send(new mailmaquinascorte($ultimaLectura, $asunto));
                }

            }
        }
    }
}

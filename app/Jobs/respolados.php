<?php

namespace App\Jobs;

use App\Models\Wo;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class respolados implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $caron = Carbon::now('America/Mexico_City');
        $date = $caron->format('Y-m-d H:i');
        $selectWO = Wo::where('count', '20')->get();

        foreach ($selectWO as $woRecord) {
            $cliente = $woRecord->cliente;
            $np = $woRecord->NumPart;
            $wo = $woRecord->wo;
            $sono = $woRecord->po;
            $qty = $woRecord->Qty;
            $fechain = $woRecord->fecha;
            $embarque = $woRecord->orday;
            $codigo = $woRecord->info;

            DB::table('retiradad')->insert([
                'cliente' => $cliente,
                'np' => $np,
                'wo' => $wo,
                'sono' => $sono,
                'qty' => $qty,
                'fechaing' => $fechain,
                'fechaout' => $embarque,
                'fecharetiro' => $date,
                'codigo' => $codigo,
            ]);
            regPar::where('codeBar', $codigo)->delete();
            Wo::where('wo', $wo)->delete();

        }

    }
}

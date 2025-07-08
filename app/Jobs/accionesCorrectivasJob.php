<?php

namespace App\Jobs;

use App\Mail\accionesCorrectivasRecordatorio;
use App\Http\Controllers\mailsController;
use App\Models\accionesCorrectivas;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Constraint\Count;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class accionesCorrectivasJob implements ShouldQueue
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

        $acciones = accionesCorrectivas::where('status', 'etapa 2 - Accion Correctiva')
            ->get();

        foreach ($acciones as $accion) {
            if ($accion->email) {
                // Send the email using the Mailable class
                Mail::to('jgarrido@mx.bergstrominc.com')->send(new accionesCorrectivasRecordatorio($accion));
            }
        }



    }
}

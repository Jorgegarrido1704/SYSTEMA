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

use Illuminate\Support\Facades\Mail;

class accionesCorrectivasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        $acciones = accionesCorrectivas::where('status', 'etapa 2 - Accion Correctiva')
            ->first();
            Mail::to('jgarrido@mx.bergstrominc.com')->send(new accionesCorrectivasRecordatorio($acciones, 'Acciones Correctivas Recordatorio'));

    }
}

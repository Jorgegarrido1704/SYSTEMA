<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WorkOrderReportMail;
use App\Services\ExcelReportService;

class reporteGeneral implements ShouldQueue
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
        $service = new ExcelReportService();
            $filePath = $service->generateWorkOrderReport();
          /*  $senders=['jgarrido@mx.bergstrominc.com','jguillen@mx.bergstrominc.com','jgamboa@mx.bergstrominc.com','jrodriguez@mx.bergstrominc.com',
        'vpichardo@mx.bergstrominc.com','apacheco@mx.bergstrominc.com','jcervera@mx.bergstrominc.com','lramos@mx.bergstrominc.com',
        'emedina@mx.bergstrominc.com','drocha@mx.bergstrominc.com','enunez@mx.bergstrominc.com','dflores@mx.bergstrominc.com',
        'eceron@mx.bergstrominc.com','ejimenez@mx.bergstrominc.com','egaona@mx.bergstrominc.com','jolaes@mx.bergstrominc.com','dvillalpando@mx.bergstrominc.com'];
         */  Mail::to('jgarrido@mx.bergstrominc.com')->send(new WorkOrderReportMail($filePath));
    }
}

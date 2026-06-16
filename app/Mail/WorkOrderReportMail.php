<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class WorkOrderReportMail extends Mailable
{
    public $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function build()
    {
        return $this->from('reporte_general_ctvs@mx.bergstrominc.com')->subject('Reporte General de Work Orders')
            ->view('emails.report')
            ->attach($this->filePath, [
                'as' => basename($this->filePath),
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }
}

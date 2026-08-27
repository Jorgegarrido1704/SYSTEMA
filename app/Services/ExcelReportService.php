<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelReportService
{
    public function generateWorkOrderReport(): string
    {
        date_default_timezone_set('America/Mexico_City');
        $todays = date('d-m-Y');

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Work order '.$todays);

        // Encabezados
        $headers = [
            'Part Number',
            'Customer',
            'Work Order',
            'Original Quantity',
            'Planned',
            'Pre cutting',
            'To be cut',
            'Cutting',
            'Pre terminal',
            'To be terminal',
            'Terminals',
            'Pre assembly',
            'To be assembly',
            'Assembly',
            'Pre looming',
            'To be looming',
            'Looming',
            'Pre testing',
            'Testing',
            'Quality Errors',
            'PPAP\'s/Alejandro M.',
            'Pre packing',
            'To be packed',
            'Shipped',
            'Time in process',
            'Order Date',
            'Shorts',
        ];

        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column.'1', $header);
            $column++;
        }

        $rowNumber = 2;
        $workOrders = DB::table('registroparcial')->where('auditoria', '=', '0')->orderByDesc('pn')->get();

        foreach ($workOrders as $order) {

            $reg = DB::table('registro')->where('info', $order->codeBar)->first();

            $faltantes = '';
            if ($reg) {
                // diferencia en horas
                $diferencia = Carbon::now()->diffInHours(Carbon::parse($reg->fecha));
                $faltantesRows = DB::table('issuesfloor')->where('actionOfComment', '!=', 'Issue Fixed')->where('actionOfComment', '!=', 'Ok')->where('id_tiempos', $reg->id)->get();
                foreach ($faltantesRows as $faltante) {
                    $faltantes .= ' //'.$faltante->comment_issue.' // '.$faltante->date.' // '.$faltante->responsable."\n";
                }
            }
            $shipped = $order->orgQty -
               ($order->planpar + $order->precut + $order->tobecut + $order->cortPar + $order->preterm + $order->tobeterm + $order->libePar +
                $order->preassembly + $order->tobeassembly + $order->ensaPar + $order->preloom + $order->tobeloom + $order->loomPar +
                $order->preCalidad + $order->testPar + $order->fallasCalidad + $order->eng + $order->preemba + $order->embPar);
            $data = [
                $order->pn,
                $reg->cliente,
                $order->wo,
                $order->orgQty,
                $order->planpar,
                $order->precut,
                $order->tobecut,
                $order->cortPar,
                $order->preterm,
                $order->tobeterm,
                $order->libePar,
                $order->preassembly,
                $order->tobeassembly,
                $order->ensaPar,
                $order->preloom,
                $order->tobeloom,
                $order->loomPar,
                $order->preCalidad,
                $order->testPar,
                $order->fallasCalidad,
                $order->eng,
                $order->preemba,
                $order->embPar,
                $shipped,
                $reg->tiempototal ?? '',
                $reg->reqday ?? '',
                $faltantes,
            ];

            $column = 'A';
            foreach ($data as $cell) {
                $sheet->setCellValue($column.$rowNumber, $cell);
                $column++;
            }
            $rowNumber++;
        }
        // new sheet
        $sheet1 = $spreadsheet->createSheet();
        $sheet1->setTitle('Moviments'.$todays);

        $sheet1->setCellValue('A1', 'Work Order');
        $sheet1->setCellValue('B1', 'Operation');
        $sheet1->setCellValue('C1', 'Quantity');
        $sheet1->setCellValue('D1', 'Date');
        $t = 2;
        $todayNow = date('Y-m-d 00:00:00');
        $todaylast = date('Y-m-d 23:59:59');
        $moviments = DB::table('registroparcialtiempos')->whereBetween('fechaReg', [$todayNow, $todaylast])->get();
        foreach ($moviments as $mov) {
            $sheet1->setCellValue('A'.$t, $mov->codeBar);
            $sheet1->setCellValue('B'.$t, $mov->area);
            $sheet1->setCellValue('C'.$t, $mov->qtyPar);
            $sheet1->setCellValue('D'.$t, $mov->fechaReg);
            $t++;
        }

        $directory = storage_path('app/reports');
        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Guardar archivo en storage (ruta storage/app/reports)
        $fileName = 'Reporte_General_'.$todays.'.xlsx';
        $filePath = storage_path('app/reports/'.$fileName);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return $filePath; // ruta para usarla en el mail
    }
}

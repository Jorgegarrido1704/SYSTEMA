<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ExcelReportService
{
    public function generateWorkOrderReport(): string
    {
        date_default_timezone_set("America/Mexico_City");
        $todays = date("d-m-Y");

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Work order ' . $todays);

        // Encabezados
        $headers = [
            'Part Number',
            'Work Order',
            'Original Quantity',
            'Cutting',
            'Terminals',
            'Assembly',
            'Looming',
            'Pre testing',
            'Testing',
            'Quality Errors',
            'PPAP\'s/Alejandro M.',
            'Shipping',
            'Shipped',
            'Time in process',
            'Order Date',
            'Shorts'
        ];

        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }

        $rowNumber = 2;
        $workOrders = DB::table('registroparcial')->orderByDesc('pn')->get();

        foreach ($workOrders as $order) {
            $shipped = $order->orgQty - ($order->cortPar + $order->libePar + $order->ensaPar + $order->loomPar + $order->testPar + $order->embPar + $order->eng + $order->fallasCalidad + $order->preCalidad);

            $reg = DB::table('registro')->where('info', $order->codeBar)->first();

            $faltantes = '';
            if ($reg) {
                $faltantesRows = DB::table('issuesfloor')->where('actionOfComment','!=','Issue Fixed')->where('actionOfComment','!=','Ok')->where('id_tiempos', $reg->id)->get();
                foreach ($faltantesRows as $faltante) {
                    $faltantes .= ' //' . $faltante->comment_issue . ' // ' . $faltante->date . ' // ' . $faltante->responsable . "\n";
                }
            }

            $data = [
                $order->pn,
                $order->wo,
                $order->orgQty,
                $order->cortPar,
                $order->libePar,
                $order->ensaPar,
                $order->loomPar,
                $order->preCalidad,
                $order->testPar,
                $order->fallasCalidad,
                $order->eng,
                $order->embPar,
                $shipped,
                $reg->tiempototal ?? '',
                $reg->reqday ?? '',
                $faltantes,
            ];

            $column = 'A';
            foreach ($data as $cell) {
                $sheet->setCellValue($column . $rowNumber, $cell);
                $column++;
            }
            $rowNumber++;
        }

        $directory = storage_path('app/reports');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Guardar archivo en storage (ruta storage/app/reports)
        $fileName = 'Reporte_General_' . $todays . '.xlsx';
        $filePath = storage_path('app/reports/' . $fileName);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return $filePath; // ruta para usarla en el mail
    }
}

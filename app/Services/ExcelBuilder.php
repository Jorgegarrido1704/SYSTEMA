<?php

namespace App\Services;

use App\Models\Trabajo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelBuilder
{
    private const NAVY = '1B3A6B';

    private const RED = 'C8102E';

    private const LIGHT = 'F3F5F8';

    private const YELLOW = 'FFF6CC';

    private const CARDS = [['B', 'C', 'D', 'E'], ['G', 'H', 'I', 'J'], ['L', 'M', 'N', 'O']];

    private const BLOCK = 16;   // filas por bloque de tarjetas

    private const START = 9;    // primera fila de tarjetas
   
    private array $temporales = [];

    public function build(Trabajo $trabajo): string
            {
                $this->temporales = [];

                try {
                    $trabajo->load('pasos.plantilla');

                    $book = new Spreadsheet;
                    $sheet = $book->getActiveSheet()->setTitle('Instrucción de trabajo');
                    // ... todo lo que ya tienes: columnas, encabezado, tarjetas, impresión ...

                    $dir = "trabajos/{$trabajo->job}";
                    $path = "{$dir}/Instruccion_{$trabajo->job}.xlsx";
                    Storage::disk('public')->makeDirectory($dir);
                    (new Xlsx($book))->save(Storage::disk('public')->path($path));

                    $trabajo->update(['excel_path' => $path]);

                    return $path;
                } finally {
                    foreach ($this->temporales as $archivo) {
                        @unlink($archivo);
                    }
                    $this->temporales = [];
                }
            }

    private function encabezado(Worksheet $s, Trabajo $t): void
    {
        $s->mergeCells('E2:O2')->setCellValue('E2', 'MANUAL DE PROCESOS DE PRODUCCIÓN');
        $s->getStyle('E2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 20, 'color' => ['rgb' => self::NAVY]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        ]);
        $s->getRowDimension(2)->setRowHeight(34);

        // Logo
        $logo = new Drawing;
        $logo->setPath(public_path('img/logo.png'))->setCoordinates('B2')->setHeight(39)->setWorksheet($s);

        // Barra azul
        $s->mergeCells('B4:O4');
        $s->getStyle('B4:O4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(self::NAVY);
        $s->getRowDimension(4)->setRowHeight(5);

        // Datos del trabajo: [etiqueta, desde, hasta, valor]
        $campos = [
            ['NO. PARTE', 'B', 'C', $t->no_parte],
            ['REV.',      'D', 'E', $t->rev],
            ['CLIENTE',   'F', 'I', $t->cliente],
            ['FECHA',     'J', 'K', now()->format('d/m/Y')],
            ['JOB',       'L', 'M', $t->job],
            ['OPERADOR',  'N', 'O', $t->operador],
        ];
        foreach ($campos as [$etq, $a, $b, $valor]) {
            $s->mergeCells("{$a}5:{$b}5")->setCellValue("{$a}5", $etq);
            $s->getStyle("{$a}5")->getFont()->setSize(8)->setBold(true)->getColor()->setRGB('6B7280');

            $s->mergeCells("{$a}6:{$b}6")->setCellValueExplicit("{$a}6", (string) $valor, 's');
            $s->getStyle("{$a}6:{$b}6")->applyFromArray([
                'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => self::NAVY]],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::LIGHT]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'C9CED6']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
            ]);
        }
        $s->getRowDimension(6)->setRowHeight(30);
    }

    private function tarjeta(Worksheet $s, int $i, $paso): void
    {
        $r = self::START + intdiv($i, 3) * self::BLOCK;
        [$c1, $c2, $c3, $c4] = self::CARDS[$i % 3];

        // Cabecera: número + título
        $s->setCellValue("{$c1}{$r}", $paso->orden);
        $s->getStyle("{$c1}{$r}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 20, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::RED]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $s->mergeCells("{$c2}{$r}:{$c4}{$r}")->setCellValue("{$c2}{$r}", $paso->plantilla->titulo);
        $s->getStyle("{$c2}{$r}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => self::NAVY]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true, 'indent' => 1],
        ]);
        $s->getRowDimension($r)->setRowHeight(32);

        // Área de imagen (12 filas)
        for ($k = 1; $k <= 12; $k++) {
            $s->getRowDimension($r + $k)->setRowHeight(18.75);
        }
        $s->mergeCells("{$c1}".($r + 1).":{$c4}".($r + 12));

        // Imagen: la del operador si existe; si no, la de referencia
        $ruta = $paso->imagen_prueba ?: $paso->plantilla->imagen_referencia;
        if ($ruta && Storage::disk('public')->exists($ruta)) {
            $tmp = $this->normalizar(Storage::disk('public')->path($ruta));
            $d = new Drawing;
            $d->setPath($tmp)->setCoordinates("{$c1}".($r + 1))
                ->setWidth(394)->setHeight(296)->setOffsetX(4)->setWorksheet($s);
        }

        // Descripción
        $fila = $r + 13;
        $s->mergeCells("{$c1}{$fila}:{$c4}{$fila}")->setCellValue("{$c1}{$fila}", $paso->plantilla->descripcion);
        $s->getStyle("{$c1}{$fila}")->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
        $s->getRowDimension($fila)->setRowHeight(52);

        // Casilla de completado
        $fila = $r + 14;
        $s->mergeCells("{$c1}{$fila}:{$c2}{$fila}")->setCellValue("{$c1}{$fila}", $paso->completado_at ? '☑  Completado' : '☐  Paso completado');
        $s->mergeCells("{$c3}{$fila}:{$c4}{$fila}")->setCellValue("{$c3}{$fila}", 'Hora: '.optional($paso->completado_at)->format('H:i'));
        $s->getStyle("{$c1}{$fila}:{$c4}{$fila}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB(self::YELLOW);
        $s->getRowDimension($fila)->setRowHeight(22);
    }

    /** Recorta cualquier foto a 4:3 para que todas las tarjetas se vean iguales. */
    private function normalizar(string $origen): string
        {
            $tmp = storage_path('app/tmp_'.md5($origen).'.jpg');
            (new ImageManager(new Driver))->read($origen)->cover(800, 600)->toJpeg(80)->save($tmp);

            $this->temporales[] = $tmp;

            return $tmp;
        }

    private function configurarImpresion(Worksheet $s, int $totalPasos): void
    {
        $ultimaFila = self::START + (int) ceil($totalPasos / 3) * self::BLOCK;
        $s->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PageSetup::PAPERSIZE_LETTER)
            ->setFitToPage(true)->setFitToWidth(1)->setFitToHeight(0)
            ->setPrintArea("A1:P{$ultimaFila}");
        $s->getPageMargins()->setLeft(0.3)->setRight(0.3)->setTop(0.3)->setBottom(0.3);
    }
}

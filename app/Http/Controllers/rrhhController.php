<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\assistence;
use App\Models\rrhh\rotacionModel;
use Illuminate\Http\Request;
use App\Jobs\UpdateRotacionJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\personalBergsModel;
use Illuminate\Database\Eloquent\Casts\Json;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class rrhhController extends Controller
{
    public function rrhhDashBoard()
    {
        $value = session('user');
        $cat = session('categoria');

        $datosRHWEEK = assistence::leader($value)->OrderBy('lider', 'desc')->get();
        if ($value == 'Admin' or $value == 'Paola A') {
            $diasRegistro = ['', '', '', '', '', ''];
        } else {
            $diasRegistro = ['readonly', 'readonly', 'readonly', 'readonly', 'readonly'];
            $diasRegistros = ['', '', '', '', ''];
        }
        $datosRHWEEK = assistence::leader($value, $cat)->OrderBy('lider', 'desc')->get();

        $diaNum = carbon::now()->dayOfWeek; //

        if ($diaNum == 5 or $diaNum == 6 or $diaNum == 7) {
            $diasRegistro[4] = '';
            $diasRegistros[4] = '';
        } else {
            $diasRegistro[$diaNum - 1] = '';
            $diasRegistros[$diaNum - 1] = '';
        }

        return view('juntas/hrDocs/rrhhDashBoard', ['diasRegistros' => $diasRegistros, 'diasRegistro' => $diasRegistro, 'datosRHWEEK' => $datosRHWEEK, 'value' => $value, 'cat' => $cat]);
    }

    public function updateAsistencia(Request $request)
    {
        $week = date('W');

        $validated = $request->validate([
            'lun' => 'required|array',
            'extra_lun' => 'required|array',
            'mar' => 'required|array',
            'extra_mar' => 'required|array',
            'mie' => 'required|array',
            'extra_mie' => 'required|array',
            'jue' => 'required|array',
            'extra_jue' => 'required|array',
            'vie' => 'required|array',
            'extra_vie' => 'required|array',
            'sab' => 'required|array',
            'extra_sab' => 'required|array',
            'dom' => 'required|array',
            'extra_dom' => 'required|array',
            'numero_empleado' => 'required|array',
            'tt_lunes' => 'required|array',
            'tt_martes' => 'required|array',
            'tt_miercoles' => 'required|array',
            'tt_jueves' => 'required|array',
            'tt_viernes' => 'required|array',
            'tt_sabado' => 'required|array',
            'tt_domingo' => 'required|array',
        ]);

        foreach ($validated['numero_empleado'] as $index => $id_empleado) {
            $updateData = [
                'lunes' => $validated['lun'][$index] ?  strtoupper(str_replace('-', '', $validated['lun'][$index])) : strtoupper('-', '', $validated['lun'][$index]),
                'extLunes' => $validated['extra_lun'][$index],
                'martes' => $validated['mar'][$index] ?  strtoupper(str_replace('-', '', $validated['mar'][$index])) : strtoupper($validated['mar'][$index]),
                'extMartes' => $validated['extra_mar'][$index],
                'miercoles' => $validated['mie'][$index] ?  strtoupper(str_replace('-', '', $validated['mie'][$index])) : strtoupper($validated['mie'][$index]),
                'extMiercoles' => $validated['extra_mie'][$index],
                'jueves' => $validated['jue'][$index] ?  strtoupper(str_replace('-', '', $validated['jue'][$index])) : strtoupper($validated['jue'][$index]),
                'extJueves' => $validated['extra_jue'][$index],
                'viernes' => $validated['vie'][$index] ?  strtoupper(str_replace('-', '', $validated['vie'][$index])) : strtoupper($validated['vie'][$index]),
                'extViernes' => $validated['extra_vie'][$index],
                'sabado' => $validated['sab'][$index] ?  strtoupper(str_replace('-', '', $validated['sab'][$index])) : strtoupper($validated['sab'][$index]),
                'extSabado' => $validated['extra_sab'][$index],
                'domingo' => $validated['dom'][$index] ?  strtoupper(str_replace('-', '', $validated['dom'][$index])) : strtoupper($validated['dom'][$index]),
                'extDomingo' => $validated['extra_dom'][$index],
                'extras' => $validated['extra_lun'][$index] + $validated['extra_mar'][$index] + $validated['extra_mie'][$index] + $validated['extra_jue'][$index] + $validated['extra_vie'][$index] + $validated['extra_sab'][$index] + $validated['extra_dom'][$index],
                'tt_lunes' => $validated['tt_lunes'][$index],
                'tt_martes' => $validated['tt_martes'][$index],
                'tt_miercoles' => $validated['tt_miercoles'][$index],
                'tt_jueves' => $validated['tt_jueves'][$index],
                'tt_viernes' => $validated['tt_viernes'][$index],
                'tt_sabado' => $validated['tt_sabado'][$index],
                'tt_domingo' => $validated['tt_domingo'][$index],
                'tiempoPorTiempo' => $validated['tt_lunes'][$index] + $validated['tt_martes'][$index] + $validated['tt_miercoles'][$index] + $validated['tt_jueves'][$index] + $validated['tt_viernes'][$index] + $validated['tt_sabado'][$index] + $validated['tt_domingo'][$index],
            ];

            assistence::where('id_empleado', $id_empleado)
                ->where('week', $week)
                ->update($updateData);
        }
        //send a job to update rotacion
        UpdateRotacionJob::dispatch();


        return redirect()->route('rrhhDashBoard');
    }
    public function addperson(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:60',
            'id_empleado' => 'required|numeric|maxdigits:4',
            'ingreso' => 'required|date',
            'area' => 'required|string',
            'lider' => 'required|string',
            'tipoDeTrabajador' => 'required|string',
            'Genero' => 'required|string',
        ]);

        if (personalBergsModel::where('employeeNumber', '=', 'i' . $validated['id_empleado'])->exists()) {
            return redirect()->route('rrhhDashBoard')->with('error', 'El empleado ya existe en la base de datos.');
        } else {
            personalBergsModel::create([
                'employeeName' =>  $validated['nombre'],
                'employeeNumber' => 'i' . $validated['id_empleado'],
                'DateIngreso' => $validated['ingreso'],
                'employeeArea' => $validated['area'],
                'employeeLider' => $validated['lider'],
                'typeWorker' => $validated['tipoDeTrabajador'],
                'Gender' => $validated['Genero'],
            ]);
            assistence::create([
                'week' => date('W'),
                'lider' => $validated['lider'],
                'name' => $validated['nombre'],
                'id_empleado' => 'i' . $validated['id_empleado']
            ]);

            return redirect()->route('rrhhDashBoard')->with('error', 'Empleado agregado correctamente.');
        }
    }
    public function modificarEmpleado(Request $request)
    {
        $datos = $request->input('dato');
        if (is_numeric($datos)) {
            $data = personalBergsModel::where('employeeNumber', '=', $datos)->get();
        } else {
            $data = personalBergsModel::where('employeeName', 'LIKE', $datos . '%')->orWhere('employeeName', 'LIKE', '%' . $datos . '%')->get();
        }
        return response()->json($data);
    }
    public function editarEmepleado(Request $request)
    {
        $valued = $request->input('valor');
        $id_empleado = $request->input('id_employee');
        $name = $request->input('nameEmployee');
        $area = $request->input('area');
        $lider = $request->input('lider');
        $tipoDeTrabajador = $request->input('typeWorker');
        $Genero = $request->input('genero');
        $status = $request->input('status');

        if ($status == 'Baja') {
            $registro = carbon::now();
            $semana = carbon::now()->week();
            personalBergsModel::where('employeeNumber', '=', $valued)->update([
                'DateSalida' => $registro,
            ]);
            assistence::where('id_empleado', '=', $valued, 'AND', 'Status', '=', 'Baja', 'AND', 'week', '=', $semana)->delete();
            UpdateRotacionJob::dispatch();
        }

        $datosAdd =    personalBergsModel::where('employeeNumber', '=', $valued)->update([
            'employeeNumber' => 'i' . $id_empleado,
            'employeeName' => $name,
            'employeeArea' => $area,
            'employeeLider' => $lider,
            'typeWorker' => $tipoDeTrabajador,
            'Gender' => $Genero,
            'status' => $status,
        ]);
        if ($datosAdd) {
            $datos = "realizado";
        } else {
            $datos = "error // no cambio de empleado";
        }


        return response()->json($datos);
    }






    public function reporteSemanlInicidencias(Request $request)
    {
        $week = $request->input('semana');

        // Obtener líderes únicos por semana
        $leaders = assistence::select('lider')
            ->distinct()
            ->where('semana', $week)
            ->orderBy('lider', 'ASC')
            ->get();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0); // Quitar la hoja en blanco por defecto

        // Encabezados
        $headers = [
            'A1' => 'Empleado',
            'B1' => 'Numero de empleado',
            'C1' => 'Lunes',
            'D1' => 'Tiempo Extra Lunes',
            'E1' => 'Tiempo por Tiempo Lunes',
            'F1' => 'Martes',
            'G1' => 'Tiempo Extra Martes',
            'H1' => 'Tiempo por Tiempo Martes',
            'I1' => 'Miércoles',
            'J1' => 'Tiempo Extra Miércoles',
            'K1' => 'Tiempo por Tiempo Miércoles',
            'L1' => 'Jueves',
            'M1' => 'Tiempo Extra Jueves',
            'N1' => 'Tiempo por Tiempo Jueves',
            'O1' => 'Viernes',
            'P1' => 'Tiempo Extra Viernes',
            'Q1' => 'Tiempo por Tiempo Viernes',
            'R1' => 'Sábado',
            'S1' => 'Tiempo Extra Sábado',
            'T1' => 'Tiempo por Tiempo Sábado',
            'U1' => 'Domingo',
            'V1' => 'Tiempo Extra Domingo',
            'W1' => 'Tiempo por Tiempo Domingo',
            'X1' => 'Total de Extras',
            'Y1' => 'Total de Tiempo por Tiempo',
            'Z1' => 'Bono de Asistencia',
            'AA1' => 'Bono de puntualidad'
        ];

        foreach ($leaders as $l) {
            // Crear hoja por líder
            $sheet = $spreadsheet->createSheet();
            $sheet->setTitle($l->lider);

            // Agregar encabezados
            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Estilo para encabezados
            $headerStyle = [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFB0C4DE']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ]
                ]
            ];
            $sheet->getStyle('A1:AA1')->applyFromArray($headerStyle);

            // Obtener datos del líder
            $datos = assistence::where('semana', $week)
                ->where('lider', $l->lider)
                ->orderBy('employeeName', 'asc')
                ->get();

            // Agregar datos
            $row = 2;
            foreach ($datos as $d) {
                $sheet->setCellValue('A' . $row, $d->employeeName);
                $sheet->setCellValue('B' . $row, $d->employeeNumber);
                $sheet->setCellValue('C' . $row, $d->Lunes);
                $sheet->setCellValue('D' . $row, $d->LunesExtra);
                $sheet->setCellValue('E' . $row, $d->LunesTiempo);
                $sheet->setCellValue('F' . $row, $d->Martes);
                $sheet->setCellValue('G' . $row, $d->MartesExtra);
                $sheet->setCellValue('H' . $row, $d->MartesTiempo);
                $sheet->setCellValue('I' . $row, $d->Miercoles);
                $sheet->setCellValue('J' . $row, $d->MiercolesExtra);
                $sheet->setCellValue('K' . $row, $d->MiercolesTiempo);
                $sheet->setCellValue('L' . $row, $d->Jueves);
                $sheet->setCellValue('M' . $row, $d->JuevesExtra);
                $sheet->setCellValue('N' . $row, $d->JuevesTiempo);
                $sheet->setCellValue('O' . $row, $d->Viernes);
                $sheet->setCellValue('P' . $row, $d->ViernesExtra);
                $sheet->setCellValue('Q' . $row, $d->ViernesTiempo);
                $sheet->setCellValue('R' . $row, $d->Sabado);
                $sheet->setCellValue('S' . $row, $d->SabadoExtra);
                $sheet->setCellValue('T' . $row, $d->SabadoTiempo);
                $sheet->setCellValue('U' . $row, $d->Domingo);
                $sheet->setCellValue('V' . $row, $d->DomingoExtra);
                $sheet->setCellValue('W' . $row, $d->DomingoTiempo);
                $sheet->setCellValue('X' . $row, $d->TotalExtras);
                $sheet->setCellValue('Y' . $row, $d->TotalTiempo);
                $sheet->setCellValue('Z' . $row, $d->BonoAsistencia);
                $sheet->setCellValue('AA' . $row, $d->BonoPuntualidad);
                $row++;
            }

            // Ajustar ancho de columnas automáticamente
            foreach (range('A', 'AA') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        // Establecer hoja activa en la primera creada
        $spreadsheet->setActiveSheetIndex(0);

        // Enviar archivo
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Reporte_incidencias_semana_' . $week . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}

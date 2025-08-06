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
        $weekNum = Carbon::now()->weekOfYear;
        $datosRHWEEK = assistence::leader($value)->OrderBy('lider', 'desc')->get();
        if ($value == 'Admin' or $cat  == 'RRHH') {
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

        return view('juntas.hrDocs.rrhhDashBoard', ['weekNum' => $weekNum, 'diasRegistros' => $diasRegistros, 'diasRegistro' => $diasRegistro, 'datosRHWEEK' => $datosRHWEEK, 'value' => $value, 'cat' => $cat]);
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

        $assistencias = assistence::where('week', $week)->get();
        $year = Carbon::now()->year;
        $weekNumber = $week;
        $lunes = Carbon::now()->setISODate($year, $weekNumber, 1);
        $martes = Carbon::now()->setISODate($year, $weekNumber, 2);
        $miercoles = Carbon::now()->setISODate($year, $weekNumber, 3);
        $jueves = Carbon::now()->setISODate($year, $weekNumber, 4);
        $viernes = Carbon::now()->setISODate($year, $weekNumber, 5);
        $sabado = Carbon::now()->setISODate($year, $weekNumber, 6);
        $domingo = Carbon::now()->setISODate($year, $weekNumber, 7);

        $spreadsheet = new Spreadsheet();
        $sheets = $spreadsheet->getActiveSheet();
        foreach (range('A', 'Z') as $col) {
            $sheets->getColumnDimension($col)->setAutoSize(true);
        }
        $sheets->setTitle('Reporte de incidencias');
        $sheets->setCellValue('A1', 'Tipo de inicidencias');
        $sheets->setCellValue('B1', $lunes->format('d-m-Y'));
        $sheets->setCellValue('C1', $martes->format('d-m-Y'));
        $sheets->setCellValue('D1', $miercoles->format('d-m-Y'));
        $sheets->setCellValue('E1', $jueves->format('d-m-Y'));
        $sheets->setCellValue('F1', $viernes->format('d-m-Y'));
        $sheets->setCellValue('G1', $sabado->format('d-m-Y'));
        $sheets->setCellValue('H1', $domingo->format('d-m-Y'));
        $sheets->setCellValue('A2', 'Assistencias');
        $sheets->setCellValue('A3', 'Falta');
        $sheets->setCellValue('A4', 'Permiso sin gose');
        $sheets->setCellValue('A5', 'Permiso con gose');
        $sheets->setCellValue('A6', 'Incapacidad');
        $sheets->setCellValue('A7', 'Vacaciones');
        $sheets->setCellValue('A8', 'Retardos');
        $sheets->setCellValue('A9', 'Suspensiones');
        $sheets->setCellValue('A10', 'Tiempo Permiso Salida');
        $sheets->setCellValue('A11', 'Practicantes');
        $sheets->setCellValue('A12', 'Asimilados');
        $sheets->setCellValue('A13', 'Servicion Comprado');
        $sheets->setCellValue('A14', 'Total Extras');
        $sheets->setCellValue('A15', 'Total Tiempo por Tiempo');
        //ok
        $sheets->setCellValue('B2', assistence::where('week', $week)->where('lunes', 'OK')->count());
        $sheets->setCellValue('C2', assistence::where('week', $week)->where('martes', 'OK')->count());
        $sheets->setCellValue('D2', assistence::where('week', $week)->where('miercoles', 'OK')->count());
        $sheets->setCellValue('E2', assistence::where('week', $week)->where('jueves', 'OK')->count());
        $sheets->setCellValue('F2', assistence::where('week', $week)->where('viernes', 'OK')->count());
        $sheets->setCellValue('G2', assistence::where('week', $week)->where('sabado', 'OK')->count());
        $sheets->setCellValue('H2', assistence::where('week', $week)->where('domingo', 'OK')->count());
        //f
        $sheets->setCellValue('B3', assistence::where('week', $week)->where('lunes', 'F')->count());
        $sheets->setCellValue('C3', assistence::where('week', $week)->where('martes', 'F')->count());
        $sheets->setCellValue('D3', assistence::where('week', $week)->where('miercoles', 'F')->count());
        $sheets->setCellValue('E3', assistence::where('week', $week)->where('jueves', 'F')->count());
        $sheets->setCellValue('F3', assistence::where('week', $week)->where('viernes', 'F')->count());
        $sheets->setCellValue('G3', assistence::where('week', $week)->where('sabado', 'F')->count());
        $sheets->setCellValue('H3', assistence::where('week', $week)->where('domingo', 'F')->count());
        //PSS
        $sheets->setCellValue('B4', assistence::where('week', $week)->where('lunes', 'PSS')->count());
        $sheets->setCellValue('C4', assistence::where('week', $week)->where('martes', 'PSS')->count());
        $sheets->setCellValue('D4', assistence::where('week', $week)->where('miercoles', 'PSS')->count());
        $sheets->setCellValue('E4', assistence::where('week', $week)->where('jueves', 'PSS')->count());
        $sheets->setCellValue('F4', assistence::where('week', $week)->where('viernes', 'PSS')->count());
        $sheets->setCellValue('G4', assistence::where('week', $week)->where('sabado', 'PSS')->count());
        $sheets->setCellValue('H4', assistence::where('week', $week)->where('domingo', 'PSS')->count());
        //PCS
        $sheets->setCellValue('B5', assistence::where('week', $week)->where('lunes', 'PCS')->count());
        $sheets->setCellValue('C5', assistence::where('week', $week)->where('martes', 'PCS')->count());
        $sheets->setCellValue('D5', assistence::where('week', $week)->where('miercoles', 'PCS')->count());
        $sheets->setCellValue('E5', assistence::where('week', $week)->where('jueves', 'PCS')->count());
        $sheets->setCellValue('F5', assistence::where('week', $week)->where('viernes', 'PCS')->count());
        $sheets->setCellValue('G5', assistence::where('week', $week)->where('sabado', 'PCS')->count());
        $sheets->setCellValue('H5', assistence::where('week', $week)->where('domingo', 'PCS')->count());
        //INC
        $sheets->setCellValue('B6', assistence::where('week', $week)->where('lunes', 'INC')->count());
        $sheets->setCellValue('C6', assistence::where('week', $week)->where('martes', 'INC')->count());
        $sheets->setCellValue('D6', assistence::where('week', $week)->where('miercoles', 'INC')->count());
        $sheets->setCellValue('E6', assistence::where('week', $week)->where('jueves', 'INC')->count());
        $sheets->setCellValue('F6', assistence::where('week', $week)->where('viernes', 'INC')->count());
        $sheets->setCellValue('G6', assistence::where('week', $week)->where('sabado', 'INC')->count());
        $sheets->setCellValue('H6', assistence::where('week', $week)->where('domingo', 'INC')->count());
        //V
        $sheets->setCellValue('B7', assistence::where('week', $week)->where('lunes', 'V')->count());
        $sheets->setCellValue('C7', assistence::where('week', $week)->where('martes', 'V')->count());
        $sheets->setCellValue('D7', assistence::where('week', $week)->where('miercoles', 'V')->count());
        $sheets->setCellValue('E7', assistence::where('week', $week)->where('jueves', 'V')->count());
        $sheets->setCellValue('F7', assistence::where('week', $week)->where('viernes', 'V')->count());
        $sheets->setCellValue('G7', assistence::where('week', $week)->where('sabado', 'V')->count());
        $sheets->setCellValue('H7', assistence::where('week', $week)->where('domingo', 'V')->count());
        //R
        $sheets->setCellValue('B8', assistence::where('week', $week)->where('lunes', 'R')->count());
        $sheets->setCellValue('C8', assistence::where('week', $week)->where('martes', 'R')->count());
        $sheets->setCellValue('D8', assistence::where('week', $week)->where('miercoles', 'R')->count());
        $sheets->setCellValue('E8', assistence::where('week', $week)->where('jueves', 'R')->count());
        $sheets->setCellValue('F8', assistence::where('week', $week)->where('viernes', 'R')->count());
        $sheets->setCellValue('G8', assistence::where('week', $week)->where('sabado', 'R')->count());
        $sheets->setCellValue('H8', assistence::where('week', $week)->where('domingo', 'R')->count());
        //SUS
        $sheets->setCellValue('B9', assistence::where('week', $week)->where('lunes', 'SUS')->count());
        $sheets->setCellValue('C9', assistence::where('week', $week)->where('martes', 'SUS')->count());
        $sheets->setCellValue('D9', assistence::where('week', $week)->where('miercoles', 'SUS')->count());
        $sheets->setCellValue('E9', assistence::where('week', $week)->where('jueves', 'SUS')->count());
        $sheets->setCellValue('F9', assistence::where('week', $week)->where('viernes', 'SUS')->count());
        $sheets->setCellValue('G9', assistence::where('week', $week)->where('sabado', 'SUS')->count());
        $sheets->setCellValue('H9', assistence::where('week', $week)->where('domingo', 'SUS')->count());
        //TSP
        $sheets->setCellValue('B10', assistence::where('week', $week)->where('lunes', 'TSP')->count());
        $sheets->setCellValue('C10', assistence::where('week', $week)->where('martes', 'TSP')->count());
        $sheets->setCellValue('D10', assistence::where('week', $week)->where('miercoles', 'TSP')->count());
        $sheets->setCellValue('E10', assistence::where('week', $week)->where('jueves', 'TSP')->count());
        $sheets->setCellValue('F10', assistence::where('week', $week)->where('viernes', 'TSP')->count());
        $sheets->setCellValue('G10', assistence::where('week', $week)->where('sabado', 'TSP')->count());
        $sheets->setCellValue('H10', assistence::where('week', $week)->where('domingo', 'TSP')->count());
        //PCT
        $sheets->setCellValue('B11', assistence::where('week', $week)->where('lunes', 'PCT')->count());
        $sheets->setCellValue('C11', assistence::where('week', $week)->where('martes', 'PCT')->count());
        $sheets->setCellValue('D11', assistence::where('week', $week)->where('miercoles', 'PCT')->count());
        $sheets->setCellValue('E11', assistence::where('week', $week)->where('jueves', 'PCT')->count());
        $sheets->setCellValue('F11', assistence::where('week', $week)->where('viernes', 'PCT')->count());
        $sheets->setCellValue('G11', assistence::where('week', $week)->where('sabado', 'PCT')->count());
        $sheets->setCellValue('H11', assistence::where('week', $week)->where('domingo', 'PCT')->count());
        //ASM
        $sheets->setCellValue('B12', assistence::where('week', $week)->where('lunes', 'ASM')->count());
        $sheets->setCellValue('C12', assistence::where('week', $week)->where('martes', 'ASM')->count());
        $sheets->setCellValue('D12', assistence::where('week', $week)->where('miercoles', 'ASM')->count());
        $sheets->setCellValue('E12', assistence::where('week', $week)->where('jueves', 'ASM')->count());
        $sheets->setCellValue('F12', assistence::where('week', $week)->where('viernes', 'ASM')->count());
        $sheets->setCellValue('G12', assistence::where('week', $week)->where('sabado', 'ASM')->count());
        $sheets->setCellValue('H12', assistence::where('week', $week)->where('domingo', 'ASM')->count());
        //SCE
        $sheets->setCellValue('B13', assistence::where('week', $week)->where('lunes', 'SCE')->count());
        $sheets->setCellValue('C13', assistence::where('week', $week)->where('martes', 'SCE')->count());
        $sheets->setCellValue('D13', assistence::where('week', $week)->where('miercoles', 'SCE')->count());
        $sheets->setCellValue('E13', assistence::where('week', $week)->where('jueves', 'SCE')->count());
        $sheets->setCellValue('F13', assistence::where('week', $week)->where('viernes', 'SCE')->count());
        $sheets->setCellValue('G13', assistence::where('week', $week)->where('sabado', 'SCE')->count());
        $sheets->setCellValue('H13', assistence::where('week', $week)->where('domingo', 'SCE')->count());
        //TE
        $sheets->setCellValue('B14', assistence::where('week', $week)->SUM('extLunes'));
        $sheets->setCellValue('C14', assistence::where('week', $week)->sum('extMartes'));
        $sheets->setCellValue('D14', assistence::where('week', $week)->sum('extMiercoles'));
        $sheets->setCellValue('E14', assistence::where('week', $week)->sum('extJueves'));
        $sheets->setCellValue('F14', assistence::where('week', $week)->sum('extViernes'));
        $sheets->setCellValue('G14', assistence::where('week', $week)->sum('extSabado'));
        $sheets->setCellValue('H14', assistence::where('week', $week)->sum('extDomingo'));
        //TPT
        $sheets->setCellValue('B15', assistence::where('week', $week)->sum('tt_lunes'));
        $sheets->setCellValue('C15', assistence::where('week', $week)->sum('tt_martes'));
        $sheets->setCellValue('D15', assistence::where('week', $week)->sum('tt_miercoles'));
        $sheets->setCellValue('E15', assistence::where('week', $week)->sum('tt_jueves'));
        $sheets->setCellValue('F15', assistence::where('week', $week)->sum('tt_viernes'));
        $sheets->setCellValue('G15', assistence::where('week', $week)->sum('tt_sabado'));
        $sheets->setCellValue('H15', assistence::where('week', $week)->sum('tt_domingo'));




        // Obtener líderes únicos por semana
        $leaders = assistence::select('lider')
            ->distinct()
            ->where('week', $week)
            ->orderBy('lider', 'ASC')
            ->get();
        // Encabezados
        $headers = [
            'A1' => 'Empleado',
            'B1' => 'Numero de empleado',
            'C1' => 'Lunes',
            'd1' => 'Martes',
            'e1' => 'Miércoles',
            'f1' => 'Jueves',
            'g1' => 'Viernes',
            'h1' => 'Sábado',
            'i1' => 'Domingo',
            'j1' => 'Total de Extras',
            'k1' => 'Total de Tiempo por Tiempo',
            'l1' => 'Bono de Asistencia',
            'm1' => 'Bono de puntualidad'
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
            $sheet->getStyle('A1:m1')->applyFromArray($headerStyle);
    foreach (range('A', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

            // Obtener datos del líder
            $datos = assistence::where('week', $week)
                ->where('lider', $l->lider)
                ->orderBy('name', 'asc')
                ->get();

            // Agregar datos
            $row = 2;
            foreach ($datos as $d) {
                $sheet->setCellValue('A' . $row, $d->name);
                $sheet->setCellValue('b' . $row, substr($d->id_empleado,1));
                $sheet->setCellValue('c' . $row, $d->lunes);
                $sheet->setCellValue('d' . $row, $d->martes);
                $sheet->setCellValue('e' . $row, $d->miercoles);
                $sheet->setCellValue('f' . $row, $d->jueves);
                $sheet->setCellValue('g' . $row, $d->viernes);
               $sheet->setCellValue('h' . $row, $d->sabado);
                $sheet->setCellValue('i' . $row, $d->domingo);
                 $sheet->setCellValue('j' . $row, $d->extras);
                $sheet->setCellValue('k' . $row, $d->tiempoPorTiempo);
                $sheet->setCellValue('l' . $row, $d->bonoAsistencia);
                $sheet->setCellValue('m' . $row, $d->bonoPuntualidad);
                $row++;
            }


        }



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

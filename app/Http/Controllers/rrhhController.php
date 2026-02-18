<?php

namespace App\Http\Controllers;

use App\http\Controllers\Controller;
use App\Jobs\UpdateRotacionJob;
use App\Models\assistence;
use App\Models\personalBergsModel;
use App\Models\registroVacacionesModel;
use App\Models\relogChecadorModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class rrhhController extends Controller
{
    /*******  cf92efa2-efe2-42d1-9d57-bbe14f7dffdb  *******/
    public function rrhhDashBoard()
    {

        $value = session('user');
        $cat = session('categoria');
        $leadername = personalBergsModel::select('employeeName')->where('user', '=', $value)->first();
        $lidername = personalBergsModel::select('employeeLider')->distinct()->get();
        $laeder = $leadername->employeeName ?? $value;
        $weekNum = Carbon::now()->weekOfYear;
        $datosRHWEEK = $tt = [];
        if ($value == 'Admin' or $cat == 'RRHH') {
            $datosRHWEEK = assistence::leader($value)->OrderBy('lider', 'desc')->get();
            $diasRegistro = ['', '', '', '', '', ''];
            $diasRegistros = ['', '', '', '', ''];
        } else {
            $diasRegistro = ['readonly', 'readonly', 'readonly', 'readonly', 'readonly'];
            $tt = ['readonly', 'readonly', 'readonly', 'readonly', 'readonly'];
            $datosRHWEEK = assistence::leader($laeder, $cat)->OrderBy('lider', 'desc')->get();
            $diasRegistros = ['', '', '', '', ''];
        }

        $diaNum = carbon::now()->dayOfWeek; //
        $datosRHWEEKLastWeek = [];
        if (($diaNum == 1) and carbon::now()->format('H:i') < '10:00') {
            if ($value == 'Admin' or $cat == 'RRHH') {
                $datosRHWEEKLastWeek = assistence::LeaderLastWeek($value)->OrderBy('lider', 'desc')->get();
            } else {
                $datosRHWEEKLastWeek = assistence::LeaderLastWeek($laeder, $cat)->OrderBy('lider', 'desc')->get();
            }
        }

        if ($diaNum == 5 or $diaNum == 6 or $diaNum == 7) {
            $diasRegistro[4] = '';
            $tt[4] = '';

        } elseif (carbon::now()->format('H:i') < '08:20') {
            $diasRegistro[$diaNum - 1] = '';
        }
        if (carbon::now()->format('H:i') < '12:00' and $diaNum >= 2) {
            $tt[$diaNum - 1] = '';
        }

        return view('juntas.hrDocs.rrhhDashBoard', ['lidername' => $lidername, 'weekNum' => $weekNum,
            'diasRegistros' => $diasRegistros, 'diasRegistro' => $diasRegistro, 'datosRHWEEK' => $datosRHWEEK, 'value' => $value,
            'cat' => $cat, 'datosRHWEEKLastWeek' => $datosRHWEEKLastWeek, ]);
    }

    public function updateAsistencia(Request $request)
    {
        $week = intval(date('W'));
        $year = $week <= 1 ? Carbon::now()->year + 1 : Carbon::now()->year;
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
                'lunes' => $validated['lun'][$index] ? strtoupper(str_replace('-', '', $validated['lun'][$index])) : '-',
                'extLunes' => $validated['extra_lun'][$index] ?? 0,
                'martes' => $validated['mar'][$index] ? strtoupper(str_replace('-', '', $validated['mar'][$index])) : '-',
                'extMartes' => $validated['extra_mar'][$index] ?? 0,
                'miercoles' => $validated['mie'][$index] ? strtoupper(str_replace('-', '', $validated['mie'][$index])) : '-',
                'extMiercoles' => $validated['extra_mie'][$index] ?? 0,
                'jueves' => $validated['jue'][$index] ? strtoupper(str_replace('-', '', $validated['jue'][$index])) : '-',
                'extJueves' => $validated['extra_jue'][$index] ?? 0,
                'viernes' => $validated['vie'][$index] ? strtoupper(str_replace('-', '', $validated['vie'][$index])) : '-',
                'extViernes' => $validated['extra_vie'][$index] ?? 0,
                'sabado' => $validated['sab'][$index] ? strtoupper(str_replace('-', '', $validated['sab'][$index])) : '-',
                'extSabado' => $validated['extra_sab'][$index] ?? 0,
                'domingo' => $validated['dom'][$index] ? strtoupper(str_replace('-', '', $validated['dom'][$index])) : '-',
                'extDomingo' => $validated['extra_dom'][$index] ?? 0,
                'extras' => $validated['extra_lun'][$index] + $validated['extra_mar'][$index] + $validated['extra_mie'][$index] + $validated['extra_jue'][$index] + $validated['extra_vie'][$index] + $validated['extra_sab'][$index] + $validated['extra_dom'][$index] ?? 0,
                'tt_lunes' => $validated['tt_lunes'][$index] ?? 0,
                'tt_martes' => $validated['tt_martes'][$index] ?? 0,
                'tt_miercoles' => $validated['tt_miercoles'][$index] ?? 0,
                'tt_jueves' => $validated['tt_jueves'][$index] ?? 0,
                'tt_viernes' => $validated['tt_viernes'][$index] ?? 0,
                'tt_sabado' => $validated['tt_sabado'][$index] ?? 0,
                'tt_domingo' => $validated['tt_domingo'][$index] ?? 0,
                'tiempoPorTiempo' => $validated['tt_lunes'][$index] + $validated['tt_martes'][$index] + $validated['tt_miercoles'][$index] + $validated['tt_jueves'][$index] + $validated['tt_viernes'][$index] + $validated['tt_sabado'][$index] + $validated['tt_domingo'][$index] ?? 0,
            ];

            assistence::where('id_empleado', $id_empleado)
                ->where('week', $week)
                ->where('yearOfAssistence', '=', $year)
                ->update($updateData);
        }
        // send a job to update rotacion
        UpdateRotacionJob::dispatch();

        return redirect()->route('rrhhDashBoard');
    }

    public function updateLastWeek(Request $request)
    {
        $week = intval(date('W')) - 1;
        $year = $week <= 1 ? Carbon::now()->year + 1 : Carbon::now()->year;
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
                'lunes' => $validated['lun'][$index] ? strtoupper(str_replace('-', '', $validated['lun'][$index])) : '-',
                'extLunes' => $validated['extra_lun'][$index] ?? 0,
                'martes' => $validated['mar'][$index] ? strtoupper(str_replace('-', '', $validated['mar'][$index])) : '-',
                'extMartes' => $validated['extra_mar'][$index] ?? 0,
                'miercoles' => $validated['mie'][$index] ? strtoupper(str_replace('-', '', $validated['mie'][$index])) : '-',
                'extMiercoles' => $validated['extra_mie'][$index] ?? 0,
                'jueves' => $validated['jue'][$index] ? strtoupper(str_replace('-', '', $validated['jue'][$index])) : '-',
                'extJueves' => $validated['extra_jue'][$index] ?? 0,
                'viernes' => $validated['vie'][$index] ? strtoupper(str_replace('-', '', $validated['vie'][$index])) : '-',
                'extViernes' => $validated['extra_vie'][$index] ?? 0,
                'sabado' => $validated['sab'][$index] ? strtoupper(str_replace('-', '', $validated['sab'][$index])) : '-',
                'extSabado' => $validated['extra_sab'][$index] ?? 0,
                'domingo' => $validated['dom'][$index] ? strtoupper(str_replace('-', '', $validated['dom'][$index])) : '-',
                'extDomingo' => $validated['extra_dom'][$index] ?? 0,
                'extras' => $validated['extra_lun'][$index] + $validated['extra_mar'][$index] + $validated['extra_mie'][$index] + $validated['extra_jue'][$index] + $validated['extra_vie'][$index] + $validated['extra_sab'][$index] + $validated['extra_dom'][$index] ?? 0,
                'tt_lunes' => $validated['tt_lunes'][$index] ?? 0,
                'tt_martes' => $validated['tt_martes'][$index] ?? 0,
                'tt_miercoles' => $validated['tt_miercoles'][$index] ?? 0,
                'tt_jueves' => $validated['tt_jueves'][$index] ?? 0,
                'tt_viernes' => $validated['tt_viernes'][$index] ?? 0,
                'tt_sabado' => $validated['tt_sabado'][$index] ?? 0,
                'tt_domingo' => $validated['tt_domingo'][$index] ?? 0,
                'tiempoPorTiempo' => $validated['tt_lunes'][$index] + $validated['tt_martes'][$index] + $validated['tt_miercoles'][$index] + $validated['tt_jueves'][$index] + $validated['tt_viernes'][$index] + $validated['tt_sabado'][$index] + $validated['tt_domingo'][$index] ?? 0,
            ];

            assistence::where('id_empleado', $id_empleado)
                ->where('week', $week)
                ->where('yearOfAssistence', '=', $year)
                ->update($updateData);
        }

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

        if (personalBergsModel::where('employeeNumber', '=', 'i'.$validated['id_empleado'])->exists()) {
            return redirect()->route('rrhhDashBoard')->with('error', 'El empleado ya existe en la base de datos.');
        } else {
            personalBergsModel::create([
                'employeeName' => $validated['nombre'],
                'employeeNumber' => 'i'.$validated['id_empleado'],
                'DateIngreso' => $validated['ingreso'],
                'employeeArea' => $validated['area'],
                'employeeLider' => $validated['lider'],
                'typeWorker' => $validated['tipoDeTrabajador'],
                'Gender' => $validated['Genero'],
            ]);
            assistence::create([
                'week' => intval(date('W')),
                'lider' => $validated['lider'],
                'name' => $validated['nombre'],
                'id_empleado' => 'i'.$validated['id_empleado'],
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
            $data = personalBergsModel::where('employeeName', 'LIKE', $datos.'%')->orWhere('employeeName', 'LIKE', '%'.$datos.'%')->get();
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
        $typeSalida = $request->input('typeSalida');
        $datos = '';

        if ($status == 'Baja') {
            $registro = carbon::now();
            $semana = carbon::now()->week();
            personalBergsModel::where('employeeNumber', '=', $valued)->update([
                'DateSalida' => $registro, 'typeSalida' => $typeSalida, 'status' => $status, 'DaysVacationsAvailble' => 0, 'lastYear' => 0, 'currentYear' => 0,
            ]);
            assistence::where('id_empleado', '=', $valued, 'AND', 'Status', '=', 'Baja', 'AND', 'week', '=', $semana)->delete();
            UpdateRotacionJob::dispatch();
        } else {

            $datosAdd = personalBergsModel::where('employeeNumber', '=', $valued)->update([
                'employeeNumber' => 'i'.$id_empleado,
                'employeeName' => $name,
                'employeeArea' => $area,
                'employeeLider' => $lider,
                'typeWorker' => $tipoDeTrabajador,
                'Gender' => $Genero,
                'status' => $status,
                'DateSalida' => null,

            ]);

            if ($datosAdd) {
                $datos = 'realizado';
            } else {
                $datos = 'error // no cambio de empleado';
            }
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

        $spreadsheet = new Spreadsheet;
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
        // ok
        $sheets->setCellValue('B2', assistence::where('week', $week)->where('lunes', 'OK')->count());
        $sheets->setCellValue('C2', assistence::where('week', $week)->where('martes', 'OK')->count());
        $sheets->setCellValue('D2', assistence::where('week', $week)->where('miercoles', 'OK')->count());
        $sheets->setCellValue('E2', assistence::where('week', $week)->where('jueves', 'OK')->count());
        $sheets->setCellValue('F2', assistence::where('week', $week)->where('viernes', 'OK')->count());
        $sheets->setCellValue('G2', assistence::where('week', $week)->where('sabado', 'OK')->count());
        $sheets->setCellValue('H2', assistence::where('week', $week)->where('domingo', 'OK')->count());
        // f
        $sheets->setCellValue('B3', assistence::where('week', $week)->where('lunes', 'F')->count());
        $sheets->setCellValue('C3', assistence::where('week', $week)->where('martes', 'F')->count());
        $sheets->setCellValue('D3', assistence::where('week', $week)->where('miercoles', 'F')->count());
        $sheets->setCellValue('E3', assistence::where('week', $week)->where('jueves', 'F')->count());
        $sheets->setCellValue('F3', assistence::where('week', $week)->where('viernes', 'F')->count());
        $sheets->setCellValue('G3', assistence::where('week', $week)->where('sabado', 'F')->count());
        $sheets->setCellValue('H3', assistence::where('week', $week)->where('domingo', 'F')->count());
        // PSS
        $sheets->setCellValue('B4', assistence::where('week', $week)->where('lunes', 'PSS')->count());
        $sheets->setCellValue('C4', assistence::where('week', $week)->where('martes', 'PSS')->count());
        $sheets->setCellValue('D4', assistence::where('week', $week)->where('miercoles', 'PSS')->count());
        $sheets->setCellValue('E4', assistence::where('week', $week)->where('jueves', 'PSS')->count());
        $sheets->setCellValue('F4', assistence::where('week', $week)->where('viernes', 'PSS')->count());
        $sheets->setCellValue('G4', assistence::where('week', $week)->where('sabado', 'PSS')->count());
        $sheets->setCellValue('H4', assistence::where('week', $week)->where('domingo', 'PSS')->count());
        // PCS
        $sheets->setCellValue('B5', assistence::where('week', $week)->where('lunes', 'PCS')->count());
        $sheets->setCellValue('C5', assistence::where('week', $week)->where('martes', 'PCS')->count());
        $sheets->setCellValue('D5', assistence::where('week', $week)->where('miercoles', 'PCS')->count());
        $sheets->setCellValue('E5', assistence::where('week', $week)->where('jueves', 'PCS')->count());
        $sheets->setCellValue('F5', assistence::where('week', $week)->where('viernes', 'PCS')->count());
        $sheets->setCellValue('G5', assistence::where('week', $week)->where('sabado', 'PCS')->count());
        $sheets->setCellValue('H5', assistence::where('week', $week)->where('domingo', 'PCS')->count());
        // INC
        $sheets->setCellValue('B6', assistence::where('week', $week)->where('lunes', 'INC')->count());
        $sheets->setCellValue('C6', assistence::where('week', $week)->where('martes', 'INC')->count());
        $sheets->setCellValue('D6', assistence::where('week', $week)->where('miercoles', 'INC')->count());
        $sheets->setCellValue('E6', assistence::where('week', $week)->where('jueves', 'INC')->count());
        $sheets->setCellValue('F6', assistence::where('week', $week)->where('viernes', 'INC')->count());
        $sheets->setCellValue('G6', assistence::where('week', $week)->where('sabado', 'INC')->count());
        $sheets->setCellValue('H6', assistence::where('week', $week)->where('domingo', 'INC')->count());
        // V
        $sheets->setCellValue('B7', assistence::where('week', $week)->where('lunes', 'V')->count());
        $sheets->setCellValue('C7', assistence::where('week', $week)->where('martes', 'V')->count());
        $sheets->setCellValue('D7', assistence::where('week', $week)->where('miercoles', 'V')->count());
        $sheets->setCellValue('E7', assistence::where('week', $week)->where('jueves', 'V')->count());
        $sheets->setCellValue('F7', assistence::where('week', $week)->where('viernes', 'V')->count());
        $sheets->setCellValue('G7', assistence::where('week', $week)->where('sabado', 'V')->count());
        $sheets->setCellValue('H7', assistence::where('week', $week)->where('domingo', 'V')->count());
        // R
        $sheets->setCellValue('B8', assistence::where('week', $week)->where('lunes', 'R')->count());
        $sheets->setCellValue('C8', assistence::where('week', $week)->where('martes', 'R')->count());
        $sheets->setCellValue('D8', assistence::where('week', $week)->where('miercoles', 'R')->count());
        $sheets->setCellValue('E8', assistence::where('week', $week)->where('jueves', 'R')->count());
        $sheets->setCellValue('F8', assistence::where('week', $week)->where('viernes', 'R')->count());
        $sheets->setCellValue('G8', assistence::where('week', $week)->where('sabado', 'R')->count());
        $sheets->setCellValue('H8', assistence::where('week', $week)->where('domingo', 'R')->count());
        // SUS
        $sheets->setCellValue('B9', assistence::where('week', $week)->where('lunes', 'SUS')->count());
        $sheets->setCellValue('C9', assistence::where('week', $week)->where('martes', 'SUS')->count());
        $sheets->setCellValue('D9', assistence::where('week', $week)->where('miercoles', 'SUS')->count());
        $sheets->setCellValue('E9', assistence::where('week', $week)->where('jueves', 'SUS')->count());
        $sheets->setCellValue('F9', assistence::where('week', $week)->where('viernes', 'SUS')->count());
        $sheets->setCellValue('G9', assistence::where('week', $week)->where('sabado', 'SUS')->count());
        $sheets->setCellValue('H9', assistence::where('week', $week)->where('domingo', 'SUS')->count());
        // TSP
        $sheets->setCellValue('B10', assistence::where('week', $week)->where('lunes', 'TSP')->count());
        $sheets->setCellValue('C10', assistence::where('week', $week)->where('martes', 'TSP')->count());
        $sheets->setCellValue('D10', assistence::where('week', $week)->where('miercoles', 'TSP')->count());
        $sheets->setCellValue('E10', assistence::where('week', $week)->where('jueves', 'TSP')->count());
        $sheets->setCellValue('F10', assistence::where('week', $week)->where('viernes', 'TSP')->count());
        $sheets->setCellValue('G10', assistence::where('week', $week)->where('sabado', 'TSP')->count());
        $sheets->setCellValue('H10', assistence::where('week', $week)->where('domingo', 'TSP')->count());
        // PCT
        $sheets->setCellValue('B11', assistence::where('week', $week)->where('lunes', 'PCT')->count());
        $sheets->setCellValue('C11', assistence::where('week', $week)->where('martes', 'PCT')->count());
        $sheets->setCellValue('D11', assistence::where('week', $week)->where('miercoles', 'PCT')->count());
        $sheets->setCellValue('E11', assistence::where('week', $week)->where('jueves', 'PCT')->count());
        $sheets->setCellValue('F11', assistence::where('week', $week)->where('viernes', 'PCT')->count());
        $sheets->setCellValue('G11', assistence::where('week', $week)->where('sabado', 'PCT')->count());
        $sheets->setCellValue('H11', assistence::where('week', $week)->where('domingo', 'PCT')->count());
        // ASM
        $sheets->setCellValue('B12', assistence::where('week', $week)->where('lunes', 'ASM')->count());
        $sheets->setCellValue('C12', assistence::where('week', $week)->where('martes', 'ASM')->count());
        $sheets->setCellValue('D12', assistence::where('week', $week)->where('miercoles', 'ASM')->count());
        $sheets->setCellValue('E12', assistence::where('week', $week)->where('jueves', 'ASM')->count());
        $sheets->setCellValue('F12', assistence::where('week', $week)->where('viernes', 'ASM')->count());
        $sheets->setCellValue('G12', assistence::where('week', $week)->where('sabado', 'ASM')->count());
        $sheets->setCellValue('H12', assistence::where('week', $week)->where('domingo', 'ASM')->count());
        // SCE
        $sheets->setCellValue('B13', assistence::where('week', $week)->where('lunes', 'SCE')->count());
        $sheets->setCellValue('C13', assistence::where('week', $week)->where('martes', 'SCE')->count());
        $sheets->setCellValue('D13', assistence::where('week', $week)->where('miercoles', 'SCE')->count());
        $sheets->setCellValue('E13', assistence::where('week', $week)->where('jueves', 'SCE')->count());
        $sheets->setCellValue('F13', assistence::where('week', $week)->where('viernes', 'SCE')->count());
        $sheets->setCellValue('G13', assistence::where('week', $week)->where('sabado', 'SCE')->count());
        $sheets->setCellValue('H13', assistence::where('week', $week)->where('domingo', 'SCE')->count());
        // TE
        $sheets->setCellValue('B14', assistence::where('week', $week)->SUM('extLunes'));
        $sheets->setCellValue('C14', assistence::where('week', $week)->sum('extMartes'));
        $sheets->setCellValue('D14', assistence::where('week', $week)->sum('extMiercoles'));
        $sheets->setCellValue('E14', assistence::where('week', $week)->sum('extJueves'));
        $sheets->setCellValue('F14', assistence::where('week', $week)->sum('extViernes'));
        $sheets->setCellValue('G14', assistence::where('week', $week)->sum('extSabado'));
        $sheets->setCellValue('H14', assistence::where('week', $week)->sum('extDomingo'));
        // TPT
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
            'm1' => 'Bono de puntualidad',
        ];

        foreach ($leaders as $l) {
            // Crear hoja por líder
            $sheet = $spreadsheet->createSheet();
            $leader = explode(' ', $l->lider)[0] ?? str_split($l->lider, 5)[0];
            $sheet->setTitle($leader);

            // Agregar encabezados
            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Estilo para encabezados
            $headerStyle = [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFB0C4DE'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],

                ],
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
                $sheet->setCellValue('A'.$row, $d->name);
                $sheet->setCellValue('b'.$row, substr($d->id_empleado, 1));
                $sheet->setCellValue('c'.$row, $d->lunes);
                $sheet->setCellValue('d'.$row, $d->martes);
                $sheet->setCellValue('e'.$row, $d->miercoles);
                $sheet->setCellValue('f'.$row, $d->jueves);
                $sheet->setCellValue('g'.$row, $d->viernes);
                $sheet->setCellValue('h'.$row, $d->sabado);
                $sheet->setCellValue('i'.$row, $d->domingo);
                $sheet->setCellValue('j'.$row, $d->extras);
                $sheet->setCellValue('k'.$row, $d->tiempoPorTiempo);
                $sheet->setCellValue('l'.$row, $d->bonoAsistencia);
                $sheet->setCellValue('m'.$row, $d->bonoPuntualidad);
                $row++;
            }
        }

        // Enviar archivo
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Reporte_incidencias_semana_'.$week.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function relogChecador(Request $request)
    {
        $value = session('user');
        $cat = session('categoria');
        $dateRelog = $request->input('datepicker');
        $datosRelog = $registroRelog = [];
        $i = 0;
        $weekNum = Carbon::now()->weekOfYear;

        if (empty($value)) {
            return redirect('/');
        }
        $dia = carbon::now()->format('Y-m-d');
        // $datosRelog = DB::table('relogchecador')->get();if ($dateRelog != '') {
        if ($dateRelog != '') {
            $datosRelog = relogChecadorModel::where('fechaRegistro', '=', $dateRelog)->get();

        } else {
            $datosRelog = relogChecadorModel::where('fechaRegistro', '=', $dia)->get();
        }
        foreach ($datosRelog as $d) {
            $registroRelog[$i]['empelado'] = $d->employeeNumber;
            $registroRelog[$i]['entrada'] = $d->entrada;
            $registroRelog[$i]['salida'] = $d->salida ?? 0;
            $personal = personalBergsModel::select('typeWorker')->where('employeeNumber', $d->employeeNumber)->first();
            if ($personal->typeWorker == 'Directo') {
                $registroRelog[$i]['retardo'] = $d->entrada <= '07:30:59' ? 0 : carbon::parse($d->entrada)->diffInMinutes(carbon::parse('07:30:59'));
            } else {
                $registroRelog[$i]['retardo'] = $d->entrada <= '08:00:59' ? 0 : carbon::parse($d->entrada)->diffInMinutes(carbon::parse('08:00:00'));
            }
            $registroRelog[$i]['totalHoras'] = round(carbon::parse($d->entrada)->diffInMinutes(carbon::parse($d->salida ?? carbon::now())) / 60, 2) ?? 0;
            $registroRelog[$i]['desayuno'] = carbon::parse($d->desayunoSalida)->diffInMinutes(carbon::parse($d->desayunoEntrada)) ?? 0;
            $registroRelog[$i]['comida'] = carbon::parse($d->comidaSalida)->diffInMinutes(carbon::parse($d->comidaEntrada)) ?? 0;
            $permisos = (carbon::parse($d->permisoSalida)->diffInMinutes(carbon::parse($d->permisoEntrada)) ?? 0);
            $permisos += (carbon::parse($d->permiso2Salida)->diffInMinutes(carbon::parse($d->permiso2Entrada)) ?? 0);
            $permisos += (carbon::parse($d->permiso3Salida)->diffInMinutes(carbon::parse($d->permiso3Entrada)) ?? 0);
            $registroRelog[$i]['permisos'] = $permisos ?? 0;
            $registroRelog[$i]['comentario'] = $d->comentario ?? 0;
            $i++;
        }

        return view('juntas.hrDocs.relojChecador', ['weekNum' => $weekNum, 'cat' => $cat, 'value' => $value,
            'registroRelog' => $registroRelog, 'dateRelog' => $dateRelog]);
    }

    public function datosPersonal(Request $request)
    {
        $value = session('user');
        $cat = session('categoria');
        $numeroDeEmpleado = 'i'.$request->input('empleado');
        $weekless6months = Carbon::now()->subMonths(6)->weekOfYear;
        $yearless6months = Carbon::now()->subMonths(6)->year;
        $year = Carbon::now()->year;
        $tipos = [];
        if (empty($value)) {
            return redirect('/');
        }
        if (empty($numeroDeEmpleado)) {
            return view('juntas.hrDocs.controlPersonal', ['cat' => $cat, 'value' => $value]);
        } else {
            $personalDatos = personalBergsModel::where('employeeNumber', '=', $numeroDeEmpleado)->first();
            $vaciones = registroVacacionesModel::where('id_empleado', '=', $numeroDeEmpleado)->limit(20)->orderBy('id', 'desc')->get();
            $comportatiento = assistence::select('lunes', 'martes', 'miercoles', 'jueves', 'viernes')
                ->where('id_empleado', $numeroDeEmpleado)
                ->where(function ($q) use ($yearless6months, $year, $weekless6months) {
                    if ($yearless6months != $year) {
                        $q->where([
                            ['week', '>=', $weekless6months],
                            ['yearOfAssistence', '=', $yearless6months],
                        ])->orWhere('yearOfAssistence', '=', $year);
                    } else {
                        $q->where([
                            ['week', '>=', $weekless6months],
                            ['yearOfAssistence', '=', $year],
                        ]);
                    }
                })
                ->orderBy('week', 'asc')
                ->get();
            $tipos = [
                'OK' => 0,
                'R' => 0,
                'PCS' => 0,
                'V' => 0,
                'F' => 0,
                'INC' => 0,
                'SUS' => 0,
            ];

            foreach ($comportatiento as $c) {
                foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes'] as $dia) {
                    if (! empty($c->$dia) && $c->$dia != '-') {
                        if ($c->$dia == 'PSS') {
                            $tipos['PCS'] = ($tipos[$c->$dia] ?? 0) + 1;
                        } else {
                            $tipos[$c->$dia] = ($tipos[$c->$dia] ?? 0) + 1;
                        }
                    }
                }
            }
            ksort($tipos);

            return view('juntas.hrDocs.controlPersonal', ['cat' => $cat, 'value' => $value, 'personalDatos' => $personalDatos,
                'vaciones' => $vaciones, 'tipos' => $tipos]);
        }

    }

    public function excelRelogChecador(Request $request)
    {
        $week = $request->input('semana');
        $diaInicialSemana = Carbon::now()->setISODate(Carbon::now()->year, $week, 1);
        $diaInicialSemana = Carbon::parse($diaInicialSemana)->format('Y-m-d 00:00:00');
        $diaFinalSemana = Carbon::now()->setISODate(Carbon::now()->year, $week, 7);
        $diaFinalSemana = Carbon::parse($diaFinalSemana)->format('Y-m-d 23:59:59');
        // dd($diaFinalSemana.' '.$diaInicialSemana);
        $datosdelPersonalAcumulado = [];

        $spreadsheet = new Spreadsheet;
        $sheets = $spreadsheet->getActiveSheet();
        foreach (range('A', 'Z') as $col) {
            $sheets->getColumnDimension($col)->setAutoSize(true);
        }
        $sheets->setTitle('Reloj Checador Semanal ');
        $sheets->setCellValue('A1', 'Numero de empleado');
        $sheets->setCellValue('B1', 'Dias de la semana');
        $sheets->setCellValue('C1', 'Hora de entrada');
        $sheets->setCellValue('D1', 'Hora de salida');
        $sheets->setCellValue('E1', 'Tiempo en planta (Horas)');
        $sheets->setCellValue('F1', 'Tiempo de desayuno (minutos)');
        $sheets->setCellValue('G1', 'Tiempo de comida (minutos)');
        $sheets->setCellValue('H1', 'Tiempo de permiso (minutos)');
        $sheets->setCellValue('I1', 'Tiempo de retardo (minutos)');
        $sheets->setCellValue('J1', 'Horas extra (horas)');
        $sheets->setCellValue('K1', 'Horas extra reales (horas)');
        $sheets->setCellValue('L1', 'Comentarios');

        $i = 2;        // Get data for times
        $datosTotales = relogChecadorModel::whereBetween('fechaRegistro', [$diaInicialSemana, $diaFinalSemana])->orderBy('employeeNumber', 'asc')->get();
        foreach ($datosTotales as $d) {
            $tiempoPlanta = round(carbon::parse($d->entrada)->diffInMinutes(carbon::parse($d->salida ?? carbon::now())) / 60, 2) ?? 0;
            $desayuno = carbon::parse($d->desayunoSalida)->diffInMinutes(carbon::parse($d->desayunoEntrada)) ?? 0;
            $comida = carbon::parse($d->comidaSalida)->diffInMinutes(carbon::parse($d->comidaEntrada)) ?? 0;
            $permisos = (carbon::parse($d->permisoSalida)->diffInMinutes(carbon::parse($d->permisoEntrada)) ?? 0);
            $permisos += (carbon::parse($d->permiso2Salida)->diffInMinutes(carbon::parse($d->permiso2Entrada)) ?? 0);
            $permisos += (carbon::parse($d->permiso3Salida)->diffInMinutes(carbon::parse($d->permiso3Entrada)) ?? 0);
            $retardos = carbon::parse($d->retardoSalida)->diffInMinutes(carbon::parse($d->retardoEntrada)) ?? 0;
            $personal = personalBergsModel::select('typeWorker')->where('employeeNumber', $d->employeeNumber)->first();
            if ($personal->typeWorker == 'Directo') {
                $retardos = $d->entrada <= '07:30:59' ? 0 : carbon::parse($d->entrada)->diffInMinutes(carbon::parse('07:30:59'));
            } else {
                $retardos = $d->entrada <= '08:00:59' ? 0 : carbon::parse($d->entrada)->diffInMinutes(carbon::parse('08:00:00'));
            }
            $horasExtras = $tiempoPlanta > 10 ? $tiempoPlanta - 10 : 0;
            $horasExtrasReales = $tiempoPlanta > 10 ? $tiempoPlanta - (10 + round($permisos / 60, 2)) : 0;
            if (array_key_exists($d->employeeNumber, $datosdelPersonalAcumulado)) {
                $datosdelPersonalAcumulado[$d->employeeNumber]['tiempoPlanta'] += $tiempoPlanta;
                $datosdelPersonalAcumulado[$d->employeeNumber]['desayuno'] += $desayuno;
                $datosdelPersonalAcumulado[$d->employeeNumber]['comida'] += $comida;
                $datosdelPersonalAcumulado[$d->employeeNumber]['permisos'] += $permisos;
                $datosdelPersonalAcumulado[$d->employeeNumber]['retardos'] += $retardos;
                $datosdelPersonalAcumulado[$d->employeeNumber]['horasExtras'] += $horasExtras;
                $datosdelPersonalAcumulado[$d->employeeNumber]['horasExtrasReales'] += $horasExtrasReales;
            } else {
                $datosdelPersonalAcumulado[$d->employeeNumber]['tiempoPlanta'] = $tiempoPlanta;
                $datosdelPersonalAcumulado[$d->employeeNumber]['desayuno'] = $desayuno;
                $datosdelPersonalAcumulado[$d->employeeNumber]['comida'] = $comida;
                $datosdelPersonalAcumulado[$d->employeeNumber]['permisos'] = $permisos;
                $datosdelPersonalAcumulado[$d->employeeNumber]['retardos'] = $retardos;
                $datosdelPersonalAcumulado[$d->employeeNumber]['horasExtras'] = $horasExtras;
                $datosdelPersonalAcumulado[$d->employeeNumber]['horasExtrasReales'] = $horasExtrasReales;
            }

            $sheets->setCellValue('A'.$i, $d->employeeNumber);
            $sheets->setCellValue('B'.$i, $d->fechaRegistro);
            $sheets->setCellValue('C'.$i, $d->entrada);
            $sheets->setCellValue('D'.$i, $d->salida);
            $sheets->setCellValue('E'.$i, $tiempoPlanta);
            $sheets->setCellValue('F'.$i, $desayuno);
            $sheets->setCellValue('G'.$i, $comida);
            $sheets->setCellValue('H'.$i, $permisos);
            $sheets->setCellValue('I'.$i, $retardos);
            $sheets->setCellValue('J'.$i, $horasExtras);
            $sheets->setCellValue('K'.$i, $horasExtrasReales);
            $sheets->setCellValue('L'.$i, $d->comentario);
            $i++;
        }

        // Crear hoja para totales
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Totales por semana');
        $sheet->setCellValue('A1', 'Numero de empleado');
        $sheet->setCellValue('B1', 'Tiempo Total en planta (Horas)');
        $sheet->setCellValue('C1', 'Tiempo Total de desayuno (minutos)');
        $sheet->setCellValue('D1', 'Tiempo Total de comida (minutos)');
        $sheet->setCellValue('E1', 'Tiempo Total de permiso (minutos)');
        $sheet->setCellValue('F1', 'Tiempo Total de retardo (minutos)');
        $sheet->setCellValue('G1', 'Horas extra (horas)');
        $sheet->setCellValue('H1', 'Horas extra reales (horas)');

        foreach (range('A', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Agregar datos
        $row = 2;
        foreach ($datosdelPersonalAcumulado as $key => $value) {
            $sheet->setCellValue('A'.$row, $key);
            $sheet->setCellValue('B'.$row, $value['tiempoPlanta']);
            $sheet->setCellValue('C'.$row, $value['desayuno']);
            $sheet->setCellValue('D'.$row, $value['comida']);
            $sheet->setCellValue('E'.$row, $value['permisos']);
            $sheet->setCellValue('F'.$row, $value['retardos']);
            $sheet->setCellValue('G'.$row, $value['horasExtras']);
            $sheet->setCellValue('H'.$row, $value['horasExtrasReales']);
            $row++;
        }

        // Enviar archivo
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Reporte_incidencias_semana_'.$week.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function exportarListaAsistencia(Request $request)
    {
        // Zona horaria
        date_default_timezone_set('America/Mexico_City');
        // semana pedida
        $week = $request->input('numeroSemanaIncidencias');
        // Fechas de la semana
        $datestart = Carbon::now()->setISODate(Carbon::now()->year, $week, 1)->format('Y-m-d');
        $datefin = Carbon::now()->setISODate(Carbon::now()->year, $week, 7)->format('Y-m-d');
        $dias = [];
        for ($i = 0; $i < 7; $i++) {
            $dias[] = Carbon::now()->setISODate(Carbon::now()->year, $week, $i + 1)->format('d-m');
        }
        $lider = personalBergsModel::select('employeeLider')
            ->groupBy('employeeLider')
            ->get();
        if (empty($lider)) {
            return redirect()->route('rrhhDashBoard');
        }
        foreach ($lider as $l) {
            $arealider = personalBergsModel::select('employeeArea')
                ->where('employeeName', '=', $l->employeeLider)
                ->limit(1)
                ->first();
            $l->areas = $arealider;
        }

        // Cargar Excel UNA vez
        $archivo = storage_path('app/asistencia.xlsx');
        $spreadsheet = IOFactory::load($archivo);

        // dd($lider);
        // Hoja principal (GENERAL)
        $plantilla = $spreadsheet->getActiveSheet();
        $plantilla->setTitle('GENERAL');

        // Crear hoja por líder
        foreach ($lider as $l) {

            $sheet = clone $plantilla;

            $nombreHoja = strtoupper(
                trim(
                    explode(' ', $l->employeeLider)[0].' '.
                    (explode(' ', $l->employeeLider)[2] ?? '')
                )
            );

            $sheet->setTitle($nombreHoja);
            $spreadsheet->addSheet($sheet);

            // Encabezados
            $sheet->setCellValue('C6', $l->areas['employeeArea'] ?? 'Sin área');
            $sheet->setCellValue('J6', $l->employeeLider);
            $sheet->setCellValue('D8', $week);
            $sheet->setCellValue('G8', $datestart);
            $sheet->setCellValue('M8', $datefin);

            $sheet->setCellValue('C11', $dias[0]);
            $sheet->setCellValue('D11', $dias[1]);
            $sheet->setCellValue('E11', $dias[2]);
            $sheet->setCellValue('F11', $dias[3]);
            $sheet->setCellValue('G11', $dias[4]);
            $sheet->setCellValue('H11', $dias[5]);
            $sheet->setCellValue('I11', $dias[6]);

            // Datos
            $asistencias = DB::table('assistence')
                ->where('week', $week)
                ->where('lider', $l->employeeLider)
                ->get();

            $t = 12;

            foreach ($asistencias as $row) {
                $headerStyle = [
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],

                    ],
                ];

                foreach (range('A', 'Z') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                $diasSemana = [
                    'lunes' => strtoupper(str_replace('-', '', $row->lunes)),
                    'martes' => strtoupper(str_replace('-', '', $row->martes)),
                    'miercoles' => strtoupper(str_replace('-', '', $row->miercoles)),
                    'jueves' => strtoupper(str_replace('-', '', $row->jueves)),
                    'viernes' => strtoupper(str_replace('-', '', $row->viernes)),
                    'sabado' => strtoupper(str_replace('-', '', $row->sabado)),
                    'domingo' => strtoupper(str_replace('-', '', $row->domingo)),
                ];

                $sheet->setCellValue('A'.$t, $row->name);
                $sheet->setCellValue('B'.$t, substr($row->id_empleado, 1));
                $sheet->setCellValue('C'.$t, $diasSemana['lunes']);
                $sheet->setCellValue('D'.$t, $diasSemana['martes']);
                $sheet->setCellValue('E'.$t, $diasSemana['miercoles']);
                $sheet->setCellValue('F'.$t, $diasSemana['jueves']);
                $sheet->setCellValue('G'.$t, $diasSemana['viernes']);
                $sheet->setCellValue('H'.$t, $diasSemana['sabado']);
                $sheet->setCellValue('I'.$t, $diasSemana['domingo']);
                $sheet->setCellValue('J'.$t, $row->extras);
                $sheet->setCellValue('K'.$t, $row->tiempoPorTiempo);

                if (in_array('R', $diasSemana)) {
                    $sheet->setCellValue('L'.$t, 'NO');
                    $sheet->setCellValue('N'.$t, 'NOK');
                    $sheet->setCellValue('P'.$t, 'NOK');
                } elseif (in_array('F', $diasSemana)) {
                    $sheet->setCellValue('L'.$t, 'SI');
                    $sheet->setCellValue('N'.$t, 'NOK');
                    $sheet->setCellValue('P'.$t, 'NOK');
                } else {
                    $sheet->setCellValue('L'.$t, 'NO');
                    $sheet->setCellValue('M'.$t, 'OK');
                    $sheet->setCellValue('O'.$t, 'OK');
                }

                $t++;
            }

            $t += 1;
            // concatenar celdad

            $sheet->setCellValue('A'.$t, 'CONCEPTO ');
            $sheet->setCellValue('B'.$t, 'CODIGO');
            $sheet->mergeCells('C'.$t.':K'.$t);
            $sheet->setCellValue('C'.$t, 'INSTRUCCIONES');
            $sheet->mergeCells('L'.$t.':P'.$t);
            $sheet->setCellValue('L'.$t, 'OBSERVACIONES');
            $t = $t + 1;
            $sheet->setCellValue('A'.$t, 'HORAS DOBLES');
            $sheet->setCellValue('B'.$t, '# HORAS');
            $sheet->mergeCells('C'.$t.':K'.$t);
            $sheet->setCellValue('C'.$t, 'DE 1 A 9 HORAS EXTRAS');
            $sheet->mergeCells('L'.$t.':P'.$t);
            $t = $t + 1;
            $sheet->setCellValue('A'.$t, 'HORAS TRIPLES');
            $sheet->setCellValue('B'.$t, '# HORAS');
            $sheet->mergeCells('C'.$t.':K'.$t);
            $sheet->setCellValue('C'.$t, 'APARTIR DE LA DECIMA HORA EXTRA');
            $sheet->mergeCells('L'.$t.':P'.$t);
            $t = $t + 1;
            $sheet->setCellValue('A'.$t, 'RETARDO');
            $sheet->setCellValue('B'.$t, 'R');
            $sheet->mergeCells('C'.$t.':K'.$t);
            $sheet->setCellValue('C'.$t, 'CONSIDERAR SOLO 5 MINUTOS DE TOLERANCIA');
            $sheet->mergeCells('L'.$t.':P'.$t);
            $t = $t + 1;
            $sheet->setCellValue('A'.$t, 'FALTA INJUSTIFICADA');
            $sheet->setCellValue('B'.$t, 'F');
            $sheet->mergeCells('C'.$t.':K'.$t);
            $sheet->setCellValue('C'.$t, 'NO ASISTENCIA');
            $sheet->mergeCells('L'.$t.':P'.$t);
            $t = $t + 1;
            $sheet->setCellValue('A'.$t, 'PERMISO SIN GOCE DE SUELDO');
            $sheet->setCellValue('B'.$t, 'PSS');
            $sheet->mergeCells('C'.$t.':K'.$t);
            $sheet->setCellValue('C'.$t, 'CUANDO COMRUEBAN MEDIANTE IMSS O SE DA UN PERMISO ESPECIAL PERO QUE SE COMPRUEBE CON DOCUMENTO OFICIAL');
            $sheet->mergeCells('L'.$t.':P'.$t);
            $t = $t + 1;

            $sheet->setCellValue('A'.$t, 'PERMISO CON GOCE DE SUELDO');
            $sheet->setCellValue('B'.$t, 'PCS');
            $sheet->mergeCells('C'.$t.':K'.$t);
            $sheet->setCellValue('C'.$t, 'PERMISOS CON GOCE DE SUELDO COMO: MATRIMONIO/ FALLECIMIENTO/ PATERNIDAD/ INC INTERNA');
            $sheet->mergeCells('L'.$t.':P'.$t);
            $t = $t + 1;
            $sheet->setCellValue('A'.$t, 'VACACION');
            $sheet->setCellValue('B'.$t, 'V');
            $sheet->mergeCells('C'.$t.':K'.$t);
            $sheet->setCellValue('C'.$t, 'CUANDO SE APLICA POR VACACION CON LA SOLICITUD PREVIA (SOLICITUD/OA)');
            $sheet->mergeCells('L'.$t.':P'.$t);
            $t = $t + 1;
            $sheet->setCellValue('A'.$t, 'INCAPACIDAD');
            $sheet->setCellValue('B'.$t, 'INC');
            $sheet->mergeCells('C'.$t.':K'.$t);
            $sheet->setCellValue('C'.$t, 'INCAPACIDAD POR ENFERMEDAD GENERAL IMSS');
            $sheet->mergeCells('L'.$t.':P'.$t);
            $sheet->getStyle('A10:P'.$t)->applyFromArray($headerStyle);
            $t = $t + 2;
            $sheet->mergeCells('A'.$t.':B'.$t);
            $sheet->setCellValue('A'.$t, '____________________________________________');
            $sheet->mergeCells('D'.$t.':F'.$t);
            $sheet->setCellValue('D'.$t, '____________________________________________');
            $sheet->mergeCells('H'.$t.':J'.$t);
            $sheet->setCellValue('H'.$t, '____________________________________________');
            $sheet->mergeCells('L'.$t.':O'.$t);
            $sheet->setCellValue('L'.$t, '____________________________________________');
            $t = $t + 1;

            $sheet->mergeCells('A'.$t.':B'.$t);
            $sheet->setCellValue('A'.$t, 'Autorizacion LIDER');
            $sheet->mergeCells('D'.$t.':F'.$t);
            $sheet->setCellValue('D'.$t, 'Autorizacion SUPERVISOR');
            $sheet->mergeCells('H'.$t.':J'.$t);
            $sheet->setCellValue('H'.$t, 'Autorizacion GERENTE DE AREA');
            $sheet->mergeCells('L'.$t.':O'.$t);
            $sheet->setCellValue('L'.$t, 'Autorizacion RH');
            $t = $t + 1;

            $sheet->mergeCells('A'.$t.':B'.$t);
            $sheet->setCellValue('A'.$t, $lider[0]->employeeName);
            $sheet->mergeCells('D'.$t.':F'.$t);
            $sheet->setCellValue('D'.$t, $lider[0]->employeeLider);
            $sheet->mergeCells('I'.$t.':N'.$t);
            $sheet->setCellValue('I'.$t, 'GUILLEN MIRANDA JUAN JOSE');
            $sheet->mergeCells('L'.$t.':O'.$t);
            $sheet->setCellValue('L'.$t, 'AGUILAR HERNANDEZ ANA PAOLA');
        }

        // Descargar
        $writer = new Xlsx($spreadsheet);
        $fileName = "Reporte de asistencias semana {$week}.xlsx";

        return Response::streamDownload(
            fn () => $writer->save('php://output'),
            $fileName,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }

    public function exportarListaAsistenciaIndividual(Request $request)
    {

        $value = session('user');
        // Zona horaria
        date_default_timezone_set('America/Mexico_City');
        // semana pedida
        $week = $request->input('numeroSemanaIncidencias');
        $fecha = Carbon::now()->format('d-m-Y');
        // Fechas de la semana
        $datestart = Carbon::now()->setISODate(Carbon::now()->year, $week, 1)->format('Y-m-d');
        $datefin = Carbon::now()->setISODate(Carbon::now()->year, $week, 7)->format('Y-m-d');
        $dias = [];
        for ($i = 0; $i < 7; $i++) {
            $dias[] = Carbon::now()->setISODate(Carbon::now()->year, $week, $i + 1)->format('d-m');
        }
        $lider = personalBergsModel::select('employeeLider', 'employeeName', 'employeeArea')
            ->where('user', '=', $value)
            ->get();
        if (empty($lider)) {
            return redirect()->route('rrhhDashBoard');
        }

        // Cargar Excel UNA vez
        $archivo = storage_path('app/asistencia.xlsx');
        $spreadsheet = IOFactory::load($archivo);

        // dd($lider);
        // Hoja principal (GENERAL)
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($lider[0]->employeeName);

        // $sheet->setTitle($nombreHoja);

        // Encabezados
        $sheet->setCellValue('p1', $fecha);
        $sheet->setCellValue('C6', $lider[0]->employeeArea ?? 'Sin área');
        $sheet->setCellValue('J6', $lider[0]->employeeName);
        $sheet->setCellValue('D8', $week);
        $sheet->setCellValue('G8', $datestart);
        $sheet->setCellValue('M8', $datefin);

        $sheet->setCellValue('C11', $dias[0]);
        $sheet->setCellValue('D11', $dias[1]);
        $sheet->setCellValue('E11', $dias[2]);
        $sheet->setCellValue('F11', $dias[3]);
        $sheet->setCellValue('G11', $dias[4]);
        $sheet->setCellValue('H11', $dias[5]);
        $sheet->setCellValue('I11', $dias[6]);

        // Datos
        $asistencias = DB::table('assistence')
            ->where('week', $week)
            ->where('lider', $lider[0]->employeeName)
            ->get();

        $t = 12;
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],

            ],
        ];
        foreach (range('A', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        foreach ($asistencias as $row) {

            $diasSemana = [
                'lunes' => strtoupper(str_replace('-', '', $row->lunes)),
                'martes' => strtoupper(str_replace('-', '', $row->martes)),
                'miercoles' => strtoupper(str_replace('-', '', $row->miercoles)),
                'jueves' => strtoupper(str_replace('-', '', $row->jueves)),
                'viernes' => strtoupper(str_replace('-', '', $row->viernes)),
                'sabado' => strtoupper(str_replace('-', '', $row->sabado)),
                'domingo' => strtoupper(str_replace('-', '', $row->domingo)),
            ];

            $sheet->setCellValue('A'.$t, $row->name);
            $sheet->setCellValue('B'.$t, substr($row->id_empleado, 1));
            $sheet->setCellValue('C'.$t, $diasSemana['lunes']);
            $sheet->setCellValue('D'.$t, $diasSemana['martes']);
            $sheet->setCellValue('E'.$t, $diasSemana['miercoles']);
            $sheet->setCellValue('F'.$t, $diasSemana['jueves']);
            $sheet->setCellValue('G'.$t, $diasSemana['viernes']);
            $sheet->setCellValue('H'.$t, $diasSemana['sabado']);
            $sheet->setCellValue('I'.$t, $diasSemana['domingo']);
            $sheet->setCellValue('J'.$t, $row->extras);
            $sheet->setCellValue('K'.$t, $row->tiempoPorTiempo);

            if (in_array('R', $diasSemana)) {
                $sheet->setCellValue('L'.$t, 'NO');
                $sheet->setCellValue('N'.$t, 'NOK');
                $sheet->setCellValue('P'.$t, 'NOK');
            } elseif (in_array('F', $diasSemana)) {
                $sheet->setCellValue('L'.$t, 'SI');
                $sheet->setCellValue('N'.$t, 'NOK');
                $sheet->setCellValue('P'.$t, 'NOK');
            } else {
                $sheet->setCellValue('L'.$t, 'NO');
                $sheet->setCellValue('M'.$t, 'OK');
                $sheet->setCellValue('O'.$t, 'OK');
            }

            $t++;
        }

        $t += 1;
        // concatenar celdad

        $sheet->setCellValue('A'.$t, 'CONCEPTO ');
        $sheet->setCellValue('B'.$t, 'CODIGO');
        $sheet->mergeCells('C'.$t.':K'.$t);
        $sheet->setCellValue('C'.$t, 'INSTRUCCIONES');
        $sheet->mergeCells('L'.$t.':P'.$t);
        $sheet->setCellValue('L'.$t, 'OBSERVACIONES');
        $t = $t + 1;
        $sheet->setCellValue('A'.$t, 'HORAS DOBLES');
        $sheet->setCellValue('B'.$t, '# HORAS');
        $sheet->mergeCells('C'.$t.':K'.$t);
        $sheet->setCellValue('C'.$t, 'DE 1 A 9 HORAS EXTRAS');
        $sheet->mergeCells('L'.$t.':P'.$t);
        $t = $t + 1;
        $sheet->setCellValue('A'.$t, 'HORAS TRIPLES');
        $sheet->setCellValue('B'.$t, '# HORAS');
        $sheet->mergeCells('C'.$t.':K'.$t);
        $sheet->setCellValue('C'.$t, 'APARTIR DE LA DECIMA HORA EXTRA');
        $sheet->mergeCells('L'.$t.':P'.$t);
        $t = $t + 1;
        $sheet->setCellValue('A'.$t, 'RETARDO');
        $sheet->setCellValue('B'.$t, 'R');
        $sheet->mergeCells('C'.$t.':K'.$t);
        $sheet->setCellValue('C'.$t, 'CONSIDERAR SOLO 5 MINUTOS DE TOLERANCIA');
        $sheet->mergeCells('L'.$t.':P'.$t);
        $t = $t + 1;
        $sheet->setCellValue('A'.$t, 'FALTA INJUSTIFICADA');
        $sheet->setCellValue('B'.$t, 'F');
        $sheet->mergeCells('C'.$t.':K'.$t);
        $sheet->setCellValue('C'.$t, 'NO ASISTENCIA');
        $sheet->mergeCells('L'.$t.':P'.$t);
        $t = $t + 1;
        $sheet->setCellValue('A'.$t, 'PERMISO SIN GOCE DE SUELDO');
        $sheet->setCellValue('B'.$t, 'PSS');
        $sheet->mergeCells('C'.$t.':K'.$t);
        $sheet->setCellValue('C'.$t, 'CUANDO COMRUEBAN MEDIANTE IMSS O SE DA UN PERMISO ESPECIAL PERO QUE SE COMPRUEBE CON DOCUMENTO OFICIAL');
        $sheet->mergeCells('L'.$t.':P'.$t);
        $t = $t + 1;

        $sheet->setCellValue('A'.$t, 'PERMISO CON GOCE DE SUELDO');
        $sheet->setCellValue('B'.$t, 'PCS');
        $sheet->mergeCells('C'.$t.':K'.$t);
        $sheet->setCellValue('C'.$t, 'PERMISOS CON GOCE DE SUELDO COMO: MATRIMONIO/ FALLECIMIENTO/ PATERNIDAD/ INC INTERNA');
        $sheet->mergeCells('L'.$t.':P'.$t);
        $t = $t + 1;
        $sheet->setCellValue('A'.$t, 'VACACION');
        $sheet->setCellValue('B'.$t, 'V');
        $sheet->mergeCells('C'.$t.':K'.$t);
        $sheet->setCellValue('C'.$t, 'CUANDO SE APLICA POR VACACION CON LA SOLICITUD PREVIA (SOLICITUD/OA)');
        $sheet->mergeCells('L'.$t.':P'.$t);
        $t = $t + 1;
        $sheet->setCellValue('A'.$t, 'INCAPACIDAD');
        $sheet->setCellValue('B'.$t, 'INC');
        $sheet->mergeCells('C'.$t.':K'.$t);
        $sheet->setCellValue('C'.$t, 'INCAPACIDAD POR ENFERMEDAD GENERAL IMSS');
        $sheet->mergeCells('L'.$t.':P'.$t);
        $sheet->getStyle('A10:P'.$t)->applyFromArray($headerStyle);
        $t = $t + 2;
        $sheet->mergeCells('A'.$t.':B'.$t);
        $sheet->setCellValue('A'.$t, '____________________________________________');
        $sheet->mergeCells('D'.$t.':F'.$t);
        $sheet->setCellValue('D'.$t, '____________________________________________');
        $sheet->mergeCells('H'.$t.':J'.$t);
        $sheet->setCellValue('H'.$t, '____________________________________________');
        $sheet->mergeCells('L'.$t.':O'.$t);
        $sheet->setCellValue('L'.$t, '____________________________________________');
        $t = $t + 1;

        $sheet->mergeCells('A'.$t.':B'.$t);
        $sheet->setCellValue('A'.$t, 'Autorizacion LIDER');
        $sheet->mergeCells('D'.$t.':F'.$t);
        $sheet->setCellValue('D'.$t, 'Autorizacion SUPERVISOR');
        $sheet->mergeCells('H'.$t.':J'.$t);
        $sheet->setCellValue('H'.$t, 'Autorizacion GERENTE DE AREA');
        $sheet->mergeCells('L'.$t.':O'.$t);
        $sheet->setCellValue('L'.$t, 'Autorizacion RH');
        $t = $t + 1;

        $sheet->mergeCells('A'.$t.':B'.$t);
        $sheet->setCellValue('A'.$t, $lider[0]->employeeName);
        $sheet->mergeCells('D'.$t.':F'.$t);
        $sheet->setCellValue('D'.$t, $lider[0]->employeeLider);
        $sheet->mergeCells('H'.$t.':J'.$t);
        $sheet->setCellValue('H'.$t, 'GUILLEN MIRANDA JUAN JOSE');
        $sheet->mergeCells('L'.$t.':O'.$t);
        $sheet->setCellValue('L'.$t, 'AGUILAR HERNANDEZ ANA PAOLA');
        // Descargar
        $writer = new Xlsx($spreadsheet);
        $fileName = "Reporte de asistencias semana {$week}.xlsx";

        return Response::streamDownload(
            fn () => $writer->save('php://output'),
            $fileName,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }
}

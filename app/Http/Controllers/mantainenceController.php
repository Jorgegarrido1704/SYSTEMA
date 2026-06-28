<?php

namespace App\Http\Controllers;

use App\Models\personalBergsModel;
use App\Models\registo_mant;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class mantainenceController extends Controller
{
    public function index()
    {
        $cat = session('categoria') ?? '';
        $value = session('user') ?? '';
        // $manteninance = registo_mant::where('ttServ', '=', null)->get();
        $manteninance = registo_mant::all();

        return view('mantainence.qrs', ['cat' => $cat, 'value' => $value, 'manteninance' => $manteninance]);
    }

    public function excel(Request $request)
    {
        $request->validate([
            'ides' => 'required|integer',
        ]);

        $ides = $request->input('ides');
        $row = registo_mant::where('id', $ides)->first();

        if (! $row) {
            abort(404, 'Registro no encontrado');
        }

        $archivo = storage_path('app/MANTENIMIENTOESX.xlsx');
        // Ajusta la ruta real donde tengas tu plantilla, p.ej.
        // resource_path('./MANTENIMIENTOESX.xlsx')

        $spreadsheet = IOFactory::load($archivo);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('J3', $row->id_maquina);
        $sheet->setCellValue('J4', $row->area);
        $sheet->setCellValue('J6', $row->id);

        match ($row->tipoMant) {
            'MAQUINARIA' => $sheet->setCellValue('C6', 'X'),
            'SISTEMAS DE INFORMACION' => $sheet->setCellValue('C7', 'X'),
            'ESTRUCTURAS Y PLANTA' => $sheet->setCellValue('E6', 'X'),
            'PREVENTIVO' => $sheet->setCellValue('E7', 'X'),
            'PRUEBA ELECTRICA' => $sheet->setCellValue('G6', 'X'),
            'CORRECTIVO' => $sheet->setCellValue('G7', 'X'),
            default => null,
        };

        match ($row->periMant) {
            'UNA VEZ' => $sheet->setCellValue('E11', 'X'),
            'SEMANAL' => $sheet->setCellValue('C10', 'X'),
            'MENSUAL' => $sheet->setCellValue('E10', 'X'),
            'TRIMESTRAL' => $sheet->setCellValue('G10', 'X'),
            'SEMESTRAL' => $sheet->setCellValue('C11', 'X'),
            'ANUAL' => $sheet->setCellValue('G11', 'X'),
            default => null,
        };

        $sheet->setCellValue('A16', $row->descTrab);
        $sheet->setCellValue('F16', $row->equipo);
        $sheet->setCellValue('H16', $row->estatus);
        $sheet->setCellValue('I16', $row->comentarios);
        $sheet->setCellValue('C31', $row->fechReq);
        $sheet->setCellValue('C32', $row->horaIniServ);
        $sheet->setCellValue('E32', $row->horaFinServ);
        $sheet->setCellValue('H31', $row->fechReq);
        $sheet->setCellValue('H32', $row->ttServ);

        $sheet->setCellValue('A34', $row->solPor);
        $sheet->setCellValue('C34', $row->SupMant);
        $sheet->setCellValue('F34', $row->tecMant);
        $sheet->setCellValue('I34', $row->ValGer);

        $fileName = "Mantenimiento_folio_{$ides}.xlsx";
        $tempPath = storage_path("app/temp/{$fileName}");

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempPath);

        return response()->download($tempPath, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function completarForm($id)
    {
        $row = registo_mant::findOrFail($id);
        $cat = session('categoria') ?? '';
        $value = session('user') ?? '';
        $peronsal = personalBergsModel::where('status', 'Activo')->where('employeeArea', '=', 'Mantenimiento')->get();

        return view('mantainence.completar', ['row' => $row, 'cat' => $cat, 'value' => $value, 'peronsal' => $peronsal]);
    }

    public function completar(Request $request, $id)
    {
        $data = $request->validate([
            'tecMant' => 'required|string',
            'tipomant' => 'required|string',
            'PERIODO' => 'required|string',
            'desc' => 'required|string',
            'ESTATUS' => 'required|string',
            'komment' => 'required|string',
            'tiempo' => 'required|integer|min:0',
        ]);

        $row = registo_mant::findOrFail($id);

        $row->update([
            'tipoMant' => $data['tipomant'],
            'periMant' => $data['PERIODO'],
            'descTrab' => $data['desc'],
            'estatus' => $data['ESTATUS'],
            'comentarios' => $data['komment'],
            'ttServ' => $data['tiempo'],
            'ValGer' => '-',
            'tecMant' => $data['tecMant'],
        ]);

        return redirect()->route('mantainence.index')->with('success', 'Mantenimiento completado correctamente.');
    }
}

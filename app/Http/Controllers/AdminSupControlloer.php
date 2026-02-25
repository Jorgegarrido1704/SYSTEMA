<?php

namespace App\Http\Controllers;

use App\Models\routingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSupControlloer extends Controller
{
    //
    public function index_admin(Request $request)
    {
        if (session('categoria') != 'SupAdmin') {
            return redirect('/login');
        } else {
            // buscar existencia de empleados en lista de asistencia
            $asistencia = DB::table('assistence')->where('week', '=', date('W'))->get();
            $datos = [];
            foreach ($asistencia as $asist) {
                if (DB::table('personalberg')->where('employeeNumber', '=', $asist->id_empleado)->where('status', '!=', 'Baja')->notExists()) {
                    $datos[$asist->id_empleado] = $asist->name;
                }

            }
            dd($datos);

            return view('SupAdmin', ['value' => session('user'), 'cat' => session('categoria')]);
        }
    }

    public function exelCalidad(Request $request)
    {
        $di = $request->input('di');
        $df = $request->input('df');
        $datos = new caliController;
        $datos->excel_calidad($di, $df);
    }

    public function datosOrdenes(Request $request)
    {
        try {
            $buscarWo = $request->input('buscarWo');
            $datosWo = $datosPass = $pnReg = $regftq = $paretos = [];
            $tableContent = $tableReg = $tableftq = $pullTest = '';
            $i = $ok = $nog = 0;

            $buscar = DB::table('registroparcial')
                ->orWhere('pn', 'like', $buscarWo.'%')
                ->orWhere('wo', 'like', '%'.$buscarWo.'%')
                ->orWhere('pn', 'like', '%'.$buscarWo)
                ->get();

            $i = 0; // Initialize $i if it's not initialized

            foreach ($buscar as $row) {
                // Correct form ID concatenation
                $tableContent .= '<tr><form method="GET" id="form'.$i.'" name="form[]">';
                $tableContent .= '<td>'.$row->pn.'</td>';
                $tableContent .= '<td>'.$row->wo.'</td>';
                $tableContent .= '<td><input type="checkbox" id="plan'.$i.'" name="plan[]" ></td>';
                $tableContent .= '<td><input type="number" min="0" id="cortPar'.$i.'" name="cortPar[]" value="'.$row->cortPar.'" required ></td>';
                $tableContent .= '<td><input type="number" min="0" id="libePar'.$i.'" name="libePar[]" value="'.$row->libePar.'" required ></td>';
                $tableContent .= '<td><input type="number" min="0" id="ensaPar'.$i.'" name="ensaPar[]" value="'.$row->ensaPar.'" required ></td>';
                $tableContent .= '<td><input type="number" min="0" id="loomPar'.$i.'" name="loomPar[]" value="'.$row->loomPar.'" required ></td>';
                $tableContent .= '<td><input type="number" min="0" id="preCalidad'.$i.'" name="preCalidad[]" value="'.$row->preCalidad.'" required ></td>';
                $tableContent .= '<td><input type="number" min="0" id="testPar'.$i.'" name="testPar[]" value="'.$row->testPar.'" required ></td>';
                $tableContent .= '<td><input type="number" min="0" id="embPar'.$i.'" name="embPar[]" value="'.$row->embPar.'" required ></td>';
                $tableContent .= '<td><input type="number" min="0" id="eng'.$i.'" name="eng[]" value="'.$row->eng.'" required ></td>';
                $tableContent .= '<td><input type="hidden" id="wo'.$i.'" name="wo[]" value="'.$row->wo.'" >
                    <input type="button" name="enviar" value="Guardar" onclick="submitForm('.$i.')" > </form></td>';
                $tableContent .= '</tr>';
                $pnReg[$i] = $row->pn;
                $i++;
            }
            $pnReg = array_unique($pnReg);

            foreach ($pnReg as $pnR) {
                $buscarR = DB::table('retiradad')
                    ->where('np', '=', $pnR)
                    ->get();
                if (count($buscarR) > 0) {
                    foreach ($buscarR as $rowR) {
                        $tableReg .= '<tr>';
                        $tableReg .= '<td>'.$rowR->np.'</td>';
                        $tableReg .= '<td>'.$rowR->wo.'</td>';
                        $tableReg .= '<td>'.$rowR->qty.'</td>';
                        $tableReg .= '<td>'.$rowR->fechaout.'</td>';
                        $tableReg .= '</tr>';
                    }
                } else {
                    $tableReg .= '<tr>';
                    $tableReg .= '<td></td>';
                    $tableReg .= '<td>'.'0'.'</td>';
                    $tableReg .= '<td>'.'0'.'</td>';
                    $tableReg .= '<td>'.'0'.'</td>';
                    $tableReg .= '</tr>';
                }

                $registroftq = DB::table('regsitrocalidad')
                    ->where('pn', '=', $pnR)
                    ->get();
                if (count($registroftq) > 0) {
                    foreach ($registroftq as $rowftq) {
                        $codigo = $rowftq->codigo;
                        if ($codigo == 'TODO BIEN') {
                            $ok++;
                        } else {
                            $nog++;
                        }
                    }
                    if (in_array($codigo, array_keys($regftq))) {
                        $regftq[$codigo]++;
                    } else {
                        $regftq[$codigo] = 1;
                    }

                    foreach ($regftq as $key => $value) {
                        $tableftq .= '<tr>';
                        $tableftq .= '<td>'.$key.'</td>';
                        $tableftq .= '<td>'.$value.'</td>';
                        $tableftq .= '</tr>';
                    }

                    $paretos[0] = $ok;
                    $paretos[1] = $nog;
                    $paretos[2] = round($ok / ($ok + $nog) * 100, 2);

                    $buscarRegistroPull = DB::table('registro_pull')
                        ->where('Num_part', '=', $pnR)
                        ->orderBy('id', 'desc')
                        ->get();
                    if (count($buscarRegistroPull) > 0) {
                        foreach ($buscarRegistroPull as $rowPull) {

                            $pullTest .= '<tr>';
                            $pullTest .= '<td>'.$rowPull->fecha.'</td>';
                            $pullTest .= '<td>'.$rowPull->Num_part.'</td>';
                            $pullTest .= '<td>'.$rowPull->calibre.'</td>';
                            $pullTest .= '<td>'.$rowPull->presion.'</td>';
                            $pullTest .= '<td>'.$rowPull->forma.'</td>';
                            $pullTest .= '<td>'.$rowPull->cont.'</td>';
                            $pullTest .= '<td>'.$rowPull->quien.'</td>';
                            $pullTest .= '<td>'.$rowPull->val.'</td>';
                            $pullTest .= '<td>'.$rowPull->tipo.'</td>';
                        }
                    } else {
                        $pullTest = '';
                    }
                } else {
                    $paretos[0] = 0;
                    $paretos[1] = 0;
                    $paretos[2] = 0;
                    $tableftq .= '<tr>';
                    $tableftq .= '<td>'.'0'.'</td>';
                    $tableftq .= '<td>'.'0'.'</td>';
                    $tableftq .= '</tr>';
                    $regftq['no se encontro'] = 0;
                    $pullTest = '';
                }
            }

            return response()->json([
                'pullTest' => $pullTest,
                'paretos' => $paretos,
                'tableftq' => $tableftq,
                'tableContent' => $tableContent,
                'tableReg' => $tableReg,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function altaDatos(Request $request)
    {
        try {
            // Validate the incoming request data
            $wo = $request->input('wo');
            $corte = $request->input('corte');
            $liber = $request->input('liber');
            $ensa = $request->input('ensa');
            $loom = $request->input('loom');
            $pre = $request->input('pre');
            $cali = $request->input('cali');
            $emba = $request->input('emba');
            $eng = $request->input('eng');
            $plan = $request->input('plan');
            $buscar = DB::table('registro')->select('info')->where('wo', $wo)->first();

            // Extract the validated data
            if ($plan == 1) {
                DB::table('tiempos')->where('info', $buscar->info)->update(['planeacion' => '']);
                DB::table('registro')->where('wo', $wo)->update(['count' => 1, 'donde' => 'Plannig']);

                DB::table('registroparcial')->where('wo', $wo)->delete();
            } else {
                DB::table('registroparcial')->where('wo', $wo)->update([
                    'cortPar' => $corte,
                    'libePar' => $liber,
                    'ensaPar' => $ensa,
                    'loomPar' => $loom,
                    'preCalidad' => $pre,
                    'testPar' => $cali,
                    'embPar' => $emba,
                    'eng' => $eng,
                ]);
            }

            return response()->json(['success' => 'Data received and saved successfully']);
        } catch (\Exception $e) {
            // Handle any exceptions and return the error message
            return response()->json(['error' => 'An error occurred while saving data: '.$e->getMessage()]);
        }
    }

    public function vsm_schedule()
    {
        $steps = [
            ['name' => 'Customer Order', 'label' => 'Trigger', 'order' => 1],
            ['name' => 'Planning', 'label' => '1 day', 'order' => 2],
            ['name' => 'Cutting', 'label' => '1 day', 'order' => 3],
            ['name' => 'Terminals', 'label' => '1 day', 'order' => 4],
            ['name' => 'Sub-Assembly', 'label' => '1 day', 'order' => 5],
            ['name' => 'Assembly', 'label' => '1 day', 'order' => 6],
            ['name' => 'Looming', 'label' => '1 day', 'order' => 7],
            ['name' => 'Testing', 'label' => '1 day', 'order' => 8],
            ['name' => 'Packing', 'label' => '1 day', 'order' => 9],
            ['name' => 'Shipping', 'label' => '1 day', 'order' => 10],
        ];

        return view('scheduleWork.ValueStreapMap', ['steps' => $steps, 'value' => session('user'), 'cat' => session('categoria')]);
    }

    public function timeLine(Request $request)
    {
        if (session('categoria') != 'SupAdmin') {
            return redirect('/login');
        }
        $np = $request->input('np');

        if ($np) {
            $registros = routingModel::Search($np);
        } else {
            $registros = routingModel::Search('1001489409');
        }

        return view('scheduleWork.timeLine', ['registros' => $registros, 'value' => session('user'), 'cat' => session('categoria')]);
    }

    public function registrosGenerales(Request $request)
    {
        if (session('categoria') != 'SupAdmin') {
            return redirect('/login');
        } else {
            if ($request->input('setAddWeek') == 1) {
                \App\Jobs\AddWeek::dispatch();
            } elseif ($request->input('setAddWeek') == 2) {
                \App\Jobs\reporteGeneral::dispatch();
            } elseif ($request->input('setAddWeek') == 3) {
                \App\Jobs\VacacionesRegistrosJob::dispatch();
            } elseif ($request->input('setAddWeek') == 4) {
                \App\Jobs\respolados::dispatch();
            }
        }

        return redirect('/SupAdmin');
    }

    public function qualityIssues(Request $request)
    {
        try {
            $partNumberQuality = $request->input('buscarQualityIssues');

            $buscar = calidadRegistro::where('pn', $partNumberQuality)
                ->limit(100)->orderBy('id', 'desc')->get();

            return response()->json([
                'pullTest' => $pullTest,
                'paretos' => $paretos,
                'tableftq' => $tableftq,
                'tableContent' => $tableContent,
                'tableReg' => $tableReg,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

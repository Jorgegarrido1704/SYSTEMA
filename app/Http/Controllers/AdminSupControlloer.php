<?php

namespace App\Http\Controllers;

use App\Models\calidadRegistro;
use App\Models\personalBergsModel;
use App\Models\routingModel;
use App\Mail\solicitudVacacionesMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use carbon\Carbon;



class AdminSupControlloer extends Controller
{
    //
    public function index_admin(Request $request)
    {
        if (session('categoria') != 'SupAdmin') {
            return redirect('/login');
        } else {
            $empleados = personalBergsModel::select('employeeNumber', 'employeeName')->where('status', 'Activo')->where('DaysVacationsAvailble', '>', 0)->get();

            return view('SupAdmin', ['value' => session('user'), 'cat' => session('categoria'), 'empleados' => $empleados]);
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
            } elseif ($request->input('setAddWeek') == 5) {
                \App\Jobs\accionesCorrectivasJob::dispatch();
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

    public function addVacationAdmin(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'personalIng' => 'required',
            'endDate' => 'required|date',
            'diasT' => 'required|integer|min:1|max:20',
        ]);
        $value = session('user');

        $pesonal = $input['personalIng'];
        $endDate = Carbon::parse($input['endDate']);
        $diasT = $input['diasT'];
        $dias_solicitados = $revDias = $diasT;
        $returnDate = Carbon::parse($input['endDate']);
        $checkDias = Carbon::parse($input['endDate']);

        $buscarPersonal = DB::table('personalberg')
            ->where('employeeNumber', '=', $pesonal)
            ->first();
        $lastyear = $buscarPersonal->lastYear;
        $currentYear = $buscarPersonal->currentYear;
        $nextYear = $buscarPersonal->nextYear;
        // Datos para el registro
        $nombre = $buscarPersonal->employeeName;
        $area = $buscarPersonal->employeeArea;
        $lider = $buscarPersonal->employeeLider;
        $fecha_de_solicitud = $endDate->toDateString();
        $noposible = $repetidosDias = 0;
        $email = null;
         $daotsSup=DB::table('personalberg')->select('user')
            ->where('employeeName', '=', $lider)
            ->first();
        $supervisor = $daotsSup->user??"";
        

        $email = 'jgarrido@mx.bergstrominc.com';

        // revisar si hay disponibilidad de vacaciones en la fecha solicitada

        for ($i = 0; $i < $revDias; $i++) {
            // si es domingo
            if (Carbon::parse($checkDias)->dayOfWeek == 0) {
                $revDias++;
            } else {
                $datosVacaciones = DB::table('registro_vacaciones')
                    ->where('fecha_de_solicitud', '=', $checkDias->toDateString())
                    ->where('area', '=', $area)
                    ->count();
                $diasRepetidos = DB::table('registro_vacaciones')
                    ->where('fecha_de_solicitud', '=', $checkDias->toDateString())
                    ->where('id_empleado', '=', $pesonal)
                    ->count();
                if ($datosVacaciones > 150) {
                    $noposible += 1;
                }
                if ($diasRepetidos > 0) {
                    $repetidosDias += 1;
                }
            }
            $checkDias->addDay(1);
        }

        if ($noposible > 0) {
            return redirect()->back()->with('error', 'Alguno de los días solicitados ya tiene el máximo de vacaciones aprobadas en su área.
        Por favor, revise con su supervisor y elija otras fechas.');
        }if ($repetidosDias > 0) {
            return redirect()->back()->with('error', 'Alguno de los días solicitados ya tiene una solicitud de vacaciones aprobada.
            Por favor, revise con su supervisor y elija otras fechas.');
        }

        // $link = URL::temporarySignedRoute('loginWithoutSession', now()->addMinutes(30), ['user' => 'Juan G']);
        $contend = [
            'asunto' => 'Solicitud de Vacaciones',
            'nombre' => $nombre,
            'departamento' => $area,
            'supervisor' => $supervisor,
            'fecha_de_solicitud' => '',
            'fecha_retorno' => '',
            'dias_solicitados' => $dias_solicitados ?? 1,
            'Folio' => '',
        ];

        if ($lastyear >= $diasT) {
            DB::table('personalberg')
                ->where('employeeNumber', '=', $pesonal)
                ->update(['lastYear' => $lastyear - $diasT, 'DaysVacationsAvailble' => DB::raw('DaysVacationsAvailble - '.$diasT)]);
        } elseif ($lastyear >= 0 && $currentYear >= ($diasT - $lastyear)) {
            DB::table('personalberg')
                ->where('employeeNumber', '=', $pesonal)
                ->update(['currentYear' => $currentYear - ($diasT - $lastyear), 'lastYear' => 0, 'DaysVacationsAvailble' => DB::raw('DaysVacationsAvailble - '.$diasT)]);
        } elseif ($lastyear >= 0 && $currentYear >= 0 && $nextYear >= ($diasT - $lastyear - $currentYear)) {
            DB::table('personalberg')
                ->where('employeeNumber', '=', $pesonal)
                ->update(['nextYear' => $nextYear - ($diasT - $lastyear - $currentYear), 'currentYear' => 0, 'lastYear' => 0, 'DaysVacationsAvailble' => DB::raw('DaysVacationsAvailble - '.$diasT)]);
        } else {
            session()->flash('error', 'No tienes suficientes días de vacaciones disponibles.');

            return redirect()->back();
        }
        $diasReg = $diasT;
        for ($i = 0; $i < $diasT; $i++) {

            // Check if the date is a weekend
            if (Carbon::parse($returnDate)->dayOfWeek == 0) {
                $diasT++;
            } else {
                if (($diasReg - ($currentYear + $lastyear)) > 0) {
                    $years = Carbon::now()->addYear()->year;
                } elseif (($diasReg - ($lastyear)) > 0) {
                    $years = Carbon::now()->year;
                } else {
                    $years = Carbon::now()->subYear()->year;
                }
                // Insert into registro_vacaciones table
                DB::table('registro_vacaciones')->insert([
                    'id_empleado' => $pesonal,
                    'fecha_de_solicitud' => $returnDate,
                    'fehca_retorno' => $returnDate,
                    'estatus' => 'Pendiente RH',
                    'dias_solicitados' => $diasReg,
                    'usedYear' => $years,
                    'superVisor' => $supervisor,
                    'area' => $area,

                ]);
            }
            $returnDate->addDay(1);
        }

        $buscarFolio = DB::table('registro_vacaciones')
            ->select('id', 'superVisor', 'dias_solicitados', 'fecha_de_solicitud')->where('id_empleado', '=', $pesonal)
            ->limit(1)->orderBy('id', 'desc')->first();

        $folio = 'VAC-'.$buscarFolio->id;
        $fechadeSolicitud = Carbon::parse($buscarFolio->fecha_de_solicitud)->addWeekdays(-$buscarFolio->dias_solicitados);
        $contend['fecha_de_solicitud'] = $fechadeSolicitud->toDateString();
        $contend['Folio'] = $folio;

     //   Mail::to($email)->send(new solicitudVacacionesMail($contend, 'Solicitud de Vacaciones'));

        return redirect()->route('SupAdmin')->with('success', 'Vacaciones agregadas correctamente.');
    }
}

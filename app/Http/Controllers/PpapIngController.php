<?php

namespace App\Http\Controllers;

use App\Models\ingAct;
use App\Models\PPAPandPRIM;
use App\Models\ppapIng;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables;
use App\Models\listaCalidad;
use App\Models\cronograma;
use App\Models\errores;
use App\Models\Wo;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\workScreduleModel;
use App\Models\regPar;
use APP\Mail\firmasNPIEmail;

class PpapIngController extends Controller
{

    public function __invoke(Request $request)
    {
        $value = session('user');
        $cat = session('categoria');
        if ($cat == '') {
            return view('login');
        } else {
            $i = 0;
            $inges = $activ = $answer = $enginners = [];
            $buscarinfor = DB::table('registro')->where('count', '=', '13')
                ->orwhere('count', '=', '17')->orwhere('count', '=', '14')->orwhere('count', '=', '16')
                ->orwhere('count', '=', '18')->get();
            foreach ($buscarinfor as $rowInge) {
                $inges[$i][0] = $rowInge->NumPart;
                $inges[$i][1] = $rowInge->cliente;
                $inges[$i][2] = $rowInge->rev;
                $inges[$i][3] = $rowInge->wo;
                $inges[$i][4] = $rowInge->po;
                $inges[$i][5] = $rowInge->Qty;
                $inges[$i][6] = $rowInge->id;
                $inges[$i][7] = $rowInge->count;
                $inges[$i][8] = $rowInge->info;
                $i++;
            }
            $i = 0;
            $SearchAct = DB::table('ingactividades')->where('count', '<', '4')->orderby("Id_request")->get();
            foreach ($SearchAct as $rowAct) {

                $enginners[$i][0] = $rowAct->id;
                $enginners[$i][1] = $rowAct->Id_request;
                $control = strtotime($rowAct->fecha);
                $dateControl = strtotime(date('d-m-Y H:i'));
                $controlTotal = intval((($dateControl - $control) / 3600)) . ":" . intval((($dateControl - $control) % 3600) / 60);

                $enginners[$i][2] = $controlTotal;
                $enginners[$i][3] = $rowAct->actividades;
                $enginners[$i][4] = $rowAct->desciption;
                $enginners[$i][5] = $rowAct->fechaEncuesta;
                $i++;
            }
            $i = 0;
            $busarResp = DB::table('ppapandprim')->where('count', '<', '2')->get();
            foreach ($busarResp as $respPPAP) {
                $answer[$i][0] = $respPPAP->tp;
                $answer[$i][1] = $respPPAP->client;
                $answer[$i][2] = $respPPAP->pn;
                $answer[$i][3] = $respPPAP->REV1;
                $answer[$i][4] = $respPPAP->REV2;
                $answer[$i][5] = $respPPAP->cambios;
                $answer[$i][6] = $respPPAP->fecha;
                $answer[$i][7] = $respPPAP->eng;
                $answer[$i][8] = $respPPAP->quality;
                $answer[$i][9] = $respPPAP->ime;
                $answer[$i][10] = $respPPAP->test;
                $answer[$i][11] = $respPPAP->production;
                $answer[$i][12] = $respPPAP->compras;
                $answer[$i][13] = $respPPAP->gernete;
                $i++;
            }
            $mont = $request->input('mont');
            if ($mont == "") {
                $today = intval(date("m"));
                $month = date('m');
            } else {
                $today = intval(date("m", strtotime("+1 month")));
                $month = date('m', strtotime("+1 month"));
            }
            $day_month = date('t');
            $year = date('Y');
            $dias_mes = [];
            for ($i = 1; $i <= $day_month; $i++) {
                $dateTime = date_create($i . '-' . $month . '-' . $year);
                $dayNumber = date_format($dateTime, 'w');
                if ($dayNumber != 0 && $dayNumber != 6) {
                    $dias_mes[] = $i;
                }
            }
            $cronoGram = [];
            $graficOnTime = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $graficasLate = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $i = 0;
            $buscarCrono = DB::table('croning')->where('fechaFin', '')->get();
            foreach ($buscarCrono as $rowCrono) {
                $cronoGram[$i][0] = $rowCrono->id;
                $cronoGram[$i][1] = $rowCrono->cliente;
                $cronoGram[$i][2] = $rowCrono->pn;
                $cronoGram[$i][3] = $rowCrono->rev;
                $cronoGram[$i][4] = $rowCrono->fechaReg;
                $cronoGram[$i][5] = $rowCrono->fechaCompromiso;
                $cronoGram[$i][6] = $rowCrono->fechaCambio;
                $cronoGram[$i][7] = $rowCrono->fechaFin;
                $cronoGram[$i][8] = $rowCrono->quienReg;
                $cronoGram[$i][9] = $rowCrono->quienCamb;
                $inicio = intval(substr($rowCrono->fechaReg, 0, 2));
                $fin = intval(substr($rowCrono->fechaCambio, 0, 2));
                $fin_org = intval(substr($rowCrono->fechaCompromiso, 0, 2));
                $mescontrol = intval(substr($rowCrono->fechaReg, 3, 2));
                $mesFin = intval(substr($rowCrono->fechaCambio, 3, 2));
                $mesComp = intval(substr($rowCrono->fechaCompromiso, 3, 2));
                if ($today == intval(substr($rowCrono->fechaReg, 3, 2))) {
                    if ($mescontrol == $mesFin) {
                        $controles = ($fin - $inicio);
                        $cronoGram[$i][10] = $inicio + $controles;
                        $cronoGram[$i][11] = $inicio;
                        $cronoGram[$i][12] = $fin - $fin_org;
                    } else if ($mescontrol < $mesFin && $mescontrol == intval(date('m'))) {
                        $cronoGram[$i][10] = 31;
                        $cronoGram[$i][11] = $inicio;
                        $cronoGram[$i][12] = $fin - $fin_org;
                    } else if ($mescontrol < $mesFin && $mescontrol != intval(date('m'))) {
                        $cronoGram[$i][10] = $fin;
                        $cronoGram[$i][11] = 1;
                        $cronoGram[$i][12] = $fin - $fin_org;
                    }
                } else {
                    if ($mescontrol > $today) {
                        $cronoGram[$i][10] = 0;
                        $cronoGram[$i][11] = 0;
                        $cronoGram[$i][12] = 0;
                    } else if ($mescontrol < $today and $mesFin >= $today) {
                        $cronoGram[$i][10] = $fin;
                        $cronoGram[$i][11] = 1;
                        $cronoGram[$i][12] = $fin - $fin_org;
                    } else if ($mescontrol < $today and $mesComp < $today) {
                        $cronoGram[$i][10] = 0;
                        $cronoGram[$i][11] = 0;
                        $cronoGram[$i][12] = 0;
                    }
                }
                $i++;
            }

            $buscarCrono = DB::table('croning')->get();
            foreach ($buscarCrono as $Crono) {
                $mescontrol1 = intval(substr($Crono->fechaReg, 3, 2));
                if ($Crono->fechaCompromiso == $Crono->fechaCambio) {
                    $graficOnTime[$mescontrol1 - 1] = $graficOnTime[$mescontrol1 - 1] + 1;
                } else if ($Crono->fechaCompromiso != $Crono->fechaCambio) {
                    $graficasLate[$mescontrol1 - 1] = $graficasLate[$mescontrol1 - 1] + 1;
                }
            }

            $fullreq = [];
            $i = 0;
            $buscarfulls = DB::table('registrofull')->where('fechaColocacion', 'No Aun')->get();
            foreach ($buscarfulls as $full) {
                $fullreq[$i][0] = $full->id;
                $fullreq[$i][1] = $full->SolicitadoPor;
                $fullreq[$i][2] = $full->fechaSolicitud;
                $fullreq[$i][3] = $full->np;
                $fullreq[$i][4] = $full->rev;
                $fullreq[$i][5] = $full->cliente;
                $fullreq[$i][6] = $full->Cuantos;
                $fullreq[$i][7] = $full->estatus;
                $fullreq[$i][8] = $full->tablero;

                $i++;
            }
            $i = 0;
            $soporte = [];
            $buscarfulls = DB::table('errores')->where('mostrar_ing', '=', 1)->get();
            foreach ($buscarfulls as $sop) {
                $soporte[$i][0] = $sop->id;
                $soporte[$i][1] = $sop->pn;
                $soporte[$i][2] = $sop->wo;
                $soporte[$i][3] = $sop->rev;
                $soporte[$i][4] = $sop->descriptionIs;
                $soporte[$i][5] = $sop->WhoReg;
                $soporte[$i][6] = $sop->DateIs;
                $i++;
            }
            $paola = $alex = $alexDesc = $paoDesc = [];
            $dia = date('d/m/Y');
            $i = $j = 0;
            function min($da)
            {
                $init = strtotime(date('d-m-Y 07:30'));
                $fin = strtotime(date('d-m-Y ' . $da));
                $dif = $fin - $init;
                if ($dif > 0) {
                    $min = round($dif / 60);
                } else {
                    $min = 0;
                }
                return $min;
            }
            //engineers similituds
            $inip = $inia = 0;
            $paolaT = $alexT = $paolaTdesc = $alexTdesc = [];
            $todaying = date('d-m-Y');
            $enginners1 = DB::table('ingactividades')->where('fecha', 'LIKE', $todaying . '%')->get();
            foreach ($enginners1 as $eng1) {
                if (intval(strtotime($eng1->fecha)) > intval(strtotime(date('d-m-Y 07:30')))) {
                    $inicio = (((strtotime($eng1->fecha)) - (strtotime(date('d-m-Y 07:30')))) / 60);
                } else {
                    $inicio = 0;
                }
                $fin = (((strtotime($eng1->finT)) - (strtotime(date('d-m-Y 07:30')))) / 60);
                if ($eng1->Id_request == 'Paola S') {
                    $paolaT[$inip][0] = $inicio;
                    $paolaT[$inip][1] = $fin;
                    $paolaTdesc[$inia][0] = $eng1->desciption;
                    $inip++;
                } else if ($eng1->Id_request === 'Alejandro V') {
                    $alexT[$inip][0] = $inicio;
                    $alexT[$inip][1] = $fin;
                    $inip++;
                }
            }
            //weekly activities
            $buscartateas = DB::table('weekactivities')->where('dateDay', '=', $dia)->get();
            foreach ($buscartateas as $tat) {
                if ($tat->id_eng == 'Paola S') {
                    $paola[$i][0] = min($tat->iniTime);
                    $paola[$i][1] = min($tat->endTime);
                    $paoDesc[$i][0] = $tat->actDesc;
                    $i++;
                } else if ($tat->id_eng == 'Alex V') {
                    $alex[$j][0] = min($tat->iniTime);
                    $alex[$j][1] = min($tat->endTime);
                    $alexDesc[$j][0] = $tat->actDesc;
                    $j++;
                }
            }
            $i = 0;
            $problem = [];
            $buscarProblemas = DB::table('errores')->where('mostrar_ing', '=', 0)->get();
            foreach ($buscarProblemas as $problemas) {
                $problem[$i][0] = $problemas->id;
                $problem[$i][1] = $problemas->pn;
                $problem[$i][2] = $problemas->wo;
                $problem[$i][3] = $problemas->rev;
                $problem[$i][4] = $problemas->descriptionIs;
                $problem[$i][5] = $problemas->WhoReg;
                $problem[$i][6] = $problemas->DateIs;
                $i++;
            }



            return view('/ing', ['problem' => $problem, 'paolaTdesc' => $paolaTdesc, 'alexTdesc' => $alexTdesc, 'paolaT' => $paolaT, 'alexT' => $alexT, 'alex' => $alex, 'alexDesc' => $alexDesc, 'paola' => $paola, 'paoDesc' => $paoDesc, 'soporte' => $soporte, 'fullreq' => $fullreq, 'graficasLate' => $graficasLate, 'graficOnTime' => $graficOnTime, 'cat' => $cat, 'inges' => $inges, 'value' => $value, 'enginners' => $enginners, 'answer' => $answer, 'dias_mes' => $dias_mes, 'cronoGram' => $cronoGram]);
        }
    }

    public function store(Request $request)
    {
        $value = session('user');
        $idIng = $request->input('iding');
        $cuenta = $request->input('count');
        $info = $request->input('info');
        $today = date('d-m-Y H:i');
        $regpart = regPar::where('codeBar', $info)->update(['eng' => 0, 'cortPar' => 0, 'libePar' => 0, 'ensaPar' => 0, 'loomPar' => 0, 'testPar' => 0, 'embPar' => 0, 'preCalidad' => 0, 'fallasCalidad' => 0, 'specialWire' => 0]);
        $datosRegistro = Wo::select('Qty')->where('info', $info)->first();
        $eng = $datosRegistro->Qty;
        function upRegistro($count, $donde, $info, $area, $idIng, $today, $mas, $newQty, $value)
        {
            $updateTiempo = DB::table('tiempos')->where('info', $info)->update([$area => $today]);
            $updateInge = DB::table('registro')->where('id', '=', $idIng)->update(['count' => $count, 'donde' => $donde]);
            $regIng = new ppapIng;
            $regIng->info = $info;
            $regIng->fecha = $today;
            $regIng->codigo = $value;
            $regIng->area = $area;
            $regIng->save();
            $updateCantidad = DB::table('registroparcial')->where('codeBar', '=', $info)->update(['eng' => 0, $mas => $newQty]);
        }

        if ($cuenta == 17) {
            upRegistro(16, 'Ingenieria// liberacion', $info, 'corte', $idIng, $today, 'eng', $eng, $value);
        } else if ($cuenta == 14) {
            upRegistro(10, 'En espera de calidad', $info, 'loom', $idIng, $today, 'preCalidad', $eng, $value);
        } else if ($cuenta == 13) {
            upRegistro(14, 'Ingenieria // loom', $info, 'ensamble', $idIng, $today, 'eng', $eng, $value);
        } else if ($cuenta == 16) {
            upRegistro(13, 'Ingenieria // ensamble', $info, 'liberacion', $idIng, $today, 'eng', $eng, $value);
        } else if ($cuenta == 18) {
            upRegistro(12, 'En espera de embarque', $info, 'calidad', $idIng, $today, 'embPar', $eng, $value);
            $count = 12;
            $donde = 'En espera de embarque';
            $area = 'Prueba electrica';
            $buscarinfo = DB::table('registro')->where('info', $info)->first();
            $revin = substr($buscarinfo->rev, 0, 4);
            $emailcliente = $buscarinfo->cliente;
            $emailpn = $buscarinfo->NumPart;
            $revf = substr($buscarinfo->rev, 4);
            $emailwo = $buscarinfo->wo;
            $emailpo = $buscarinfo->po;
            $emailQty = $buscarinfo->Qty;
            $messageData = [
                'revin' => $revin,
                'emailcliente' => $emailcliente,
                'emailpn' => $emailpn,
                'revf' => $revf,
                'emailwo' => $emailwo,
                'emailpo' => $emailpo,
                'emailQty' => $emailQty,

            ];
            $subject = $revin . ' PRUEBA ELECTRICA  ' . $emailcliente . ' NP ' . $emailpn . ' en REV ' . $revf;
            $date = date('d-m-Y');
            $time = date('H:i');

            $content =  $revin . ' liberada y en embarque' . "\n\n";
            $content .= 'Buen día,' . "\n\n" . 'Les comparto que el día ' . $date . ' a las ' . $time . "\n\n" . "Salió de prueba la siguiente PPAP:" . "\n\n";
            $content .= "\n\n" . " Cliente: " . $emailcliente;
            $content .= "\n\n" . " Número de parte: " . $emailpn;
            $content .= "\n\n" . " PPAP en revisión: " . $revf;
            $content .= "\n\n" . " Con Work order: " . $emailwo;
            $content .= "\n\n" . " Con Sono order: " . $emailpo;
            $content .= "\n\n" . " Por la cantidad de: " . $emailQty;
            $content .= "\n\n" . " Con las siguientes anotaciones:";
            $calidad = DB::table('regsitrocalidad')->where('info', $info)->get();
            foreach ($calidad as $regcal) {
                $content .= "<br>" . $regcal->codigo;
            }
            $recipients = [
                'jguillen@mx.bergstrominc.com',
                'jcervera@mx.bergstrominc.com',
                'jcrodriguez@mx.bergstrominc.com',
                'egaona@mx.bergstrominc.com',
                'dvillalpando@mx.bergstrominc.com',
                'jolaes@mx.bergstrominc.com',
                'lramos@mx.bergstrominc.com',
                'emedina@mx.bergstrominc.com',
                'vpichardo@mx.bergstrominc.com',
                'jgamboa@mx.bergstrominc.com'

            ];
            Mail::to($recipients)->send(new \App\Mail\PPAPING($subject, $content));
        }

        return redirect('/ing');
    }


    public function action(Request $request)
    {
        $id = $request->input('id');
        $todayIng = date('d-m-Y H:i');
        $id_f = $request->input('id_f');
        $value = session('user');

        if (!empty($id)) {
            $buscarIng = DB::table('ingactividades')->where('id', $id)->first();
            if ($buscarIng->fechaEncuesta != 'pausado') {
                $upIng = DB::table('ingactividades')->where('id', $id)->update(['finT' => $todayIng, 'fechaEncuesta' => 'pausado']);
            } else if ($buscarIng->fechaEncuesta == 'pausado') {
                $update = new ingAct;
                $update->Id_request = $buscarIng->Id_request;
                $update->fecha = $todayIng;
                $update->finT = '';
                $update->actividades = $buscarIng->actividades;
                $update->desciption = $buscarIng->desciption;
                $update->count = 1;
                $update->analisisPlano = '';
                $update->bom = '';
                $update->AyudasVizuales = '';
                $update->fechaEncuesta = '';
                $update->bomRmp = '';
                $update->fullSize = '';
                $update->listaCort = '';
                $update->save();
                $upIng = DB::table('ingactividades')->where('id', $id)->update(['count' => 4, 'fechaEncuesta' => 'finalizado']);
            }
            return redirect('/ing');
        } else if (!empty($id_f)) {
            $buscarFin = DB::table('ingactividades')->where('id', $id_f)->first();
            if ($buscarFin) {
                if ($buscarFin->fechaEncuesta == 'pausado') {
                    $upIng = DB::table('ingactividades')->where('id', $id_f)->where('count', '!=', 4)->update(['fechaEncuesta' => 'finalizado', 'count' => 4]);

                    return redirect('/ing');
                } else {
                    $upIng = DB::table('ingactividades')->where('id', $id_f)->where('count', '!=', 4)->update(['finT' => $todayIng, 'fechaEncuesta' => 'finalizado', 'count' => 4]);

                    return redirect('/ing');
                }
            }
        }
    }
    public function tareas(Request $request)
    {

        $activiad = $request->input('act');
        $desc = $request->input('info');
        $eng = $request->input('Inge');
        $today = date('d-m-Y H:i');
        $regIng = new ingAct;
        $regIng->Id_request = $eng;
        $regIng->fecha = $today;
        $regIng->finT = '';
        $regIng->actividades = $activiad;
        $regIng->desciption = $desc;
        $regIng->count = 1;
        $regIng->analisisPlano = '';
        $regIng->bom = '';
        $regIng->AyudasVizuales = '';
        $regIng->bomRmp = '';
        $regIng->fullSize = '';
        $regIng->fechaEncuesta = '';
        $regIng->listaCort = '';
        if ($regIng->save()) {
            if ($eng == "Paola S" and ($activiad == 'Comida' or $activiad == "Colocacion de full size")) {
                $buscarstatus = DB::table('registrofull')->where('estatus', 'En_proceso')->first();
                if ($buscarstatus) {
                    $fullnp = $buscarstatus->np;
                    $fullRev = $buscarstatus->rev;
                    $fullclient = $buscarstatus->cliente;
                    $fullCuantos = $buscarstatus->Cuantos;
                    $fullFecha = $buscarstatus->fechaSolicitud;
                    $rep = $fullFecha . "-" . $fullnp . "-" . $fullRev . "-" . $fullclient . "-" . $fullCuantos;
                    $upIng = DB::table('ingactividades')->where('desciption', $rep)->where('count', '!=', '4')->update(['finT' => $today, 'fechaEncuesta' => 'pausado', 'count' => 4]);
                    $updateAct = DB::table('registrofull')->where('estatus', 'En_proceso')->update(['estatus' => 'Pausado',]);
                }
            }
            return redirect('/ing');
        }
    }

    public function REgPPAP(Request $request)
    {
        $tipo = $request->input('Tipo');
        $client = $request->input('Client');
        $tipoA = $request->input('tipoArnes');
        $pn = $request->input('pn');
        $rev1 = $request->input('rev1');
        $rev2 = $request->input('rev2');
        $cambios = $request->input('cambios');
        $eng = $request->input('quien');
        $today = date('d-m-Y H:i');
        $buscarIguales = DB::table('ppapandprim')->where('pn', $pn)->where('REV1', $rev1)->where('REV2', $rev2)->first();
        if ($buscarIguales) {
            return redirect('/ing')->with('error', 'Ya existe esta Revision');
        } else {


            if ($tipo == 'PPAP') {
                $tp = 'NUEVA PPAP (Hoja Verde)';
            } else if ($tipo == 'PRIM') {
                $tp = 'LiberacionPrimeraPieza (Hoja Amarilla)';
            } else if ($tipo == 'NO PPAP') {
                $tp = 'NO PPAP';
            } else  if ($tipo == 'Change PPAP') {
                $tp = 'Cambio REV PPAP (Hoja Verde)';
            } else if ($tipo == 'Change PRIM') {
                $tp = 'Cambio REV PrimeraPieza (Hoja Amarilla)';
            }
            $registro = new PPAPandPRIM;
            $registro->tp = $tp;
            $registro->client = $client;
            $registro->tipo = $tipoA;
            $registro->pn = $pn;
            $registro->REV1 = $rev1;
            $registro->REV2 = $rev2;
            $registro->cambios = $cambios;
            $registro->fecha = $today;
            $registro->eng = $eng;
            $registro->quality = '';
            $registro->ime = '';
            $registro->test = '';
            $registro->production = '';
            $registro->compras = '';
            $registro->gernete = '';
            $registro->count = 1;
            if ($registro->save()) {
                $accion = PPAPandPRIM::orderby('id', 'desc')->first();
                $recipients = [
                    'jgarrido@mx.bergstrominc.com',
                    'rfandino@mx.bergstrominc.com',
                    'fsuarez@mx.bergstrominc.com',
                    'lramos@mx.bergstrominc.com',
                    'emedina@mx.bergstrominc.com',
                    'drocha@mx.bergstrominc.com',
                    'Jruiz@mx.bergstrominc.com',
                    'jrodriguez@mx.bergstrominc.com',
                    'vpichardo@mx.bergstrominc.com',
                    'jgamboa@mx.bergstrominc.com',
                    'egaona@mx.bergstrominc.com',
                    'jolaes@mx.bergstrominc.com',
                    'dvillalpando@mx.bergstrominc.com',
                    'jamoreno@mx.bergstrominc.com',
                    'jguillen@mx.bergstrominc.com',
                    'maleman@mx.bergstrominc.com',
                    'fgomez@mx.bergstrominc.com',
                    'lmireles@mx.bergstrominc.com'
                ];
                Mail::to($recipients)->send(new \App\Mail\firmasNPIEmail($accion, 'New product Introduction - ' . $pn));
                return redirect('/ing');
            }
        }
    }
    public function cronoReg(Request $request)
    {
        $value = session('user');
        $client = $request->input('Client');
        $rev = $request->input('rev1');
        $pn = $request->input('pn');
        $fecha_entrega = $request->input('fecha');
        $fecha_entrega = date('d-m-Y', strtotime($fecha_entrega));
        $today = date('d-m-Y');
        $id_cambio = $request->input('id_cambio');
        $nuevaFecha = $request->input('nuevaFecha');
        $fecha_inicio = $request->input('fecha_in');
        $id_fin = $request->input('id_fin');
        $fecha_ini = date('d-m-Y', strtotime($fecha_inicio));
        if ($id_cambio != '') {
            $nuevaFecha = date('d-m-Y', strtotime($nuevaFecha));
            $crono = DB::table('croning')->where('id', $id_cambio)->update(['fechaCambio' => $nuevaFecha, 'quienCamb' => $value]);
            return redirect('/ing');
        }
        if ($id_fin != '') {
            $crono = DB::table('croning')->where('id', $id_fin)->update(['fechaFin' => $today, 'quienCamb' => $value]);
            return redirect('/ing');
        }
        if ($pn != "" and $rev != "" and $client != "") {
            $crono = new Cronograma;
            $crono->fill([
                'cliente' => $client,
                'pn' => $pn,
                'rev' => $rev,
                'fechaReg' => $fecha_ini,
                'fechaCompromiso' => $fecha_entrega,
                'fechaCambio' => $fecha_entrega,
                'fechaFin' => '',
                'quienReg' => $value,
                'quienCamb' => ''
            ]);

            if ($crono->save()) {
                return redirect('/ing');
            }
        }
    }

    public function modifull(Request $request)
    {
        $value = session("user");
        $modistatus = $request->input('estatus');
        $mod = $request->input('mod');
        $finAct = $request->input('finAct');
        if (!empty($mod) and $modistatus == 'En_proceso') {
            $buscar = DB::table('registrofull')->where('id', $mod)->first();
            $fullnp = $buscar->np;
            $fullRev = $buscar->rev;
            $fullclient = $buscar->cliente;
            $fullCuantos = $buscar->Cuantos;
            $fullFecha = $buscar->fechaSolicitud;
            $reg = $fullFecha . "-" . $fullnp . "-" . $fullRev . "-" . $fullclient . "-" . $fullCuantos;
            $today = date("d-m-Y H:i");
            $buscarIngAct = DB::table('ingactividades')->where('desciption', $reg)->where('count', '!=', 4)->first();
            if ($buscarIngAct) {
                $upIng = DB::table('ingactividades')->where('desciption', $reg)->where('count', '!=', 4)->update(['finT' => $today, 'fechaEncuesta' => 'finalizado', 'count' => 4]);
                $addAct = new ingAct;
                $addAct->Id_request = $value;
                $addAct->fecha = $today;
                $addAct->finT = "";
                $addAct->actividades = "Colocacion de full size";
                $addAct->desciption = $reg;
                $addAct->fechaEncuesta = $modistatus;
                $addAct->count = 0;
                $addAct->analisisPlano = '';
                $addAct->bom = '';
                $addAct->AyudasVizuales = '';
                $addAct->bomRmp = '';
                $addAct->fullSize = '';
                $addAct->fechaEncuesta = '';
                $addAct->listaCort = '';
                $addAct->save();
                $update = DB::table('registrofull')->where('id', $mod)->update(['estatus' => $modistatus]);
                return redirect('/ing');
            } else {
                $addAct = new ingAct;
                $addAct->Id_request = $value;
                $addAct->fecha = $today;
                $addAct->finT = "";
                $addAct->actividades = "Colocacion de full size";
                $addAct->desciption = $reg;
                $addAct->fechaEncuesta = $modistatus;
                $addAct->count = 0;
                $addAct->analisisPlano = '';
                $addAct->bom = '';
                $addAct->AyudasVizuales = '';
                $addAct->bomRmp = '';
                $addAct->fullSize = '';
                $addAct->fechaEncuesta = '';
                $addAct->listaCort = '';
                if ($addAct->save()) {
                    $update = DB::table('registrofull')->where('id', $mod)->update(['estatus' => $modistatus]);
                    return redirect('/ing');
                }
            }
        } else if (!empty($mod) and $modistatus == 'Pausado') {
            $buscar = DB::table('registrofull')->where('id', $mod)->first();
            $fullnp = $buscar->np;
            $fullRev = $buscar->rev;
            $fullclient = $buscar->cliente;
            $fullCuantos = $buscar->Cuantos;
            $fullFecha = $buscar->fechaSolicitud;
            $reg = $fullFecha . "-" . $fullnp . "-" . $fullRev . "-" . $fullclient . "-" . $fullCuantos;
            $today = date("d-m-Y H:i");
            $upIng = DB::table('ingactividades')->where('desciption', $reg)->where('count', '!=', 4)->update(['finT' => $today, 'fechaEncuesta' => 'pausado', 'count' => 4]);
            $update = DB::table('registrofull')->where('id', $mod)->update(['estatus' => $modistatus]);
            return redirect('/ing');
        }

        if (!empty($finAct)) {
            $buscar = DB::table('registrofull')->where('id', $finAct)->first();
            $fullnp = $buscar->np;
            $fullRev = $buscar->rev;
            $fullclient = $buscar->cliente;
            $fullCuantos = $buscar->Cuantos;
            $fullFecha = $buscar->fechaSolicitud;
            $reg = $fullFecha . "-" . $fullnp . "-" . $fullRev . "-" . $fullclient . "-" . $fullCuantos;
            $today = date("d-m-Y H:i");
            $buscarfulls = DB::table('fullsizes')->where('np', $fullnp)->where('rev', $fullRev)->first();
            if ($buscarfulls) {
                $enalmacen = $buscarfulls->enAlmacen;
                $enpiso = $buscarfulls->enPiso;
                if ($enalmacen >= $fullCuantos) {
                    $resto = $enalmacen - $fullCuantos;
                    $pisoNuevo = $enpiso + $fullCuantos;
                } else if ($enalmacen <= $fullCuantos) {
                    $resto = 0;
                    $pisoNuevo = $enpiso + $fullCuantos;
                }
                $updates = DB::table('fullsizes')->where('np', $fullnp)->where('rev', $fullRev)->update(['enAlmacen' => $resto, 'enPiso' => $pisoNuevo]);
            } else {
                // $nuvonum=
            }

            $upIng = DB::table('ingactividades')->where('desciption', $reg)->where('count', '!=', 4)->update(['finT' => $today, 'fechaEncuesta' => 'finalizado', 'count' => 4]);
            $update = DB::table('registrofull')->where('id', $finAct)->update(['estatus' => 'finalizado', 'fechaColocacion' => $today, 'QuienIng' => $value]);
            return redirect('/ing');
        }
    }

    public function problemas(Request $request)
    {
        $value = session('user');
        $date = date("d-m-Y H:i");
        $pn = $request->input('pnIs');
        $wo = $request->input('workIs');
        $rev = $request->input('revIs');
        $prob = $request->input('probIs');
        $descIs = $request->input('descIs');
        $wo = substr($wo, 0, 6);
        $addProb = new errores;
        $addProb->pn = $pn;
        $addProb->wo = $wo;
        $addProb->rev = $rev;
        $addProb->problem = $prob;
        $addProb->descriptionIs = $descIs;
        $addProb->WhoReg = $value;
        $addProb->DateIs = $date;
        if ($addProb->save()) {
            return redirect('/ing');
        }
    }
    public function excel_ing(Request $request)
    {
        $date = date("d-m-Y");

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $t = 2;

        // Set column headers
        $headers = [
            'A1' => 'Tipo de Trabajo',
            'B1' => 'Cliente',
            'C1' => 'Tipo de Arnes',
            'D1' => 'Numero de parte',
            'E1' => 'Revision',
            'F1' => 'Cambio de revicion',
            'G1' => 'Cambios',
            'H1' => 'Fecha de Ingreso',
            'I1' => 'Quien Registro',
            'J1' => 'Calidad',
            'K1' => 'IMEXX',
            'L1' => 'Pruebas electricas',
            'M1' => 'Produccion',
            'N1' => 'Compras',
            'O1' => 'Planeacion'
        ];

        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }

        // Fetch data from the database
        $buscarinfo = DB::table('ppapandprim')->get();

        foreach ($buscarinfo as $row) {
            $sheet->setCellValue('A' . $t, $row->tp);
            $sheet->setCellValue('B' . $t, $row->client);
            $sheet->setCellValue('C' . $t, $row->tipo);
            $sheet->setCellValue('D' . $t, $row->pn);
            $sheet->setCellValue('E' . $t, $row->REV1);
            $sheet->setCellValue('F' . $t, $row->REV2);
            $sheet->setCellValue('G' . $t, $row->cambios);
            $sheet->setCellValue('H' . $t, $row->fecha);
            $sheet->setCellValue('I' . $t, $row->eng);
            $sheet->setCellValue('J' . $t, $row->quality);
            $sheet->setCellValue('K' . $t, $row->ime);
            $sheet->setCellValue('L' . $t, $row->test);
            $sheet->setCellValue('M' . $t, $row->production);
            $sheet->setCellValue('N' . $t, $row->compras);
            $sheet->setCellValue('O' . $t, $row->gernete);
            $t++;
        }

        // Generate and download the Excel file
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte PPAP.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }



    public function problemasFin(Request $request)
    {
        $value = session('user');
        validator($request->all(), [
            'id_problema' => ['required', 'integer'],
        ])->validate();
        $id = $request->input('id_problema');
        $date = date("d-m-Y H:i");
        $buscar = DB::table('errores')->where('id', $id)->first();
        if ($buscar) {
            DB::table('errores')->where('id', $id)->update(['DateOff' => $date, 'mostrar_ing' => 2]);
            return redirect('/ing');
        }
    }
    public function workState(Request $request)
    {
        $customer = $ingResp = [];
        $value = session('user');
        $cat = session('categoria');
        $reqCust = workScreduleModel::select('customer')->distinct()->where('customer', '!=', '')->get();

        foreach ($reqCust as $row) {
            $customer[$row->customer] = $row->customer;
        }
        $ingSearch = workScreduleModel::select('resposible')->distinct()->where('resposible', '!=', '')->get();
        foreach ($ingSearch as $row) {
            $ingResp[$row->resposible] = $row->resposible;
        }

        return view('juntas/workSchedules/workSchedule', ['ingResp' => $ingResp, 'customer' => $customer, 'cat' => $cat, 'value' => $value]);
    }
    public function workStateJason(Request $request)
    {
        $datos = [];
        $input = $request->all();
        $customer = $input['customer'] ?? '';
        $resposible = $input['responsable'] ?? '';
        $filter = $input['filter'] ?? '';
        $pn = $input['pns'] ?? '';
        $size = $input['size'] ?? '';
        $dateIni = $input['Dateini'] ?? '';
        $dateFin = $input['DateFin'] ?? '';
        $empty = $input['empty'] ?? false;
        $i = 0;

        if ($pn != '') {
            $buscar = DB::table('workschedule')->where('pn', 'LIKE', '%' . $pn . '%')->get();
        } else if ($customer != '') {
            $buscar = DB::table('workschedule')->where('customer', 'LIKE', '%' . $customer . '%')->get();
        } else if ($resposible != '') {
            $buscar = DB::table('workschedule')->where('resposible', 'LIKE', '%' . $resposible . '%')->get();
        } else if ($size != '') {
            $buscar = DB::table('workschedule')->where('size', 'LIKE', '%' . $size . '%')->get();
        } elseif ($filter != '' and $dateIni != '' and $dateFin != '') {
            $buscar = DB::table('workschedule')->whereBetween($filter, [$dateIni, $dateFin])->get();
        } elseif ($filter != '' and $empty == true) {
            $buscar = DB::table('workschedule')->where($filter, null)->get();
        }

        if ($buscar) {
            foreach ($buscar as $row) {
                $datos[$i++] = $row;
            }
        }
        if ($buscar->isEmpty()) {
            return json_encode(['mensaje' => 'No hay resultados']);
        }
        return json_encode($datos);
    }
    public function saveWorkschedule(Request $request)
    {
        $input = $request->all();
        $newRegistro = new workScreduleModel();
        $newRegistro->fill([
            'customer' => $input['customerWork'],
            'pn' => $input['pnWork'],
            'WorkRev' => $input['revWork'],
            'size' => $input['sizeWork'],
            'receiptDate' => $input['receiptDateWork'] ?? NULL,
            'commitmentDate' => $input['commitmentDateWork'] ?? NULL,
            'customerDate' => $input['customerDateWork'] ?? NULL,
            'resposible' => $input['resposible'] ?? NULL,
            'comments' => $input['comments'] ?? '',
            'qtyInPo' => $input['qtyInPo'] ?? 0,
            'Color' => $input['color'] ?? '',
        ]);
        $newRegistro->save();
        return redirect('/workSchedule');
    }
    public function editDelite(Request $request)
    {
        if ($request->input('id_delete') != null) {
            DB::table('workschedule')->where('id', $request->input('id_delete'))->delete();
            return redirect('/workSchedule');
        } else if ($request->input('id_edit') != null) {
            $input = $request->all();
            if ($input['resposible'] == '') {
                $status = 'Pending';
            } else if (
                $input['MRP'] != '' and $input['receiptDate'] != '' and $input['commitmentDate'] != ''
                and $input['CompletionDate'] != '' and $input['resposible'] != ''
            ) {
                $status = 'Completed';
            } else if ($input['resposible'] != '' or $input['resposible'] != '') {
                $status = 'In Progress';
            } else {
                $status = $input['Status'];
            }
            if ($input['MRP'] != '' or $input['MRP'] == '0000-00-00') {
                $input['MRP'] = date('Y-m-d', strtotime($input['MRP'])) ?? NULL;
            }
            if ($input['receiptDate'] != '' or $input['receiptDate'] == '0000-00-00') {
                $input['receiptDate'] = date('Y-m-d', strtotime($input['receiptDate'])) ?? NULL;
            }
            if ($input['commitmentDate'] != '' or $input['commitmentDate'] == '0000-00-00') {
                $input['commitmentDate'] = date('Y-m-d', strtotime($input['commitmentDate'])) ?? NULL;
            }
            if ($input['CompletionDate'] != '' or $input['CompletionDate'] == '0000-00-00') {
                $input['CompletionDate'] = date('Y-m-d', strtotime($input['CompletionDate'])) ?? NULL;
            }
            if ($input['documentsApproved'] != '' or $input['documentsApproved'] == '0000-00-00') {
                $input['documentsApproved'] = date('Y-m-d', strtotime($input['documentsApproved'])) ?? NULL;
            }
            if ($input['customerDate_'] != '' or $input['customerDate_'] == '0000-00-00') {
                $input['customerDate_'] = date('Y-m-d', strtotime($input['customerDate_'])) ?? NULL;
            }
            $update = DB::table('workschedule')->where('id', $request->input('id_edit'))
                ->update([
                    'WorkRev' => $input['WR'],
                    'size' => $input['s'],
                    'FullSize' => $input['FS'] ?? '',
                    'MRP' => $input['MRP'],
                    'receiptDate' => ($input['receiptDate']), // $input['receiptDate'],
                    'commitmentDate' => ($input['commitmentDate']), //$input['commitmentDate'],
                    'CompletionDate' => ($input['CompletionDate']), //$input['CompletionDate'],
                    'documentsApproved' => ($input['documentsApproved']), //$input['documentsApproved'],
                    'customerDate' => ($input['customerDate_']), //$input['customerDate'],
                    'resposible' => $input['resposible'] ?? '',
                    'comments' => $input['comments_'] ?? '',
                    'qtyInPo' => $input['qip'] ?? 0,
                    'Color' => $input['color'] ?? '',
                    'status' => $status ?? $input['Status'],
                ]);



            return redirect('/workSchedule');
        }
    }
    public function ganttGraph()
    {
        $value = session('user');
        $cat = session('categoria');
        $data = [];
        $registroAntes1 = $registroAntes2 = 0;
        $lastDayoffMonth = Carbon::now()->endOfMonth()->format('d');
        $registros = workScreduleModel::select('pn', 'customer', 'size', 'receiptDate')
            ->where('receiptDate', 'LIKE', Carbon::now()->format('Y-m') . '%')

            ->orderBy('receiptDate', 'asc')
            ->orderBy('size', 'asc')
            ->get();

        foreach ($registros as $row) {
            $daysToAdd = match ($row->size) {
                'Ch' => 4,
                'M'  => 7,
                'G'  => 10,
                default => 4,
            };

            $start = intval(Carbon::parse($row->receiptDate)->format('d'));

            $final = intval(Carbon::parse($row->receiptDate)->addWeekdays($daysToAdd)->format('d'));
            if ($final > $lastDayoffMonth) {
                $final = $lastDayoffMonth;
            }
            if(count($data) > 0){
                foreach($data as $d){
                    if($d['start'] == $start){
                        $start = $start + 1;
                        $final = $final + 1;
                    }
                }
            }
           


            // Asignar color según size
            $color = match ($row->size) {
                'Ch' => 'rgba(75, 192, 192, 0.8)',
                'M'  => 'rgba(255, 159, 64, 0.8)',
                'G'  => 'rgba(255, 99, 132, 0.8)',
                default => 'rgba(201, 203, 207, 0.8)',
            };

            // Agregar al arreglo final
            $data[] = [
                'name'  => $row->pn . ' - ' . $row->customer,
                'start' => $start,
                'end'   => $final,
                'color' => $color
            ];
        }


        return view('inge.graficaGantt', ['value' => $value, 'cat' => $cat, 'data' => $data, 'lastDayoffMonth' => $lastDayoffMonth]);
    }
}

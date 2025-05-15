<?php

namespace App\Http\Controllers;

use App\Http\Controllers\calidadController;
use App\Models\issuesFloor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use ZeroDivisionError;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class juntasController extends Controller
{

    public function index_junta(Request $request)
    {
        $value = session('user');
        $cat = session('categoria');
        if ($cat == '' or $value == '') {
            return view('login');
        } else {
            $dia = $request->input('dia');

            $backlock = $cal = 0;
            for ($i = 0; $i < 13; $i++) {
                $client[$i] = 0;
            }
            $buscarregistros = DB::select("SELECT * FROM registro WHERE Qty>'0'");
            foreach ($buscarregistros as $reg) {
                $price = $reg->price;
                $cant = $reg->Qty;
                if ($reg->cliente == 'BERGSTROM') {
                    $client[0] = $client[0] + ($price * $cant);
                } else if ($reg->cliente == 'ATLAS COPCO') {
                    $client[1] += ($price * $cant);
                } else if ($reg->cliente == 'BLUE BIRD') {
                    $client[2] += ($price * $cant);
                } else if ($reg->cliente == 'COLLINS') {
                    $client[3] += ($price * $cant);
                } else if ($reg->cliente == 'EL DORADO CALIFORNIA') {
                    $client[4] += ($price * $cant);
                } else if ($reg->cliente == 'FOREST' or $reg->cliente == 'FOREST RIVER') {
                    $client[5] += ($price * $cant);
                } else if ($reg->cliente == 'KALMAR') {
                    $client[6] += ($price * $cant);
                } else if ($reg->cliente == 'MODINE') {
                    $client[7] += ($price * $cant);
                } else if ($reg->cliente == 'PHOENIX MOTOR CARS' or $reg->cliente == 'PROTERRA') {
                    $client[8] += ($price * $cant);
                } else if ($reg->cliente == 'SPARTAN') {
                    $client[9] += ($price * $cant);
                } else if ($reg->cliente == 'TICO MANUFACTURING') {
                    $client[10] += ($price * $cant);
                } else if ($reg->cliente == 'UTILIMASTER') {
                    $client[11] += ($price * $cant);
                } else if ($reg->cliente == 'ZOELLER') {
                    $client[12] += ($price * $cant);
                }
                $backlock += ($price * $cant);
            }
            for ($i = 0; $i < 13; $i++) {
                $client[$i] = round((($client[$i] * 100) / $backlock), 3);
            }
            //Stations
            $ventasStation = [];
            for ($i = 0; $i < 13; $i++) {
                $ventasStation[$i] = 0;
            }
            $BuscarVenta = DB::select("SELECT * FROM registro  WHERE Qty>'0' and count='1'");
            foreach ($BuscarVenta as $reg) {
                if ($reg->count == '1') {
                    $ventasStation[0] += round($reg->Qty * $reg->price, 2);
                }
            }
            $BuscarVenta = DB::select("SELECT * FROM registro JOIN registroparcial ON registro.info=registroparcial.codeBar");
            foreach ($BuscarVenta as $reg) {
                if ($reg->cortPar > 0) {
                    $ventasStation[1] += round($reg->cortPar * $reg->price, 2);
                }
                if ($reg->libePar > 0) {
                    $ventasStation[2] += round($reg->libePar * $reg->price, 2);
                }
                if ($reg->ensaPar > 0) {
                    $ventasStation[3] += round($reg->ensaPar * $reg->price, 2);
                }
                if ($reg->loomPar > 0) {
                    $ventasStation[4] += round($reg->loomPar * $reg->price, 2);
                }
                if ($reg->testPar > 0) {
                    $ventasStation[5] += round($reg->testPar * $reg->price, 2);
                }
                if ($reg->embPar > 0) {
                    $ventasStation[12] += round($reg->embPar * $reg->price, 2);
                }
            }
            if ($ventasStation[0] != 0) {
                $ventasStation[6] = round($ventasStation[0] / $backlock, 2);
            }
            if ($ventasStation[1] != 0) {
                $ventasStation[7] = round($ventasStation[1] / $backlock, 2);
            }
            if ($ventasStation[2] != 0) {
                $ventasStation[8] = round($ventasStation[2] / $backlock, 2);
            }
            if ($ventasStation[3] != 0) {
                $ventasStation[9] = round($ventasStation[3] / $backlock, 2);
            }
            if ($ventasStation[4] != 0) {
                $ventasStation[10] = round($ventasStation[4] / $backlock, 2);
            }
            if ($ventasStation[5] != 0) {
                $ventasStation[11] = round($ventasStation[5] / $backlock, 2);
            }
            if ($ventasStation[12] != 0) {
                $ventasStation[13] = round($ventasStation[12] / $backlock, 2);
            }
            //desviations
            $i = 0;
            $info = [];
            $buscarInfo = DB::table('desvation')->where('fpro', '')->where('count', '!=', 5)->orderBy('id', 'DESC')->get();
            foreach ($buscarInfo as $rowInf) {
                $info[$i][0] = $rowInf->fecha;
                $info[$i][1] = $rowInf->cliente;
                $info[$i][2] = $rowInf->quien;
                $info[$i][3] = $rowInf->Mafec;
                $info[$i][4] = $rowInf->porg;
                $info[$i][5] = $rowInf->psus;
                $info[$i][6] = $rowInf->clsus;
                $info[$i][7] = $rowInf->peridoDesv;
                $info[$i][8] = $rowInf->Causa;
                $info[$i][9] = $rowInf->accion;
                $info[$i][10] = $rowInf->evidencia;
                $info[$i][11] = $rowInf->id;
                $i++;
            }
            //ventas
            if ($dia != "") {
                $fechaVenta = substr($dia, 0, 2) . "-" . substr($dia, 3, 2) . "-" . substr($dia, 6, 4);
                if (date('N', strtotime($fechaVenta)) == 1) {
                    $fechaVenta = date("d-m-Y", strtotime("-3 days"));
                } else {
                    $fechaVenta = date("d-m-Y", strtotime("-1 days"));
                }
            } else {
                if (date('N') == 1) {
                    $fechaVenta = date("d-m-Y", strtotime("-3 days"));
                } else {
                    $fechaVenta = date("d-m-Y", strtotime("-1 days"));
                }
            }

            $preReg = [];
            $inform = [];
            $i = 0;
            $x = 0;

            // Obtener todos los PN únicos para la fecha dada
            $buscaprecio = DB::table('regsitrocalidad')
                ->distinct('pn')
                ->where('fecha', 'like', $fechaVenta . '%')
                ->orderBy('id', 'DESC')
                ->get();

            // Almacenar los PN únicos en un array
            foreach ($buscaprecio as $row) {
                $preReg[] = $row->pn;
            }
            $preReg = array_unique($preReg);
            // Recorrer los PN y buscar la cantidad y el precio para cada uno
            foreach ($preReg as $pns) {
                // Buscar todas las ocurrencias del PN en la misma fecha
                $buscarcant = DB::table('regsitrocalidad')
                    ->where('fecha', 'like', $fechaVenta . '%')
                    ->where('pn', $pns)
                    ->count(); // Contamos las ocurrencias en lugar de obtener todos los registros

                // Buscar el precio más reciente de ese PN
                $buscarPrice = DB::table('precios')
                    ->where('pn', $pns)
                    ->orderBy('id', 'DESC')
                    ->first();

                // Si se encuentra un precio, procedemos
                if ($buscarPrice) {
                    $inform[$x][0] = $buscarPrice->client;  // Cliente del PN
                    $inform[$x][1] = $pns;                 // Número de parte (PN)
                    $inform[$x][2] = $buscarcant;          // Cantidad de ocurrencias
                    $inform[$x][3] = $buscarPrice->price;  // Precio del PN
                    $inform[$x][4] = $buscarPrice->price * $inform[$x][2];  // Total: precio * cantidad
                    $x++;
                } else {
                    // Si no se encuentra un precio, puedes optar por manejar esto de alguna forma
                    // Ejemplo: establecer valores por defecto o registrar una advertencia.
                    $inform[$x][0] = 'Cliente no encontrado';
                    $inform[$x][1] = $pns;
                    $inform[$x][2] = $buscarcant;
                    $inform[$x][3] = 'Precio no disponible';
                    $inform[$x][4] = 0; // Total sería 0 si no hay precio
                    $x++;
                }
            }


            $countReq = count($info);

            $buscarregistross = DB::select("SELECT * FROM registro WHERE Qty>'0'");
            foreach ($buscarregistross as $reg) {
                $price = $reg->price;
                $cant = $reg->Qty;
                $backlock += ($price * $cant);
            }
            if (date("N") == 1) {
                $today = strtotime(date("d-m-Y 00:00", strtotime('-3 days')));
            } else {
                $today = strtotime(date("d-m-Y 00:00", strtotime('-1 days')));
            }
            $count = $preciot = $saldos = 0;
            $fecha = $info = $cliente = $pn = $cantidad = [];
            $tested = DB::select('SELECT * FROM regsitrocalidad ORDER BY id DESC');

            foreach ($tested as $registro) {
                $date = $registro->fecha;
                $code = $registro->info;
                $clients = $registro->client;
                $part = $registro->pn;
                $cant = $registro->resto;
                $fechacontrol = strtotime($date);

                if ($today < $fechacontrol) {
                    if (in_array($code, $info)) {
                        $index = array_search($code, $info);
                        $cantidad[$index] += $cant;
                    } else {
                        $fecha[] = $date;
                        $info[] = $code;
                        $cliente[] = $clients;
                        $pn[] = $part;
                        $cantidad[] = $cant;
                    }
                }

                $count = count($fecha);
            }

            for ($i = 0; $i < $count; $i++) {
                $precioparte = $pn[$i];
                $precio = DB::select("SELECT price FROM precios WHERE pn=?", [$precioparte]);
                foreach ($precio as $pricepn) {
                    //$saldos += $pricepn->price * $cantidad[$i];
                }
            }

            // Prepare the updated table content
            $tableContent = '';
            for ($i = 0; $i < $count; $i++) {
                $tableContent .= '<tr>';
                $tableContent .= '<td>' . $fecha[$i] . '</td>';
                $tableContent .= '<td>' . $pn[$i] . '</td>';
                $tableContent .= '<td>' . $info[$i] . '</td>';
                $tableContent .= '<td>' . $cliente[$i] . '</td>';
                $tableContent .= '<td>' . $cantidad[$i] . '</td>';
                $tableContent .= '</tr>';
            }
            if ($dia != "") {
                $diario = substr($dia, 0, 2) . "-" . substr($dia, 3, 2) . "-" . substr($dia, 6, 4);
                if (date('N') == 1) {
                    $diario = date("d-m-Y", strtotime("-3 days"));
                } else {
                }
                $diario = date("d-m-Y", strtotime("-1 days"));
            } else {
                if (date("N") == 1) {
                    $diario = date("d-m-Y", strtotime('-3 day'));
                } else {
                    $diario = date("d-m-Y", strtotime('-1 day'));
                }
            }
            $ochoAm = $sieteAm = $nueveAm = $diesAm = $onceAm = $docePm = $unaPm = $dosPm = $tresPm = $cuatroPm = $cincoPm = $seisPm = $sietePm = 0;

            $busPorTiemp = DB::table("regsitrocalidad")->where("fecha", "LIKE", "$diario 07:%")
                ->orwhere("fecha", "LIKE", "$diario 08:%")
                ->orwhere("fecha", "LIKE", "$diario 09:%")
                ->orwhere("fecha", "LIKE", "$diario 10:%")
                ->orwhere("fecha", "LIKE", "$diario 11:%")
                ->orwhere("fecha", "LIKE", "$diario 12:%")
                ->orwhere("fecha", "LIKE", "$diario 13:%")
                ->orwhere("fecha", "LIKE", "$diario 14:%")
                ->orwhere("fecha", "LIKE", "$diario 15:%")
                ->orwhere("fecha", "LIKE", "$diario 16:%")
                ->orwhere("fecha", "LIKE", "$diario 17:%")
                ->orwhere("fecha", "LIKE", "$diario 18:%")
                ->orwhere("fecha", "LIKE", "$diario 19:%")
                ->orwhere("fecha", "LIKE", "$diario 20:%")
                ->get();


            foreach ($busPorTiemp as $rowstime) {
                switch (substr($rowstime->fecha, 11, 2)) {
                    case '07':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();

                        $sieteAm += $busarPrecio->price;
                        break;
                    case '08':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $ochoAm += $busarPrecio->price;
                        break;
                    case '09':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $nueveAm += $busarPrecio->price;
                        break;
                    case '10':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $diesAm += $busarPrecio->price;
                        break;
                    case '11':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $onceAm += $busarPrecio->price;
                        break;
                    case '12':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $docePm += $busarPrecio->price;
                        break;
                    case '13':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $unaPm += $busarPrecio->price;
                        break;
                    case '14':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $dosPm += $busarPrecio->price;
                        break;
                    case '15':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $tresPm += $busarPrecio->price;
                        break;
                    case '16':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $cuatroPm += $busarPrecio->price;
                        break;
                    case '17':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $cincoPm += $busarPrecio->price;
                        break;
                    case '18':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $seisPm += $busarPrecio->price;
                        break;
                    case '19':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $sietePm += $busarPrecio->price;
                        break;
                    case '20':
                        $busarPrecio = DB::table('precios')->select('price')->where('pn', $rowstime->pn)->first();
                        $sietePm += $busarPrecio->price;
                        break;
                }
            }
            $plan = $cort = $libe = $ensa = $cali = $espc = $loom = 0;
            $buscarWoCount = DB::table("registro")->select('count')->where('count', '<', 20)->get();
            foreach ($buscarWoCount as $rowReg) {
                switch ($rowReg->count) {
                    case '1':
                        $plan++;
                        break;
                    case '2':
                        $cort++;
                        break;
                    case '3':
                        $cort++;
                        break;
                    case '4':
                        $libe++;
                        break;
                    case '5':
                        $libe++;
                        break;
                    case '6':
                        $ensa++;
                        break;
                    case '7':
                        $ensa++;
                        break;
                    case '15':
                        $espc++;
                        break;
                    case '8':
                        $loom++;
                        break;
                    case '9':
                        $loom++;
                        break;
                    case '10':
                        $cali++;
                        break;
                    case '11':
                        $cali++;
                        break;
                }
            }
            for ($i = 0; $i <= 13; $i++) {
                $lieaVenta[$i] = 0;
            }

            $dato = [$plan, $cort, $libe, $ensa, $espc, $loom, $cali];
            $label = ['Plannig', 'Cutting', 'Terminals', 'Assembly', 'Special Wire', 'Looming', 'Quality'];
            $labelss = ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15::00', '16:00', '17:00', '18:00', '19:00'];

            $tiemposPas[0] = $tiemposPas[1] = $tiemposPas[2] = 0;

            $datoss = [$sieteAm, $ochoAm, $nueveAm, $diesAm, $onceAm, $docePm, $unaPm, $dosPm, $tresPm, $cuatroPm, $cincoPm, $seisPm, $sietePm];
            for ($i = 0; $i < count($datoss); $i++) {
                for ($j = 0; $j <= $i; $j++) {
                    $lieaVenta[$i] += $datoss[$j];
                }
            }

            $saldos = $sieteAm + $ochoAm + $nueveAm + $diesAm + $onceAm + $docePm + $unaPm + $dosPm + $tresPm + $cuatroPm + $cincoPm + $seisPm + $sietePm;
            $buscarPassView = DB::table('registro')->select('*')->get();
            foreach ($buscarPassView as $rowPass) {
                $fecha = strtotime(date("d-m-Y"));
                $entrega = strtotime($rowPass->reqday);
                $fecha7 = strtotime('+7 days');
                if ($fecha > $entrega) {
                    $tiemposPas[0] += 1;
                } else if ($fecha <= $entrega and $fecha7 >= $entrega) {
                    $tiemposPas[1] += 1;
                } else if ($fecha7 < $entrega) {
                    $tiemposPas[2] += 1;
                }
            }


            return view('juntas')->with([
                'ventasStation' => $ventasStation,
                'inform' => $inform,
                'value' => $value,
                'countReq' => $countReq,
                'cat' => $cat,
                'client' => $client,
                'tableContent' => $tableContent,
                'saldos' => $saldos,
                'backlock' => $backlock,
                'labelss' => $labelss,
                'datoss' => $datoss,
                'label' => $label,
                'dato' => $dato,
                'tiemposPas' => $tiemposPas,
                'lieaVenta' => $lieaVenta
            ]);
        }
    }
    public function calidad_junta()
    {
        $value = session('user');
        $cat = session('categoria');
        $empRes = $empleados = $datos = $etiq = $gultyY = [];
        $totalb = $totalm = $j = 0;
        $monthAndYear = date("m-Y");
        $today = date('d-m-Y 00:00');
        if (date("N") == 1) {
            $datecontrol = strtotime(date("d-m-Y 00:00", strtotime("-3 days")));
            $crtl = date("d-m-Y", strtotime("-3 days"));
        } else {
            $datecontrol = strtotime(date("d-m-Y 00:00", strtotime("-1 days")));
            $crtl = date("d-m-Y", strtotime("-1 days"));
        }
        $buscarValoresMes = DB::table('regsitrocalidad')
            ->where('codigo', '!=', "TODO BIEN")
            ->where('fecha', 'LIKE', $crtl . '%')
            ->get();
        foreach ($buscarValoresMes as $rows) {
            if (in_array($rows->codigo, $etiq)) {
                $index = array_search($rows->codigo, $etiq);
                $datos[$etiq[$index]] += $rows->resto;
            } else {
                $etiq[] = $rows->codigo;
                $index = count($etiq) - 1; // Index of the last added element
                $datos[$etiq[$index]] = $rows->resto;
            }
            if (in_array($rows->Responsable . " - " . $rows->pn, array_column($gultyY, 0))) {
                $gultyY[array_search($rows->Responsable . " - " . $rows->pn, array_column($gultyY, 0))][1] += $rows->resto;
            } else {
                $gultyY[$j][0] = $rows->Responsable . " - " . $rows->pn;
                $gultyY[$j][1] = $rows->resto;
                $j++;
            }
        }
        $regvg = $regvb = $regjg = $regjb = $regmg = $regmb = $regmtg = $regmtb = $reglg = $reglb = $regsg = $regsb = 0;
        function Paretos($regb, $regM)
        {
            $regB = $regb;
            $regm = $regM;
            $registro = $regB + $regm;
            if ($regB > 0) {
                $rest = round((($regb / $registro) * 100), 2);
            } else {
                $rest = 0;
            }
            return $rest;
        }
        $pareto = $monthAndYearPareto = [];
        if (date("N") == 1) {
            $datoss = (date("d-m-Y", strtotime("-2 days")));
            $datosv = (date("d-m-Y", strtotime("-3 days")));
            $datosj = (date("d-m-Y", strtotime("-4 days")));
            $datosm = (date("d-m-Y", strtotime("-5 days")));
            $datosmt = (date("d-m-Y", strtotime("-6 days")));
            $datosl = (date("d-m-Y", strtotime("-7 days")));
            $buscarValorespareto = DB::table('regsitrocalidad')
                ->where('fecha', 'LIKE', "$datosv%")
                ->orWhere('fecha', 'LIKE', "$datosj%")
                ->orWhere('fecha', 'LIKE', "$datosm%")
                ->orWhere('fecha', 'LIKE', "$datosmt%")
                ->orWhere('fecha', 'LIKE', "$datosl%")
                ->orWhere('fecha', 'LIKE', "$datoss%")
                ->get();
            foreach ($buscarValorespareto as $rowPareto) {
                if (substr($rowPareto->fecha, 0, 10) == $datoss) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $regvg += 1;
                    } else {
                        $regvb += 1;
                    }
                }
                if (substr($rowPareto->fecha, 0, 10) == $datosv) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $regvg += 1;
                    } else {
                        $regvb += 1;
                    }
                }
                if (substr($rowPareto->fecha, 0, 10) == $datosj) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $regjg += 1;
                    } else {
                        $regjb += 1;
                    }
                }
                if (substr($rowPareto->fecha, 0, 10) == $datosm) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $regmg += 1;
                    } else {
                        $regmb += 1;
                    }
                }
                if (substr($rowPareto->fecha, 0, 10) == $datosmt) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $regmtg += 1;
                    } else {
                        $regmtb += 1;
                    }
                }
                if (substr($rowPareto->fecha, 0, 10) == $datosl) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $reglg += 1;
                    } else {
                        $reglb += 1;
                    }
                }
            }
            $pareto[$datosl] = Paretos($reglg, $reglb);
            $pareto[$datosmt] = Paretos($regmtg, $regmtb);
            $pareto[$datosm] = Paretos($regmg, $regmb);
            $pareto[$datosj] = Paretos($regjg, $regjb);
            $pareto[$datosv] = Paretos($regvg, $regvb);
            // $pareto[$datoss]=Paretos($regsg,$regsb);
            $totalm = $regvb;
            $totalb = $regvg;
        } else if (date("N") == 2) {
            $datosl = (date("d-m-Y", strtotime("-1 days")));
            $buscarValorespareto = DB::table('regsitrocalidad')
                ->Where('fecha', 'LIKE', "$datosl%")
                ->get();
            foreach ($buscarValorespareto as $rowPareto) {
                if (substr($rowPareto->fecha, 0, 10) == $datosl) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $reglg += 1;
                    } else {
                        $reglb += 1;
                    }
                }
            }
            $pareto[$datosl] = Paretos($reglg, $reglb);
            $totalm = $reglb;
            $totalb = $reglg;
        } elseif (date("N") == 3) {
            $datosl = (date("d-m-Y", strtotime("-1 days")));
            $datosmt = (date("d-m-Y", strtotime("-2 days")));
            $buscarValorespareto = DB::table('regsitrocalidad')
                ->Where('fecha', 'LIKE', "$datosmt%")
                ->orWhere('fecha', 'LIKE', "$datosl%")
                ->get();
            foreach ($buscarValorespareto as $rowPareto) {
                if (substr($rowPareto->fecha, 0, 10) == $datosmt) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $regmtg += 1;
                    } else {
                        $regmtb += 1;
                    }
                }
                if (substr($rowPareto->fecha, 0, 10) == $datosl) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $reglg += 1;
                    } else {
                        $reglb += 1;
                    }
                }
            }
            $pareto[$datosl] = Paretos($reglg, $reglb);
            $pareto[$datosmt] = Paretos($regmtg, $regmtb);
            $totalm = $reglb;
            $totalb = $reglg;
        } elseif (date("N") == 4) {
            $datosl = (date("d-m-Y", strtotime("-3 days")));
            $datosmt = (date("d-m-Y", strtotime("-2 days")));
            $datosm = (date("d-m-Y", strtotime("-1 days")));
            $buscarValorespareto = DB::table('regsitrocalidad')
                ->Where('fecha', 'LIKE', "$datosl%")
                ->orWhere('fecha', 'LIKE', "$datosmt%")
                ->orWhere('fecha', 'LIKE', "$datosm%")
                ->get();
            foreach ($buscarValorespareto as $rowPareto) {
                if (substr($rowPareto->fecha, 0, 10) == $datosl) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $reglg += 1;
                    } else {
                        $reglb += 1;
                    }
                }
                if (substr($rowPareto->fecha, 0, 10) == $datosmt) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $regmtg += 1;
                    } else {
                        $regmtb += 1;
                    }
                }
                if (substr($rowPareto->fecha, 0, 10) == $datosm) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $regmg += 1;
                    } else {
                        $regmb += 1;
                    }
                }
            }
            $pareto[$datosl] = Paretos($reglg, $reglb);
            $pareto[$datosmt] = Paretos($regmtg, $regmtb);
            $pareto[$datosm] = Paretos($regmg, $regmb);
            $totalm = $regmb;
            $totalb = $regmg;
        } elseif (date("N") == 6 or date("N") == 5) {
            $datosl = (date("d-m-Y", strtotime("-1 days")));
            $datosmt = (date("d-m-Y", strtotime("-2 days")));
            $datosm = (date("d-m-Y", strtotime("-3 days")));
            $datosj = (date("d-m-Y", strtotime("-4 days")));
            $buscarValorespareto = DB::table('regsitrocalidad')
                ->Where('fecha', 'LIKE', "$datosj%")
                ->orWhere('fecha', 'LIKE', "$datosm%")
                ->orWhere('fecha', 'LIKE', "$datosmt%")
                ->orWhere('fecha', 'LIKE', "$datosl%")
                ->get();

            foreach ($buscarValorespareto as $rowPareto) {
                if (substr($rowPareto->fecha, 0, 10) == $datosj) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $regjg += 1;
                    } else {
                        $regjb += 1;
                    }
                }
                if (substr($rowPareto->fecha, 0, 10) == $datosm) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $regmg += 1;
                    } else {
                        $regmb += 1;
                    }
                }
                if (substr($rowPareto->fecha, 0, 10) == $datosmt) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $regmtg += 1;
                    } else {
                        $regmtb += 1;
                    }
                }
                if (substr($rowPareto->fecha, 0, 10) == $datosl) {
                    if ($rowPareto->codigo == 'TODO BIEN') {
                        $reglg += 1;
                    } else {
                        $reglb += 1;
                    }
                }
            }
            $pareto[$datosl] = Paretos($reglg, $reglb);
            $pareto[$datosmt] = Paretos($regmtg, $regmtb);
            $pareto[$datosm] = Paretos($regmg, $regmb);
            $pareto[$datosj] = Paretos($regjg, $regjb);
            $totalm = $reglb;
            $totalb = $reglg;
        }
        $yearGood = $yearBad = $monthGood = $monthBad = $weekGood = $weekBad = $lastmonthGood = $lastmonthBad = 0;
        $monthAndYear = date("m-Y");
        $YearParto = date("Y");
        $lastyear = date("12-Y", strtotime("-1 years"));
        $weekslas = "Week " . date("W", strtotime("-1 weeks"));
        $buscarValorPareto = DB::table('regsitrocalidad')
            ->where('fecha', 'LIKE', "%$YearParto%")
            ->orderBy('Responsable', 'ASC')
            ->get();
        foreach ($buscarValorPareto as $rowPareto) {
            if ($rowPareto->codigo == 'TODO BIEN') {
                $yearGood += 1;
            } else {
                $yearBad += 1;
                if (!in_array($rowPareto->Responsable, $empRes)) {
                    array_push($empRes, $rowPareto->Responsable);
                }
            }
            if (substr($rowPareto->fecha, 3, 7) == $monthAndYear) {
                if ($rowPareto->codigo == 'TODO BIEN') {
                    $monthGood += 1;
                } else {
                    $monthBad += 1;
                    if (key_exists($rowPareto->Responsable, $empleados)) {
                        $empleados[$rowPareto->Responsable] += 1;
                    } else {
                        $empleados[$rowPareto->Responsable] = 1;
                    }
                }
            }
        }
        $monthAndYearPareto[$monthAndYear] = Paretos($monthGood, $monthBad);
        $monthAndYearPareto[$YearParto] = Paretos($yearGood, $yearBad);
        $lastmonth = date("m-Y", strtotime("-1 months"));
        $registrosCalidad = DB::table('regsitrocalidad')
            ->where('fecha', 'LIKE', "%$lastmonth%")
            ->get();
        foreach ($registrosCalidad as $rowPareto) {
            if ($rowPareto->codigo == 'TODO BIEN') {
                $lastmonthGood += 1;
            } else {
                $lastmonthBad += 1;
            }
        }
        $monthAndYearPareto[$lastmonth] = Paretos($lastmonthGood, $lastmonthBad);

        function getDaysForWeek()
        {
            $days = [];
            for ($day = 1; $day <= 7; $day++) {
                $weekNumber = date("W", strtotime("-1 weeks"));
                $year = date("Y");
                $date = Carbon::now()
                    ->setISODate($year, $weekNumber, $day);
                $days[] = $date->format('d-m-Y');
            }
            return $days;
        }
        $days = getDaysForWeek();
        $weevalues = DB::table('regsitrocalidad')
            ->where('fecha', 'LIKE', "$days[0]%")
            ->orWhere('fecha', 'LIKE', "$days[1]%")
            ->orWhere('fecha', 'LIKE', "$days[2]%")
            ->orWhere('fecha', 'LIKE', "$days[3]%")
            ->orWhere('fecha', 'LIKE', "$days[4]%")
            ->orWhere('fecha', 'LIKE', "$days[5]%")
            ->orWhere('fecha', 'LIKE', "$days[6]%")
            ->get();
        foreach ($weevalues as $rowParetos) {
            if ($rowParetos->codigo == 'TODO BIEN') {
                $weekGood += 1;
            } else {
                $weekBad += 1;
            }
        }
        $monthAndYearPareto[$weekslas] = Paretos($weekGood, $weekBad);

        // arsort($monthAndYearPareto);
        //ksort($pareto);
        arsort($datos);
        $firstKey = key($datos);
        $datosF = $pnrs = $datosT = $datosS = [];
        // Query the database to retrieve records where 'codigo' column matches the $firstKey
        $buscardatosClientes = DB::table('regsitrocalidad')->where('codigo', '=', $firstKey)
            ->where('fecha', 'LIKE', $crtl . '%')->orderBy('pn')->get();
        foreach ($buscardatosClientes as $rowDatos) {
            if ((in_array($rowDatos->client, array_column($datosF, 0)) and (in_array($rowDatos->pn, array_column($datosF, 3))))) {
                $datosF[$rowDatos->pn][2] += $rowDatos->resto;
            } else {
                $datosF[$rowDatos->pn][0] = $rowDatos->client;
                $datosF[$rowDatos->pn][1] = $rowDatos->codigo;
                $datosF[$rowDatos->pn][2] = $rowDatos->resto;
                $datosF[$rowDatos->pn][3] = $rowDatos->pn;
            }
        }
        next($datos);
        $secondKey = key($datos);
        $buscardatosClientes2 = DB::table('regsitrocalidad')->where('codigo', '=', $secondKey)
            ->where('fecha', 'LIKE', $crtl . '%')->orderBy('pn')->get();
        foreach ($buscardatosClientes2 as $rowDatos2) {
            if ((in_array($rowDatos2->client, array_column($datosS, 0)) and (in_array($rowDatos2->pn, array_column($datosS, 3))))) {
                $datosS[$rowDatos2->pn][2] += $rowDatos2->resto;
            } else {
                $datosS[$rowDatos2->pn][0] = $rowDatos2->client;
                $datosS[$rowDatos2->pn][1] = $rowDatos2->codigo;
                $datosS[$rowDatos2->pn][2] = $rowDatos2->resto;
                $datosS[$rowDatos2->pn][3] = $rowDatos2->pn;
            }
        }
        next($datos);
        $thirdKey = key($datos);
        $buscardatosClientes3 = DB::table('regsitrocalidad')->where('codigo', $thirdKey)
            ->where('fecha', 'LIKE', $crtl . '%')->orderBy('codigo')->get();
        foreach ($buscardatosClientes3 as $rowDatos3) {
            //
            if (in_array($rowDatos3->client, array_column($datosT, 0)) and (in_array($rowDatos3->pn, array_column($datosT, 3)))) {
                $datosT[$rowDatos3->pn][2] += $rowDatos3->resto;
            } else {
                $datosT[$rowDatos3->pn][0] = $rowDatos3->client;
                $datosT[$rowDatos3->pn][1] = $rowDatos3->codigo;
                $datosT[$rowDatos3->pn][2] = $rowDatos3->resto;
                $datosT[$rowDatos3->pn][3] = $rowDatos3->pn;
            }
        }
        //quality Q
        $Qdays = $colorQ = $labelQ = [];
        $maxDays = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        for ($i = 0; $i < $maxDays; $i++) {
            $Qdays[$i] = 1;
            $labelQ[$i] = $i + 1;
        }
        $todayD = date('d');
        for ($i = 0; $i < $todayD; $i++)
            if ($labelQ[$i] == 33 or $labelQ[$i] == 34 or $labelQ[$i] == 35 or $labelQ[$i] == 36) {
                $colorQ[$i] = 'red';
            } else {
                $colorQ[$i] = 'green';
            }
        rsort($datosT);
        asort($datosS);
        rsort($datosF);
        $datosHoy = $gulty = [];
        $i = $x = $hoyb = $hoymal = $parhoy = 0;
        $issues = DB::table('regsitrocalidad')
            ->where('fecha', 'LIKE', date('d-m-Y') . "%")
            ->get();
        foreach ($issues as $issue) {
            if ($issue->codigo == 'TODO BIEN') {
                $hoyb += $issue->resto;
            } else {
                $hoymal += $issue->resto;

                if (key_exists($issue->codigo . "-" . $issue->pn, $datosHoy)) {
                    $datosHoy[$issue->codigo . "-" . $issue->pn][2] += $issue->resto;
                } else {
                    $datosHoy[$issue->codigo . "-" . $issue->pn][0] = $issue->client;
                    $datosHoy[$issue->codigo . "-" . $issue->pn][1] = $issue->codigo;
                    $datosHoy[$issue->codigo . "-" . $issue->pn][2] = $issue->resto;
                    $datosHoy[$issue->codigo . "-" . $issue->pn][3] = $issue->pn;
                    $i++;
                }
                if (in_array($issue->Responsable, array_column($gulty, 0))) {
                    $gulty[array_search($issue->Responsable, array_column($gulty, 0))][1] += $issue->resto;
                } else {
                    $gulty[$x][0] = $issue->Responsable;
                    $gulty[$x][1] = $issue->resto;
                    $x++;
                }
            }
        }
        $parhoy = Paretos($hoyb, $hoymal);
        ksort($datosHoy);
        if (!empty($gulty)) {
            arsort($gulty);
        }
        if (!empty($gultyY)) {
            arsort($gultyY);
        }
        arsort($empleados); // Asegura que esté ordenado de mayor a menor

        $top5 = [];
        $i = 0;

        foreach ($empleados as $nombre => $cantidad) {
            if ($i >= 10) break;
            $top5[$nombre] = $cantidad;
            $i++;
        }
        asort($top5);

        return view('juntas/calidad', ['respemp' => $empRes, 'empleados' => $top5, 'days' => $days, 'hoyb' => $hoyb, 'hoymal' => $hoymal, 'parhoy' => $parhoy, 'gultyY' => $gultyY, 'gulty' => $gulty, 'datosHoy' => $datosHoy, 'totalm' => $totalm, 'totalb' => $totalb, 'monthAndYearPareto' => $monthAndYearPareto, 'datosT' => $datosT, 'datosS' => $datosS, 'datosF' => $datosF, 'labelQ' => $labelQ, 'colorQ' => $colorQ, 'value' => $value, 'cat' => $cat, 'datos' => $datos, 'pareto' => $pareto, 'Qdays' => $Qdays]);
    }

    public function litas_junta($id)
    {
        $value = session('user');
        $cat = session('categoria');
        $datosTabla = [];
        if ($id == "") {
            redirect()->route('juntas');
        } else if ($id == "planeacion") {
            $buscarDatos = DB::table('registro')
                ->where('count', '=', '1')
                ->orderBy('tiempototal', 'DESC')
                ->get();
            $i = 0;
            foreach ($buscarDatos as $rows) {
                $datosTabla[$i][0] = $rows->cliente;
                $datosTabla[$i][1] = $rows->NumPart;
                $datosTabla[$i][2] = $rows->wo;
                $datosTabla[$i][3] = $rows->Qty;
                $datosTabla[$i][4] = $rows->tiempototal;
                $datosTabla[$i][5] = $rows->price;
                $datosTabla[$i][6] = $rows->Qty * $rows->price;
                $datosTabla[$i][7] = $rows->reqday;
                $i++;
            }
        } else if ($id == "corte") {
            $buscarDatos = DB::table('registro')
                ->join('registroparcial', 'registro.info', '=', 'registroparcial.codeBar')
                ->where('cortPar', '!=', '0')
                ->get();
            $i = 0;
            foreach ($buscarDatos as $rows) {
                $datosTabla[$i][0] = $rows->cliente;
                $datosTabla[$i][1] = $rows->NumPart;
                $datosTabla[$i][2] = $rows->wo;
                $datosTabla[$i][3] = $rows->cortPar;
                $datosTabla[$i][4] = $rows->tiempototal;
                $datosTabla[$i][5] = $rows->price;
                $datosTabla[$i][6] = $rows->cortPar * $rows->price;
                $datosTabla[$i][7] = $rows->reqday;
                $i++;
            }
        } else if ($id == "liberacion") {
            $buscarDatos = DB::table('registro')
                ->join('registroparcial', 'registro.info', '=', 'registroparcial.codeBar')
                ->where('libePar', '!=', '0')
                ->get();
            $i = 0;
            foreach ($buscarDatos as $rows) {
                $datosTabla[$i][0] = $rows->cliente;
                $datosTabla[$i][1] = $rows->NumPart;
                $datosTabla[$i][2] = $rows->wo;
                $datosTabla[$i][3] = $rows->libePar;
                $datosTabla[$i][4] = $rows->tiempototal;
                $datosTabla[$i][5] = $rows->price;
                $datosTabla[$i][6] = $rows->libePar * $rows->price;
                $datosTabla[$i][7] = $rows->reqday;
                $i++;
            }
        } else if ($id == "ensamble") {
            $buscarDatos = DB::table('registro')
                ->join('registroparcial', 'registro.info', '=', 'registroparcial.codeBar')
                ->where('ensaPar', '!=', '0')
                ->get();
            $i = 0;
            foreach ($buscarDatos as $rows) {
                $datosTabla[$i][0] = $rows->cliente;
                $datosTabla[$i][1] = $rows->NumPart;
                $datosTabla[$i][2] = $rows->wo;
                $datosTabla[$i][3] = $rows->ensaPar;
                $datosTabla[$i][4] = $rows->tiempototal;
                $datosTabla[$i][5] = $rows->price;
                $datosTabla[$i][6] = $rows->ensaPar * $rows->price;
                $datosTabla[$i][7] = $rows->reqday;
                $i++;
            }
        } else if ($id == "loom") {
            $buscarDatos = DB::table('registro')
                ->join('registroparcial', 'registro.info', '=', 'registroparcial.codeBar')
                ->where('loomPar', '!=', '0')
                ->get();
            $i = 0;
            foreach ($buscarDatos as $rows) {
                $datosTabla[$i][0] = $rows->cliente;
                $datosTabla[$i][1] = $rows->NumPart;
                $datosTabla[$i][2] = $rows->wo;
                $datosTabla[$i][3] = $rows->loomPar;
                $datosTabla[$i][4] = $rows->tiempototal;
                $datosTabla[$i][5] = $rows->price;
                $datosTabla[$i][6] = $rows->loomPar * $rows->price;
                $datosTabla[$i][7] = $rows->reqday;
                $i++;
            }
        } else if ($id == "prueba") {
            $buscarDatos = DB::table('registro')
                ->join('registroparcial', 'registro.info', '=', 'registroparcial.codeBar')
                ->where('testPar', '!=', '0')
                ->get();
            $i = 0;
            foreach ($buscarDatos as $rows) {
                $datosTabla[$i][0] = $rows->cliente;
                $datosTabla[$i][1] = $rows->NumPart;
                $datosTabla[$i][2] = $rows->wo;
                $datosTabla[$i][3] = $rows->testPar;
                $datosTabla[$i][4] = $rows->tiempototal;
                $datosTabla[$i][5] = $rows->price;
                $datosTabla[$i][6] = $rows->testPar * $rows->price;
                $datosTabla[$i][7] = $rows->reqday;
                $i++;
            }
        } else if ($id == "embarque") {
            $buscarDatos = DB::table('registro')
                ->join('registroparcial', 'registro.info', '=', 'registroparcial.codeBar')
                ->where('embPar', '!=', '0')
                ->get();
            $i = 0;
            foreach ($buscarDatos as $rows) {
                $datosTabla[$i][0] = $rows->cliente;
                $datosTabla[$i][1] = $rows->NumPart;
                $datosTabla[$i][2] = $rows->wo;
                $datosTabla[$i][3] = $rows->embPar;
                $datosTabla[$i][4] = $rows->tiempototal;
                $datosTabla[$i][5] = $rows->price;
                $datosTabla[$i][6] = $rows->embPar * $rows->price;
                $datosTabla[$i][7] = $rows->reqday;
                $i++;
            }
        }

        return view('juntas/lista', ['value' => $value, 'cat' => $cat, 'buscarDatos' => $buscarDatos, 'datosTabla' => $datosTabla]);
    }
    public function litas_reg(Request $request)
    {

        return view('juntas/reg', ['value' => session('user'), 'cat' => session('categoria')]);
    }
    public function mostrarWOJ(Request $request)
    {
        $buscarWo = $request->input('buscarWo');
        $datosWo = $datosPass = $pnReg = $regftq = $paretos = [];
        $tableContent = $tableReg = $tableftq = $pullTest = '';
        $i = $ok = $nog = 0;



        $buscar = DB::table('registroparcial')
            ->orwhere('pn', 'like', $buscarWo . '%')
            ->orWhere('pn', 'like', '%' . $buscarWo)
            ->orWhere('pn', 'like', '%' . $buscarWo . '%')
            ->get();
        foreach ($buscar as $row) {
            $tableContent .= '<tr>';
            $tableContent .= '<td>' . $row->pn . '</td>';
            $tableContent .= '<td>' . $row->wo . '</td>';
            $tableContent .= '<td>' . $row->orgQty . '</td>';
            $tableContent .= '<td>' . $row->cortPar . '</td>';
            $tableContent .= '<td>' . $row->libePar . '</td>';
            $tableContent .= '<td>' . $row->ensaPar . '</td>';
            $tableContent .= '<td>' . $row->loomPar . '</td>';
            $tableContent .= '<td>' . $row->preCalidad . '</td>';
            $tableContent .= '<td>' . $row->testPar . '</td>';
            $tableContent .= '<td>' . $row->embPar . '</td>';
            $tableContent .= '<td>' . $row->eng . '</td>';
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
                    $tableReg .= '<td>' . $rowR->np . '</td>';
                    $tableReg .= '<td>' . $rowR->wo . '</td>';
                    $tableReg .= '<td>' . $rowR->qty . '</td>';
                    $tableReg .= '<td>' . $rowR->fechaout . '</td>';
                    $tableReg .= '</tr>';
                }
            } else {
                $tableReg .= '<tr>';
                $tableReg .= '<td></td>';
                $tableReg .= '<td>' . '0' . '</td>';
                $tableReg .= '<td>' . '0' . '</td>';
                $tableReg .= '<td>' . '0' . '</td>';
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
                    $tableftq .= '<td>' . $key . '</td>';
                    $tableftq .= '<td>' . $value . '</td>';
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
                        $pullTest .= '<td>' . $rowPull->fecha . '</td>';
                        $pullTest .= '<td>' . $rowPull->Num_part . '</td>';
                        $pullTest .= '<td>' . $rowPull->calibre . '</td>';
                        $pullTest .= '<td>' . $rowPull->presion . '</td>';
                        $pullTest .= '<td>' . $rowPull->forma . '</td>';
                        $pullTest .= '<td>' . $rowPull->cont . '</td>';
                        $pullTest .= '<td>' . $rowPull->quien . '</td>';
                        $pullTest .= '<td>' . $rowPull->val . '</td>';
                        $pullTest .= '<td>' . $rowPull->tipo . '</td>';
                    }
                } else {
                    $pullTest = '';
                }
            } else {
                $paretos[0] = 0;
                $paretos[1] = 0;
                $paretos[2] = 0;
                $tableftq .= '<tr>';
                $tableftq .= '<td>' . '0' . '</td>';
                $tableftq .= '<td>' . '0' . '</td>';
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
    }

    public function ing_junta()
    {
        $monthYear = date('m-Y');
        $lastMonth = date('m-Y', strtotime("-1 months"));

        $datos = ['Soporte en piso', 'Seguimiento PPAP', 'Otro', 'Juntas', 'Documentacion', 'Comida', 'Colocacion de full size'];
        $defaultValues = array_fill(0, count($datos), 0);
        $actividades = array_combine($datos, $defaultValues);
        $actividadesLastMonth = array_combine($datos, $defaultValues);
        $jesus = array_combine($datos, $defaultValues);
        $pao = array_combine($datos, $defaultValues);
        $nancy = array_combine($datos, $defaultValues);
        $ale = array_combine($datos, $defaultValues);
        $carlos = array_combine($datos, $defaultValues);
        $arturo = array_combine($datos, $defaultValues);
        $jorge = array_combine($datos, $defaultValues);
        $brandon = array_combine($datos, $defaultValues);
        $tiemposDatosIng = DB::table('ingactividades')
            ->where('count', '=', '4')
            ->where('fecha', 'LIKE', '%-' . $monthYear . '%')
            ->orderBy('actividades', 'desc')
            ->get();
        foreach ($tiemposDatosIng as $row) {
            $timeIni = $timeFin = $timetotal = 0;
            $timeIni = strtotime($row->fecha);
            $timeFin = strtotime($row->finT);
            $timetotal = ($timeFin - $timeIni) / 60;
            if (key_exists($row->actividades, $actividades)) {
                $actividades[$row->actividades] += $timetotal;
            } else {
                $actividades[$row->actividades] = $timetotal;
            }
            if ($row->Id_request == 'Nancy A') {
                if (key_exists($row->actividades, $nancy)) {
                    $nancy[$row->actividades] += $timetotal;
                } else {
                    $nancy[$row->actividades] = $timetotal;
                }
            }
            if ($row->Id_request == 'Jesus C') {
                if (key_exists($row->actividades, $jesus)) {
                    $jesus[$row->actividades] += $timetotal;
                } else {
                    $jesus[$row->actividades] = $timetotal;
                }
            }
            if ($row->Id_request == 'Paola S') {
                if (key_exists($row->actividades, $pao)) {
                    $pao[$row->actividades] += $timetotal;
                } else {
                    $pao[$row->actividades] = $timetotal;
                }
            }
            if ($row->Id_request == 'Alejandro V') {
                if (key_exists($row->actividades, $ale)) {
                    $ale[$row->actividades] += $timetotal;
                } else {
                    $ale[$row->actividades] = $timetotal;
                }
            }
            if ($row->Id_request == 'Carlos R') {
                if (key_exists($row->actividades, $carlos)) {
                    $carlos[$row->actividades] += $timetotal;
                } else {
                    $carlos[$row->actividades] = $timetotal;
                }
            }
            if ($row->Id_request == 'Arturo S') {
                if (key_exists($row->actividades, $arturo)) {
                    $arturo[$row->actividades] += $timetotal;
                } else {
                }
            }
            if ($row->Id_request == 'Jorge G') {
                if (key_exists($row->actividades, $jorge)) {
                    $jorge[$row->actividades] += $timetotal;
                } else {
                    $jorge[$row->actividades] = $timetotal;
                }
            }
            if ($row->Id_request == 'Brandon S') {
                if (key_exists($row->actividades, $brandon)) {
                    $brandon[$row->actividades] += $timetotal;
                } else {
                    $brandon[$row->actividades] = $timetotal;
                }
            }
        }
        $tiemposDatosIng = DB::table('ingactividades')
            ->where('count', '=', '4')
            ->where('fecha', 'LIKE', '%-' . $lastMonth . '%')
            ->orderBy('actividades', 'desc')
            ->get();
        foreach ($tiemposDatosIng as $row) {
            $timeIni = $timeFin = $timetotal = 0;
            $timeIni = strtotime($row->fecha);
            $timeFin = strtotime($row->finT);
            $timetotal = ($timeFin - $timeIni) / 60;
            if (key_exists($row->actividades, $actividadesLastMonth)) {
                $actividadesLastMonth[$row->actividades] += $timetotal;
            } else {
                $actividadesLastMonth[$row->actividades] = $timetotal;
            }
        }
        $jesp = $nanp = $bp = $jcp = $psp = $alv = $asp = $jg = $todas = [];
        $datos2 = ['corte', 'liberacion', 'ensamble', 'loom', 'calidad'];
        $defVal = array_fill(0, count($datos2), 0);
        $jesp = array_combine($datos2, $defVal);
        $nanp = array_combine($datos2, $defVal);
        $bp = array_combine($datos2, $defVal);
        $jcp = array_combine($datos2, $defVal);
        $psp = array_combine($datos2, $defVal);
        $alv = array_combine($datos2, $defVal);
        $asp = array_combine($datos2, $defVal);
        $jg = array_combine($datos2, $defVal);
        $todas = array_combine($datos2, $defVal);

        $datosIng = DB::table('ppap')
            ->where('fecha', 'LIKE', '%-' . $monthYear . '%')
            ->orderBy('codigo', 'desc')
            ->get();
        foreach ($datosIng as $row) {
            if ($row->codigo == 'Arturo S') {
                $asp[$row->area] += 1;
            } else if ($row->codigo == 'Jorge G') {
                $jg[$row->area] += 1;
            } else if ($row->codigo == 'PAOLA S') {
                $psp[$row->area] += 1;
            } else if ($row->codigo == 'Alejandro V' or $row->codigo == 'Alex V') {
                $alv[$row->area] += 1;
            } else if ($row->codigo == 'Carlos R') {
                $jcp[$row->area] += 1;
            } else if ($row->codigo == 'Jesus_C' or $row->codigo == 'Victor_E') {
                $jesp[$row->area] += 1;
            } else if ($row->codigo == 'Nancy A') {
                $nanp[$row->area] += 1;
            }
            $todas[$row->area] += 1;
        }

        //work Schedule dounut
        $month = (int) date('m');
        $year = date('Y');
        $lmt =  'Jan';
        $porcentaje = $porcentajeMalos = $buenos = $malos = $total = 0;
        $porcentajemes1 = $porcentajemes = 0;
         $last12Months =$thisYearGoals = [];
        $workSchedule = DB::table('workschedule')

            ->where('commitmentDate', 'LIKE',   $month . '/%/' . $year)
            ->where('CompletionDate', '!=', '')
            ->orderBy('id', 'desc')
            ->get();
        foreach ($workSchedule as $row) {
            $timeIni = $timeFin = 0;
            $timeIni = strtotime($row->commitmentDate);
            $timeFin = strtotime($row->CompletionDate);
            if ($timeFin > $timeIni) {
                $malos += 1;
            } else {
                $buenos += 1;
            }
            $total++;
        }
        if ($total > 0) {
            $porcentaje = round(($buenos / $total) * 100, 2);
            $porcentajeMalos = round(($malos / $total) * 100, 2);
        } else {
            $porcentaje = 0;
            $porcentajeMalos = 0;
        }
        //this year goals

         for ($i = 0; $i < 12; $i++) {
            $total = $buenos = $malos = 0;
            $last12Month = DB::table('workschedule')
                ->where('commitmentDate', 'LIKE', $i+1 . '/%/' . $year)
                ->where('CompletionDate', '!=', '')
                ->orderBy('id', 'desc')
                ->get();
            foreach ($last12Month as $row) {
                $timeIni = $timeFin = 0;
                $timeIni = strtotime($row->commitmentDate);
                $timeFin = strtotime($row->CompletionDate);
                if ($timeFin > $timeIni) {
                    $malos += 1;
                } else {
                    $buenos += 1;
                }
                $total++;
            }
            if ($total > 0) {
                $porcentajemes1 = round(($buenos / $total) * 100, 2); } else { $porcentajemes1 = 0;
            }
            $thisYearGoals[$i .' '.$lmt.'-' . $year ] = $porcentajemes1;
            $lmt = date('M', strtotime($lmt . ' +1 month'));
        }

        //Last 12 Months Goals
        $lmt = 'Jan';
        $lmy = date('Y', strtotime('-1 year'));
        for ($i = 0; $i < 12; $i++) {
            $total = $buenos = $malos = 0;
            $last12Month = DB::table('workschedule')
                ->where('commitmentDate', 'LIKE', $i+1 . '/%/' . $lmy)
                ->where('CompletionDate', '!=', '')
                ->orderBy('id', 'desc')
                ->get();
            foreach ($last12Month as $row) {
                $timeIni = $timeFin = 0;
                $timeIni = strtotime($row->commitmentDate);
                $timeFin = strtotime($row->CompletionDate);
                if ($timeFin > $timeIni) {
                    $malos += 1;
                } else {
                    $buenos += 1;
                }
                $total++;
            }
            if ($total > 0) {
                $porcentajemes = round(($buenos / $total) * 100, 2); } else { $porcentajemes = 0;
            }
            $last12Months[$i .' '.$lmt.'-' . $lmy ] = $porcentajemes;
            $lmt = date('M', strtotime($lmt . ' +1 month'));

        }


        return view('juntas/ing', ['thisYearGoals' => $thisYearGoals,'last12Months'=> $last12Months,'porcentaje' => $porcentaje, 'porcentajeMalos' => $porcentajeMalos, 'todas' => $todas, 'jesp' => $jesp, 'nanp' => $nanp, 'bp' => $bp, 'jcp' => $jcp, 'psp' => $psp, 'alv' => $alv, 'asp' => $asp, 'jg' => $jg, 'jesus' => $jesus, 'pao' => $pao, 'nancy' => $nancy, 'ale' => $ale, 'carlos' => $carlos, 'arturo' => $arturo, 'jorge' => $jorge, 'brandon' => $brandon, 'actividadesLastMonth' => $actividadesLastMonth, 'actividades' => $actividades, 'value' => session('user'), 'cat' => session('categoria')]);
    }
    public function cutAndTerm()
    {
        $value = session('user');
        $cat = session('categoria');
        $i = $j = 0;
        $cutData = $libeData = [];
        //days
        function DiasEntre($startDate, $endDate)
        {
            $period = CarbonPeriod::create($startDate, $endDate);
            return collect($period)
                ->filter(fn($date) => $date->isWeekday())
                ->count();
        }
        if (!$value and !$cat) {
            session()->flash('error', 'No tienes acceso a esta sección.');
            return redirect()->route('login');
        }
        //Search cutting on registro table and join with tiempo table to get time
        $buscarCorte = DB::table('registro')
            ->join('tiempos', 'registro.info', '=', 'tiempos.info')
            ->where('planeacion', '!=', '')
            ->where('count', '>', '1')
            ->where('count', '<', '6')
            ->orderBy('registro.id', 'desc')
            ->get();
        if (count($buscarCorte) > 0) {
            foreach ($buscarCorte as $rows) {
                if ($rows->count < 4) {
                    $cutData[$i][0] = $rows->cliente;
                    $cutData[$i][1] = $rows->NumPart;
                    $cutData[$i][2] = $rows->wo;
                    //search info on registroparcial table
                    $buscarInfo = DB::table('registroparcial')
                        ->where('codeBar', '=', $rows->info)
                        ->first();
                    if ($buscarInfo) {
                        $cutData[$i][3] = ($buscarInfo->cortPar + $buscarInfo->libePar) / $buscarInfo->orgQty * 100;
                    } else {
                        $cutData[$i][3] = 0;
                    }
                    $cutData[$i][4] = $rows->planeacion;
                    if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) >= 5 and $rows->cliente == 'TICO MANUFACTURING') {
                        $cutData[$i][5] = 'rgba(255, 1, 1, 0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 4 and $rows->cliente == 'TICO MANUFACTURING') {
                        $cutData[$i][5] = 'rgba(249, 104, 0, 0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 3 and $rows->cliente == 'TICO MANUFACTURING') {
                        $cutData[$i][5] = 'rgba(255, 234, 0, 0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 2 and $rows->cliente == 'TICO MANUFACTURING') {
                        $cutData[$i][5] = 'rgba(145, 255, 0,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 1 and $rows->cliente == 'TICO MANUFACTURING') {
                        $cutData[$i][5] = 'rgba(51, 131, 51,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) >= 4) {
                        $cutData[$i][5] = 'rgba(237, 52, 52,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 3) {
                        $cutData[$i][5] = 'rgba(249, 131, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 2) {
                        $cutData[$i][5] = 'rgba(249, 231, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 1) {
                        $cutData[$i][5] = 'rgba(121, 193, 27,0.6)';
                    } else {
                        $cutData[$i][5] = 'rgba(0, 0, 0,0.6)';
                    }

                    $i++;
                } else if ($rows->count < 6) {
                    $libeData[$j][0] = $rows->cliente;
                    $libeData[$j][1] = $rows->NumPart;
                    $libeData[$j][2] = $rows->wo;
                    //search info on registroparcial table
                    $buscarInfo = DB::table('registroparcial')
                        ->where('codeBar', '=', $rows->info)
                        ->first();
                    if ($buscarInfo) {
                        $libeData[$j][3] = ($buscarInfo->cortPar + $buscarInfo->libePar) / $buscarInfo->orgQty * 100;
                    } else {
                        $libeData[$j][3] = 0;
                    }
                    $libeData[$j][4] = $rows->planeacion;
                    if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) >= 5 and $rows->cliente == 'TICO MANUFACTURING') {
                        $libeData[$j][5] = 'rgba(255, 0, 0, 0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 4 and $rows->cliente == 'TICO MANUFACTURING') {
                        $libeData[$j][5] = 'rgba(249, 131, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 3 and $rows->cliente == 'TICO MANUFACTURING') {
                        $libeData[$j][5] = 'rgba(249, 231, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 2 and $rows->cliente == 'TICO MANUFACTURING') {
                        $libeData[$j][5] = 'rgba(121, 193, 27,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 1 and $rows->cliente == 'TICO MANUFACTURING') {
                        $libeData[$j][5] = 'rgba(51, 131, 51,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) >= 4) {
                        $libeData[$j][5] = 'rgba(237, 52, 52,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 3) {
                        $libeData[$j][5] = 'rgba(249, 131, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 2) {
                        $libeData[$j][5] = 'rgba(249, 231, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 1) {
                        $libeData[$j][5] = 'rgba(121, 193, 27,0.6)';
                    }

                    $j++;
                } else {
                    $cutData[$i][0] = 'No hay datos';
                    $cutData[$i][1] = 'No hay datos';
                    $cutData[$i][2] = 'No hay datos';
                    $cutData[$i][3] = 'No hay datos';
                    $cutData[$i][4] = 'No hay datos';
                }
            }
        }
        return view('juntas/cutAndTerm', ['value' => $value, 'cat' => $cat, 'cutData' => $cutData, 'libeData' => $libeData]);
    }
    function assemblyLoom()
    {
        $value = session('user');
        $cat = session('categoria');
        $i = $j = 0;
        $cutData = $loomData = [];
        //days

        if (!$value and !$cat) {
            session()->flash('error', 'No tienes acceso a esta sección.');
            return redirect()->route('login');
        }
        //Search cutting on registro table and join with tiempo table to get time
        $buscarCorte = DB::table('registro')
            ->join('tiempos', 'registro.info', '=', 'tiempos.info')
            ->where('planeacion', '!=', '')
            ->where('count', '>', '1')
            ->where('count', '<', '6')
            ->orderBy('registro.id', 'desc')
            ->get();
        if (count($buscarCorte) > 0) {
            foreach ($buscarCorte as $rows) {
                if ($rows->count < 4) {
                    $cutData[$i][0] = $rows->cliente;
                    $cutData[$i][1] = $rows->NumPart;
                    $cutData[$i][2] = $rows->wo;
                    //search info on registroparcial table
                    $buscarInfo = DB::table('registroparcial')
                        ->where('codeBar', '=', $rows->info)
                        ->first();
                    if ($buscarInfo) {
                        $cutData[$i][3] = ($buscarInfo->cortPar + $buscarInfo->libePar) / $buscarInfo->orgQty * 100;
                    } else {
                        $cutData[$i][3] = 0;
                    }
                    $cutData[$i][4] = $rows->planeacion;
                    if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) >= 5 and $rows->cliente == 'TICO MANUFACTURING') {
                        $cutData[$i][5] = 'rgba(255, 1, 1, 0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 4 and $rows->cliente == 'TICO MANUFACTURING') {
                        $cutData[$i][5] = 'rgba(249, 104, 0, 0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 3 and $rows->cliente == 'TICO MANUFACTURING') {
                        $cutData[$i][5] = 'rgba(255, 234, 0, 0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 2 and $rows->cliente == 'TICO MANUFACTURING') {
                        $cutData[$i][5] = 'rgba(145, 255, 0,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 1 and $rows->cliente == 'TICO MANUFACTURING') {
                        $cutData[$i][5] = 'rgba(51, 131, 51,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) >= 4) {
                        $cutData[$i][5] = 'rgba(237, 52, 52,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 3) {
                        $cutData[$i][5] = 'rgba(249, 131, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 2) {
                        $cutData[$i][5] = 'rgba(249, 231, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 1) {
                        $cutData[$i][5] = 'rgba(121, 193, 27,0.6)';
                    } else {
                        $cutData[$i][5] = 'rgba(0, 0, 0,0.6)';
                    }

                    $i++;
                } else if ($rows->count < 6) {
                    $loomData[$j][0] = $rows->cliente;
                    $loomData[$j][1] = $rows->NumPart;
                    $loomData[$j][2] = $rows->wo;
                    //search info on registroparcial table
                    $buscarInfo = DB::table('registroparcial')
                        ->where('codeBar', '=', $rows->info)
                        ->first();
                    if ($buscarInfo) {
                        $loomData[$j][3] = ($buscarInfo->cortPar + $buscarInfo->libePar) / $buscarInfo->orgQty * 100;
                    } else {
                        $loomData[$j][3] = 0;
                    }
                    $loomData[$j][4] = $rows->planeacion;
                    if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) >= 5 and $rows->cliente == 'TICO MANUFACTURING') {
                        $loomData[$j][5] = 'rgba(255, 0, 0, 0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 4 and $rows->cliente == 'TICO MANUFACTURING') {
                        $loomData[$j][5] = 'rgba(249, 131, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 3 and $rows->cliente == 'TICO MANUFACTURING') {
                        $loomData[$j][5] = 'rgba(249, 231, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 2 and $rows->cliente == 'TICO MANUFACTURING') {
                        $loomData[$j][5] = 'rgba(121, 193, 27,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 1 and $rows->cliente == 'TICO MANUFACTURING') {
                        $loomData[$j][5] = 'rgba(51, 131, 51,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) >= 4) {
                        $loomData[$j][5] = 'rgba(237, 52, 52,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 3) {
                        $loomData[$j][5] = 'rgba(249, 131, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 2) {
                        $loomData[$j][5] = 'rgba(249, 231, 48,0.6)';
                    } else if (DiasEntre(substr($rows->planeacion, 0, 10), date('d-m-Y')) == 1) {
                        $loomData[$j][5] = 'rgba(121, 193, 27,0.6)';
                    }

                    $j++;
                } else {
                    $loomData[$i][0] = 'No hay datos';
                    $loomData[$i][1] = 'No hay datos';
                    $loomData[$i][2] = 'No hay datos';
                    $loomData[$i][3] = 'No hay datos';
                    $loomData[$i][4] = 'No hay datos';
                }
            }
        }
        return view('juntas/cutAndTerm', ['value' => $value, 'cat' => $cat, 'cutData' => $cutData, 'loomData' => $loomData]);
    }

    public function seguimientos()
    {
        $value = session('user');
        $cat = session('categoria');
        $i = 0;
        $buscarDatos = [];
        $tiempos = DB::table('registro')
            ->join('tiempos', 'registro.info', '=', 'tiempos.info')
            ->where('count', '<', '20')
            ->select('registro.*', 'tiempos.*', 'registro.id as ids')
            ->orderBy('registro.id', 'ASC')
            ->get();

        function deffColores($InitDays, $systemFinish, $lastStatus)
        {
            $DiasEntre = function ($inicio, $fin) {
                $period = \Carbon\CarbonPeriod::create($inicio, $fin);
                $diasHabiles = 0;

                foreach ($period as $date) {
                    if ($date->isWeekday()) {
                        $diasHabiles++;
                    }
                }
                return $diasHabiles;
            };

            $filtro =  $DiasEntre($InitDays, $systemFinish) ;
            if ($lastStatus == 'ini' or $lastStatus != 'late') {
                if ($filtro <= 1) {
                    return 'onTime';
                } else if ($filtro == 2) {
                    return 'onWorking';
                } else if ($filtro == 3) {
                    return 'closeToexpiring';
                } else if ($filtro >= 4) {
                    return 'late';
                } else {
                    return '';
                }
            } elseif ($lastStatus == 'late') {
                if ($filtro == 1) {
                    return 'delayedOnTime';
                } elseif ($filtro == 2) {
                    return 'delayed';
                } else if ($filtro == 3) {
                    return 'delayedandclosedtoexpiring';
                } else if ($filtro >= 4) {
                    return 'late';
                } else {
                    return '';
                }
            }
        }
        function deffColorescompletos($InitDays, $systemFinish,$process)
        {
            $DiasEntre = function ($inicio, $fin) {
                $period = \Carbon\CarbonPeriod::create($inicio, $fin);
                $diasHabiles = 0;

                foreach ($period as $date) {
                    if ($date->isWeekday()) {
                        $diasHabiles++;
                    }
                }
                return $diasHabiles;
            };

            $filtro =  $DiasEntre($InitDays, $systemFinish) ;
            if($filtro > $process){
                return 'late';
            }else{
                return 'onTime';
            }
        }


        foreach ($tiempos as $rows) {
            $buscarDatos[$i][0] = $rows->cliente;
            $buscarDatos[$i][1] = $rows->NumPart;
            $buscarDatos[$i][2] = $rows->wo;
            $buscarDatos[$i][3] = $rows->planeacion ? Carbon::parse($rows->planeacion)->format('d-m-Y') : Carbon::parse($rows->fecha)->format('d-m-Y');
            $buscarDatos[$i][4] = $rows->Qty;
            $buscarDatos[$i][5] = $rows->liberacion ? substr($rows->liberacion, 0, 10) :Carbon::parse($buscarDatos[$i][3])->addWeekdays(2)->format('d-m-Y');
            $buscarDatos[$i][6] = $rows->ensamble ? substr($rows->ensamble, 0, 10) :Carbon::parse($buscarDatos[$i][5])->addWeekdays(2)->format('d-m-Y');
            $buscarDatos[$i][7] = $rows->loom ? substr($rows->loom, 0, 10) :Carbon::parse($buscarDatos[$i][6])->addWeekdays(1)->format('d-m-Y');
            $buscarDatos[$i][8] = $rows->calidad ? substr($rows->calidad, 0, 10) :Carbon::parse($buscarDatos[$i][7])->addWeekdays(1)->format('d-m-Y');
            $buscarDatos[$i][9] = $buscarDatos[$i][8];
            $buscarIssue=DB::table('issuesfloor')->select('actionOfComment')->where('id_tiempos','=',$rows->ids)->where('actionOfComment','=','On Hold')->first();
            if($buscarIssue){
                $buscarDatos[$i][10] = 'onHold';
                $buscarDatos[$i][11] = 'onHold';
                $buscarDatos[$i][12] = 'onHold';
                $buscarDatos[$i][13] = 'onHold';
                $buscarDatos[$i][14] = 'onHold';
            }else{
            $buscarDatos[$i][10] =$rows->liberacion ? deffColorescompletos($buscarDatos[$i][3], $buscarDatos[$i][5], 2): deffColores($buscarDatos[$i][3], Carbon::now(), 'ini');
             if($rows->ensamble ){$buscarDatos[$i][11] = deffColorescompletos($buscarDatos[$i][5], $buscarDatos[$i][6], 2);
             } elseif($rows->liberacion){$buscarDatos[$i][11] = deffColores($buscarDatos[$i][6], Carbon::now(), $buscarDatos[$i][10]);}
            else{ $buscarDatos[$i][11] ='';}

            if($rows->loom){$buscarDatos[$i][12] = deffColorescompletos($buscarDatos[$i][6], $buscarDatos[$i][7], 2);
            } elseif($rows->ensamble){$buscarDatos[$i][12] = deffColores($buscarDatos[$i][7], Carbon::now(), $buscarDatos[$i][11]);}
            else{ $buscarDatos[$i][12] ='';}

            if($rows->calidad){$buscarDatos[$i][13] = deffColorescompletos($buscarDatos[$i][7], $buscarDatos[$i][8], 2);
            } elseif($rows->loom){$buscarDatos[$i][13] = deffColores($buscarDatos[$i][8], Carbon::now(), $buscarDatos[$i][12]);}
            else{ $buscarDatos[$i][13] ='';}

            if($rows->calidad){$buscarDatos[$i][14] = deffColorescompletos($buscarDatos[$i][8], $buscarDatos[$i][9], 2);
            } elseif($rows->loom){$buscarDatos[$i][14] = deffColores($buscarDatos[$i][9], Carbon::now(), $buscarDatos[$i][13]);}
            else{ $buscarDatos[$i][14] ='';}

        }
            $buscarDatos[$i][15] = $rows->ids;



            $i++;
        }


        return view('juntas/seguimiento', ['value' => session('user'), 'cat' => session('categoria'), 'buscarDatos' => $buscarDatos]);
    }
    public function seguimiento($id)
    {
        $i = 0;
        $datosInforRegistro = $commentsBefore=[];
        $bucarRegistros = DB::table('registro')
            ->join('tiempos', 'registro.info', '=', 'tiempos.info')
            ->where('registro.id', '=', $id)
            ->select('registro.*', 'tiempos.*')
            ->orderBy('registro.id', 'desc')
            ->get();
        foreach ($bucarRegistros as $row) {
            $datosInforRegistro[0] = $row->NumPart;
            $datosInforRegistro[1] = $row->wo;
            $datosInforRegistro[2] = $row->cliente;
            $datosInforRegistro[3] = $row->planeacion;
            $datosInforRegistro[4] = $row->Qty;
            $datosInforRegistro[5] = $row->liberacion;
            $datosInforRegistro[6] = $row->ensamble;
            $datosInforRegistro[7] = $row->loom;
            $datosInforRegistro[8] = $row->calidad;
            if ($row->planeacion) {
                $datosInforRegistro[9] = Carbon::parse($row->planeacion)->format('d-m-Y');
                $datosInforRegistro[10] = Carbon::parse($row->planeacion)->addWeekdays(2)->format('d-m-Y');
                $datosInforRegistro[11] = Carbon::parse($row->planeacion)->addWeekdays(4)->format('d-m-Y');
                $datosInforRegistro[12] = Carbon::parse($row->planeacion)->addWeekdays(5)->format('d-m-Y');
                $datosInforRegistro[13] = Carbon::parse($row->planeacion)->addWeekdays(6)->format('d-m-Y');
                $datosInforRegistro[14] = Carbon::parse($row->planeacion)->addWeekdays(6)->format('d-m-Y');
            } else {
                $datosInforRegistro[9] = Carbon::parse($row->fecha)->format('d-m-Y');
                $datosInforRegistro[10] = Carbon::parse($row->fecha)->addWeekdays(2)->format('d-m-Y');
                $datosInforRegistro[11] = Carbon::parse($row->fecha)->addWeekdays(4)->format('d-m-Y');
                $datosInforRegistro[12] = Carbon::parse($row->fecha)->addWeekdays(5)->format('d-m-Y');
                $datosInforRegistro[13] = Carbon::parse($row->fecha)->addWeekdays(6)->format('d-m-Y');
                $datosInforRegistro[14] = Carbon::parse($row->fecha)->addWeekdays(6)->format('d-m-Y');
            }
        }
        $buscar = DB::table('issuesfloor')
            ->where('id_tiempos', '=', $id)
            ->where('actionOfComment', '!=', 'Ok')
            ->orderBy('id_issues', 'desc')
            ->get();

        foreach ($buscar as $rows) {
            $commentsBefore[$i][0] = $rows->comment_issue;
            $commentsBefore[$i][1] = $rows->date;
            $commentsBefore[$i][2] = $rows->responsable;
            $commentsBefore[$i][3] = $rows->actionOfComment;
            $i++;
        }

        return view('juntas/infoIdSeguimiento', ['commentsBefore'=> $commentsBefore,'value' => session('user'), 'cat' => session('categoria'), 'id' => $id, 'datosInforRegistro' => $datosInforRegistro]);
    }
    public function registroComment(Request $request)
    {
        $datosOk=$request->input('dataok');
        if($datosOk){
            $updateRegistros = DB::table('issuesfloor')->where('id_tiempos', '=', $datosOk)->where('actionOfComment', '!=', 'Ok')->update(['actionOfComment' => 'Issue Fixed']);
           $registroUp= new issuesFloor();
           $registroUp->id_tiempos=$datosOk;
           $registroUp->comment_issue='-';
           $registroUp->date=Carbon::now();
           $registroUp->responsable=session('user') . ' ' . session('categoria');
           $registroUp->actionOfComment='Ok';
           $registroUp->save();
        }
        $request->validate([
            'comments' => 'required',
            'status_issue' => 'required',

        ]);
        $value= session('user');
        $cat= session('categoria');

        $issuesRegister = new issuesFloor();
        $issuesRegister->id_tiempos = $request->input('id_issue');
        $issuesRegister->comment_issue = $request->input('comments');
        $issuesRegister->date = $request->input('date_issue');
        $issuesRegister->responsable = $value . ' ' . $cat;
        $issuesRegister->actionOfComment = $request->input('status_issue');
        $issuesRegister->save();
        return redirect()->route('seguimiento', ['id' => $request->input('id_issue')]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Maintanance;
use App\Models\material;
use App\Models\Paros;
use App\Models\calidadRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Mail\Mailables;
use Illuminate\Support\Facades\Mail;
use App\Models\timeDead;
use App\Models\regParTime;
use App\Models\listaCalidad;
use App\Models\fallasCalidadModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class caliController extends generalController
{
    public function __invoke()
    {
        $value = session('user');
        $cat = session('categoria');
        if (empty($value)) {
            return redirect('/');
        } else {
            $buscarcalidad = DB::table("calidad")->get();
            $i = 0;
            $calidad = [];
            $fallas = [];
            foreach ($buscarcalidad as $rowcalidad) {
                $calidad[$i][0] = $rowcalidad->np;
                $calidad[$i][1] = $rowcalidad->client;
                $calidad[$i][2] = $rowcalidad->wo;
                $calidad[$i][3] = $rowcalidad->po;
                $calidad[$i][4] = $rowcalidad->qty;
                $calidad[$i][5] = $rowcalidad->parcial;
                $calidad[$i][6] = $rowcalidad->id;
                $calidad[$i][7] = $rowcalidad->info;
                $i++;
            }

            $timesReg = strtotime(date("d-m-Y 00:00")) - 86400;
            /*$registros=[];
                $i=0;
                $buscReg=DB::table('regsitrocalidad')->orderBy('id','DESC')->limit(250)->get();
                foreach($buscReg as $rowReg){
                    $registros[$i][0]=$rowReg->fecha;
                        $registros[$i][1]=$rowReg->client;
                        $registros[$i][2]=$rowReg->pn;
                        $registros[$i][3]=$rowReg->resto;
                        $registros[$i][4]=$rowReg->codigo;
                        $registros[$i][5]=$rowReg->prueba;
                        $registros[$i][6]=$rowReg->Responsable;
                        $i++;
                }
                $i=0;
                $buscFallas=DB::table('timedead')->where('area','Calidad')->where('timeFin','=','No Aun')->orderBy('id','DESC')->get();
                foreach($buscFallas as $Fa){
                    $fallas[$i][0]=$Fa->id;
                    $fallas[$i][1]=$Fa->fecha;
                    $fallas[$i][2]=$Fa->cliente;
                    $fallas[$i][3]=$Fa->np;
                    $fallas[$i][4]=$Fa->codigo;
                    $fallas[$i][5]=$Fa->defecto;
                    $fallas[$i][6]=$Fa->respArea;
                    $i++;
                }

                $Generalcontroller=new generalController;
                $generalresult=$Generalcontroller->__invoke();
                $week=$generalresult->getData()['week'];
                $assit=$generalresult->getData()['assit'];
                $paros=$generalresult->getData()['paros'];
                $desviations=$generalresult->getData()['desviations'];
                $materials=$generalresult->getData()['materials'];*/
            //se quitaron
            //'fallas'=>$fallas,'registros'=>$registros,'week'=>$week,'assit'=>$assit,'paros'=>$paros,'desviations'=>$desviations,'materials'=>$materials
            return view('cali', ['cat' => $cat, 'value' => $value, 'calidad' => $calidad]);
        }
    }
    public function baja(Request $request)
    {
        $calicontroller = new generalController();
        $caliresult = $calicontroller->__invoke();
        $value = $caliresult->getData()['value'];
        /* $week = $caliresult->getData()['week'];
        $assit = $caliresult->getData()['assit'];*/
        $cat = $caliresult->getData()['cat'];
        $id = $request->input('id');
        if ($id == '') {
            return redirect()->route('calidad');
        } else {
            $buscarInfo = DB::table('calidad')->where('id', '=', $id)->get();
            foreach ($buscarInfo as $rowInfo) {
                $client = $rowInfo->client;
                $pn = $rowInfo->np;
                $wo = $rowInfo->wo;
                $info = $rowInfo->info;
                $qty = $rowInfo->qty;
            }
            if ($pn == "185-4147" or $pn == "199-4942" or $pn == "199-6660" or $pn == "199-3871" or $pn == "189-6256" or $pn == "190-3559" or $pn == "185-4142") {
                $cambioestados = [1, 'readonly', ''];
            } else {
                $cambioestados = [100, '', 'readonly'];
            }


            return view('cali', [
                'value' => $value,
                'id' => $id,
                'client' => $client,
                'pn' => $pn,
                'wo' => $wo,
                'qty' => $qty,
                'info' => $info,
                //'week'=>$week,
                //'assit'=>$assit,
                'cat' => $cat,
                'cambioestados' => $cambioestados
            ]);
        }
    }
    public function saveData(Request $request)
    {
        $cat = session('categoria');
        if ($cat == 'cali') {
            function deadTime($cod1, $today, $client, $pn, $info, $value, $loom, $corteLibe, $ensa)
            {
                if (strpos($cod1, ';')) {
                    $cod = explode(';', $cod1);
                    for ($i = 0; $i < count($cod); $i++) {
                        $regTimes = new timedead;
                        $regTimes->fecha = $today;
                        $regTimes->cliente = $client;
                        $regTimes->np = $pn;
                        $regTimes->codigo = $info;
                        $regTimes->defecto = $cod[$i];
                        $regTimes->timeIni = strtotime($today);
                        $regTimes->whoDet = $value;
                        if (in_array($cod[$i], $loom)) {
                            $regTimes->respArea = "Jesus Zamarripa";
                        } else if (in_array($cod[$i], $corteLibe)) {
                            $regTimes->respArea = "Juan Olaes";
                        } else if (in_array($cod[$i], $ensa)) {
                            $regTimes->respArea = "David Villalpando";
                        } else {
                            $regTimes->respArea = "";
                        }
                        $regTimes->area = "Calidad";
                        $regTimes->save();
                    }
                } else {
                    $regTimes = new timedead;
                    $regTimes->fecha = $today;
                    $regTimes->cliente = $client;
                    $regTimes->np = $pn;
                    $regTimes->codigo = $info;
                    $regTimes->defecto = $cod1;
                    $regTimes->timeIni = strtotime($today);
                    $regTimes->whoDet = $value;
                    if (in_array($cod1, $loom)) {
                        $regTimes->respArea = "Jesus Zamarripa";
                    } else if (in_array($cod1, $corteLibe)) {
                        $regTimes->respArea = "Juan Olaes";
                    } else if (in_array($cod1, $ensa)) {
                        $regTimes->respArea = "David Villalpando";
                    } else {
                        $regTimes->respArea = "";
                    }
                    $regTimes->area = "Calidad";
                    $regTimes->save();
                }
            }
            function RegistroCalidadFunc($cant1, $cod1, $today, $client, $pn, $info, $value, $responsable1, $serial, $check1)
            {
                $nok_reg = new calidadRegistro;
                $nok_reg->fecha = $today;
                $nok_reg->client = $client;
                $nok_reg->pn = $pn;
                $nok_reg->info = $info;
                $nok_reg->resto = 1;
                $nok_reg->codigo = $cod1;
                $nok_reg->prueba = $serial;
                $nok_reg->usuario = $value;
                $nok_reg->Responsable = $responsable1;
                if ($nok_reg->save()) {
                    if ($check1 == 1) {
                        DB::table('registroparcial')->where('codeBar', '=', $info)->update(['testPar' => DB::raw('testPar- 1'), 'fallasCalidad' => DB::raw('fallasCalidad+1')]);
                        $ultimoRegistro = intval(calidadRegistro::orderBy('id', 'desc')->first()->id);
                        $registroFalla = new fallasCalidadModel;
                        $registroFalla->idCalidad = $ultimoRegistro;
                        $registroFalla->save();
                    } else {
                        DB::table('registroparcial')->where('codeBar', '=', $info)->update(['testPar' => DB::raw('testPar- 1'), 'embPar' => DB::raw('embPar+1')]);
                    }
                }
                return $serial;
            }



            $corteLibe = [
                'Impresion de cable incorrecta',
                'Cable sobrante',
                'Strip fuera de tolerancia',
                'Terminal mal aplicada',
                'Crimp no centrado',
                'Cable con exceso de strip',
                'Cable con strip insuficiente',
                'Filamentos fuera de la terminal',
                'Filamentos trozados',
                'Aislante-InsulaciÃ³n perforada',
                'Pestanas del cobre agarrando forro',
                'Sello trozado',
                'Terminal con exceso de presiÃ³n',
                'Terminal doblada',
                'Terminal no abraza forro',
                'Terminal perforando forro',
                'Terminal quebrada',
                'Terminal sin presion',
                'Empalme Incorrecto',
                'Diodos invertidos',
                'Tubo termocontractil mal colocado',
                'Exceso de soldadura',
                'Soldadura puenteada',
                'Escasez de soldadura'
            ];
            $loom = [
                'Encintado defectuoso de cables y-o de looming',
                'Looming Corrugado danado',
                'Looming Corrugado mal colocado ',
                'Braid mal colocado y-o danado',
                'Etiquetas invertidas'
            ];
            $ensa = [
                'Cables revueltos en los lotes',
                'Medidas fuera de tolerancias',
                'Componente Danado',
                'Componente Incorrecto',
                'Componente Faltante',
                'Ensamble Incorrecto',
                'Terminal o conector mal asentado',
                'Salidas invertidas',
                'Componentes sin atar al arnes',
                'Cables Invertidos en el conector',
                ' no tiene Continuidad Electrica',
                'Arnes con cortocircuito'
            ];

            $personal = [];
            $x = 0;
            $quscarPersonal = DB::table('personalberg')->select('employeeNumber', 'employeeName', 'employeeArea', 'typeWorker', 'employeeLider')->get();
            foreach ($quscarPersonal as $rowPersonal) {
                $personal[$x] = [
                    substr($rowPersonal->employeeNumber, 1, 4),
                    $rowPersonal->employeeName,
                    $rowPersonal->employeeArea,
                    $rowPersonal->typeWorker,
                    $rowPersonal->employeeLider
                ];
                $x++;
            }
            $val = session('user');
            $value = str($val);
            $diff = 0;
            $today = date('d-m-Y H:i');
            $info = $request->input("infoCal");
            $pn = $request->input("pn_cali");
            $client = $request->input("clienteErr");
            $ok = $request->input('ok');
            $nok = $request->input('nok');
            $cod1 = $request->input('rest_code1');
            $cod2 = $request->input('rest_code2');
            $cod3 = $request->input('rest_code3');
            $cod4 = $request->input('rest_code4');
            $cod5 = $request->input('rest_code5');
            $cant1 = $request->input('1');
            $cant2 = $request->input('2');
            $cant3 = $request->input('3');
            $cant4 = $request->input('4');
            $cant5 = $request->input('5');
            $serial = $request->input('serial');
            if (strpos($serial, "'")) {
                $serial = str_replace("'", "-", $serial);
            }
            if (strpos($serial, ']')) {
                $serial = str_replace(']', '|', $serial);
            }

            $responsable1 = $request->input('responsable1');
            $responsable2 = $request->input('responsable2');
            $responsable3 = $request->input('responsable3');
            $responsable4 = $request->input('responsable4');
            $responsable5 = $request->input('responsable5');
            $check1 = $request->input('check1');
            $check2 = $request->input('check2');
            $check3 = $request->input('check3');
            $check4 = $request->input('check4');
            $check5 = $request->input('check5');
            if (strpos($responsable1, ',')) {
                $responsable1 = str_replace(',', ';', $responsable1);
            }
            if (strpos($responsable1, ',')) {
                $responsable1 = str_replace(',', ';', $responsable1);
            }
            if (strpos($responsable2, ',')) {
                $responsable2 = str_replace(',', ';', $responsable2);
            }
            if (strpos($responsable3, ',')) {
                $responsable3 = str_replace(',', ';', $responsable3);
            }
            if (strpos($responsable4, ',')) {
                $responsable4 = str_replace(',', ';', $responsable4);
            }
            if (strpos($responsable5, ',')) {
                $responsable5 = str_replace(',', ';', $responsable5);
            }
            if ($pn == "185-4147" or $pn == "199-4942" or $pn == "199-6660" or $pn == "199-3871" or $pn == "189-6256" or $pn == "190-3559" or $pn == "185-4142") {

                $registroQr = DB::table('registroqrs')->where('infoQr', '=', $info)->where('CodigoIdentificaicon', '=', $serial)->first();
                if (!empty($registroQr)) {
                    $registroQr = DB::table('registroqrs')->where('infoQr', '=', $info)->where('CodigoIdentificaicon', '=', $serial)->delete();
                } else {
                    return redirect('calidad')->with('response', "Qr invalido");
                }
            }
            $busquedainfo = DB::table('calidad')->select('qty', 'wo')->where('info', $info)->first();

            $wo = $busquedainfo->wo;

            $qty_cal = $busquedainfo->qty;
            $total = $ok + $nok;
            if ($total > 100) {
                return redirect('calidad')->with('response', "No update you need to update 100 or less");
            }

            $totalCant = $cant1 + $cant2 + $cant3 + $cant4 + $cant5;
            if ($total <= $qty_cal and $totalCant == $nok) {
                //insert ok
                for ($i = 0; $i < $ok; $i++) {

                    $ok_reg = new calidadRegistro;
                    $ok_reg->fecha = $today;
                    $ok_reg->client = $client;
                    $ok_reg->pn = $pn;
                    $ok_reg->info = $info;
                    $ok_reg->resto = 1;
                    $ok_reg->codigo = "TODO BIEN";
                    $ok_reg->prueba = $serial;
                    $ok_reg->usuario = $value;
                    $ok_reg->save();
                }

                if (!empty($cant1)) {
                    foreach ($personal as $key => $var) {
                        if ($responsable1 == $personal[$key][0]) {
                            $responsable1 = ($personal[$key][1]);
                            break;
                        }
                    }
                    $serial = RegistroCalidadFunc($cant1, $cod1, $today, $client, $pn, $info, $value, $responsable1, $serial, $check1);
                    //  deadTime($cod1,$today,$client,$pn,$info,$value,$loom,$corteLibe,$ensa);
                }
                if (!empty($cant2)) {
                    foreach ($personal as $key => $var) {
                        if ($responsable2 == $personal[$key][0]) {
                            $responsable2 = ($personal[$key][1]);
                            break;
                        }
                    }
                    $serial = RegistroCalidadFunc($cant2, $cod2, $today, $client, $pn, $info, $value, $responsable2, $serial, $check2);
                    // deadTime($cod2,$today,$client,$pn,$info,$value,$loom,$corteLibe,$ensa);
                }
                if (!empty($cant3)) {
                    foreach ($personal as $key => $var) {
                        if ($responsable3 == $personal[$key][0]) {
                            $responsable3 = ($personal[$key][1]);
                            break;
                        }
                    }
                    $serial = RegistroCalidadFunc($cant3, $cod3, $today, $client, $pn, $info, $value, $responsable3, $serial, $check3);
                    //deadTime($cod3,$today,$client,$pn,$info,$value,$loom,$corteLibe,$ensa);
                }
                if (!empty($cant4)) {
                    foreach ($personal as $key => $var) {
                        if ($responsable4 == $personal[$key][0]) {
                            $responsable4 = ($personal[$key][1]);
                            break;
                        }
                    }
                    $serial = RegistroCalidadFunc($cant4, $cod4, $today, $client, $pn, $info, $value, $responsable4, $serial, $check4);
                    //deadTime($cod4,$today,$client,$pn,$info,$value,$loom,$corteLibe,$ensa);
                }
                if (!empty($cant5)) {
                    foreach ($personal as $key => $var) {
                        if ($responsable5 == $personal[$key][0]) {
                            $responsable5 = ($personal[$key][1]);
                            break;
                        }
                    }
                    $serial = RegistroCalidadFunc($cant5, $cod5, $today, $client, $pn, $info, $value, $responsable5, $serial, $check5);
                    //deadTime($cod5,$today,$client,$pn,$info,$value,$loom,$corteLibe,$ensa);
                }

                $rest = $qty_cal - ($ok + $nok);
                $diferenciasEmbarque = $total - $nok;
                $buscarPartial = DB::table('registroparcial')->where('codeBar', '=', $info)->get();
                foreach ($buscarPartial as $row) {
                    $test = $row->testPar;
                    $emba = $row->embPar;
                    $fallaCalidasReg = $row->fallasCalidad;
                    $corte = $row->cortPar;
                    $ensa = $row->ensaPar;
                    $libe = $row->libePar;
                    $loom = $row->loomPar;
                    $preCalidad = $row->preCalidad;
                }
                $upPartial = DB::table('registroparcial')->where('codeBar', '=', $info)->update(['testPar' => $test - $ok, 'embPar' => $emba + $ok]);
                $regTimePar = new regParTime;
                $regTimePar->codeBar = $info;
                $regTimePar->qtyPar = $total;
                $regTimePar->area = $value;
                $regTimePar->fechaReg = $today;
                $regTimePar->save();


                if ($rest > 0) {
                    $updacalidad = DB::table('calidad')->where("info", $info)->update(['qty' => $rest]);
                    $updateToRegistro = DB::table('registro')->where("info", $info)->update(["paro" => "Parcial prueba electrica"]);
                } else if ($rest <= 0) {
                    $todays = (date('d-m-Y H:i'));
                    $buscarReg = DB::table('registro')->where("info", $info)->first();
                    $rev = $buscarReg->rev;
                    $np = $buscarReg->NumPart;
                    if (substr($rev, 0, 4) == 'PPAP' || substr($rev, 0, 4) == 'PRIM') {
                        $updateToEmbarque = DB::table('registro')->where("info", $info)->update(["count" => 18, "donde" => 'En espera de ingenieria', "paro" => ""]);
                    } else {
                        $updateToEmbarque = DB::table('registro')->where("info", $info)->update(["count" => 12, "donde" => 'En espera de embarque', "paro" => ""]);
                    }
                    $delteCalidad = DB::table('calidad')->where("info", $info)->delete();
                    $updatetime = DB::table('timesharn')->where('bar', $info)->update(['qlyF' => $todays]);
                    if ($loom <= 0 && $corte <= 0 && $ensa <= 0 && $libe <= 0 && $preCalidad <= 0) {
                        $tiempoUp = DB::table('tiempos')->where('info', $info)->update(['calidad' => $todays]);
                    }
                }
                return redirect()->route('calidad');
            } else {
                return redirect()->route('calidad');
            }
        } else {
            return redirect()->route('calidad');
        }
    }


    public function buscarcodigo(Request $request)
    {
        $codig1 = $request->input('codigo1');
        $cod1 = [];
        $restCodig = "";
        if (strpos($codig1, ',')) {
            $cod1 = explode(",", $codig1);
            for ($i = 0; $i < count($cod1); $i++) {
                $rest = DB::table('clavecali')->select('defecto')->where('clave', $cod1[$i])->first();
                if ($i < count($cod1) - 1) {

                    $restCodig = $restCodig . $rest->defecto . ';';
                } else {
                    $restCodig = $restCodig . $rest->defecto;
                }
            }
            return response()->json($restCodig);
        } else {
            $buscar = DB::table('clavecali')->select('defecto')->where('clave', $codig1)->first();
            if ($buscar->defecto != null) {

                $restCodig = $buscar;
            }
            return response()->json($restCodig);
        }
    }
    public function codigoCalidad(request $request)
    {
        $codigo = $request->input('code-bar');
        if (strpos($codigo, "'")) {
            $codigo = str_replace("'", "-", $codigo);
        }
        $resp = "";
        $buscar = DB::table('registroparcial')->where('codeBar', '=', $codigo)->first();
        if ($buscar) {
            $resp = "PN: " . (string)$buscar->pn . " WO: " . (string)$buscar->wo . " ";
            if ($buscar->cortPar) {
                $resp .= " Cutting: " . (string)$buscar->cortPar;
            }
            if ($buscar->libePar) {
                $resp .= " Terminals: " . (string)$buscar->libePar;
            }
            if ($buscar->ensaPar) {
                $resp .= " Assembly: " . (string)$buscar->ensaPar;
            }
            if ($buscar->preCalidad) {
                $resp .= " PreQuality: " . (string)$buscar->preCalidad;
            }
            if ($buscar->loomPar) {
                $resp .= " Looming: " . (string)$buscar->loomPar;
            }
            if ($buscar->testPar) {
                $resp .= " Testing: " . (string)$buscar->testPar;
            }
            if ($buscar->embPar) {
                $resp .= " Shipping: " . (string)$buscar->embPar;
            }
            if ($buscar->eng) {
                $resp .= " Engineering: " . (string)$buscar->eng;
            }
            return redirect('calidad')->with('response', $resp);
        } else {


            return redirect('calidad')->with('response', "Record not found");
        }
    }





    public function fetchDatacali()
    {
        $i = $backlock = 0;
        $fecha = $info = $cliente = $pn = $cantidad = $serial = $issue = [];
        $tested = DB::select('SELECT * FROM regsitrocalidad ORDER BY id DESC');

        foreach ($tested as $registro) {
            $date = $registro->fecha;
            $code = $registro->info;
            $client = $registro->client;
            $part = $registro->pn;
            $cant = $registro->resto;
            $issue = $registro->codigo;
            $serial = $registro->prueba;
            $dates = strtotime($date);

            $fechacontrol = strtotime("01-01-2024 00:00");


            if ($dates > $fechacontrol) {


                $fecha[] = $date;
                $cliente[] = $client;
                $pn[] = $part;
                $cantidad[] = $cant;
                $codigo[] = $issue;
                $prueba[] = $serial;
                $i++;
            }
        }
        $tableContent = '';
        for ($j = 0; $j < $i; $j++) {
            $tableContent .= '<tr>';
            $tableContent .= '<td>' . $fecha[$j] . '</td>';
            $tableContent .= '<td>' . $pn[$j] . '</td>';
            $tableContent .= '<td>' . $cliente[$j] . '</td>';
            $tableContent .= '<td>' . $cantidad[$j] . '</td>';
            $tableContent .= '<td>' . $codigo[$j] . '</td>';
            $tableContent .= '<td>' . $prueba[$j] . '</td>';
            $tableContent .= '</tr>';
        }
        $labels = ['Planning', 'Cutting', 'Terminal'];
        $datos = [12, 13, 14];

        $saldo = 0;


        // Create the updated data array
        $updatedData = [
            'tableContent' => $tableContent,
            'saldo' => $saldo,
            'backlock' => $backlock,
            'labels' => $labels,
            'data' => $datos

        ];

        // Return the updated data as JSON response
        return response()->json($updatedData,);
    }

    public function mantCali(Request $request)
    {

        $value = session('user');
        $equip = $request->input('equipo');
        $NomEq = $request->input('nom_equipo');
        $dano = $request->input('dano');
        $area = $request->input('area');
        $today = date('d-m-Y H:i');
        $maint = new Maintanance;
        $maint->fill([
            'fecha' => $today,
            'equipo' => $equip,
            'nombreEquipo' => $NomEq,
            'dano' => $dano,
            'quien' => $value,
            'area' => $area,
            'atiende' => 'Nadie aun',
            'trabajo' => '',
            'Tiempo' => '',
            'inimant' => '',
            'finhora' => ''
        ]);
        if ($maint->save()) {
            return redirect('/calidad')->with('error', 'Failed to save data.');
        }
    }
    public function matCali(Request $request)
    {

        $value = session('user');
        $today = date("d-m-Y");

        for ($i = 0; $i < 5; $i++) {
            $cant[$i] = $request->input('cant' . $i);
            $articulo[$i] = $request->input('articulo' . $i);
            $notas[$i] = $request->input('notas_adicionales' . $i);
        }
        $i = 0;
        $foliant = DB::select("SELECT folio FROM material ORDER BY id DESC LIMIT 1 ");
        $folio = $foliant[0]->folio;
        $folio += 1;
        while ($i < 5) {
            if ($cant[$i] > 0) {
                $newarticulo = new material;
                $newarticulo->folio = $folio;
                $newarticulo->fecha = $today;
                $newarticulo->who = $value;
                $newarticulo->description = $articulo[$i];
                $newarticulo->note = $notas[$i];
                $newarticulo->qty = $cant[$i];
                $newarticulo->aprovadaComp = "";
                $newarticulo->negada = "";
                if (!empty($cant[$i])) {
                    $newarticulo->save();
                }
            }
            $i++;
        }

        return redirect('/calidad');
    }

    public function assiscali(Request $request)
    {
        $names = $request->input('name');
        $dlu = $request->input('dlu');
        $dma = $request->input('dma');
        $dmi = $request->input('dmi');
        $dju = $request->input('dju');
        $dvi = $request->input('dvi');
        $dsa = $request->input('dsa');
        $ddo = $request->input('ddo');
        $dba = $request->input('dba');
        $dbp = $request->input('dbp');
        $dex = $request->input('dex');
        $id = $request->input('id');




        for ($i = 0; $i < count($names); $i++) {
            $name = $names[$i];
            $value_dlu = $dlu[$i];
            $value_dma = $dma[$i];
            $value_dmi = $dmi[$i];
            $value_dju = $dju[$i];
            $value_dvi = $dvi[$i];
            $value_dsa = $dsa[$i];
            $value_ddo = $ddo[$i];
            $value_dba = $dba[$i];
            $value_dbp = $dbp[$i];
            $value_dex = $dex[$i];

            $update = DB::table('assistence')->where('id', '=', $id[$i])
                ->update([
                    'lunes' => $value_dlu,
                    'martes' => $value_dma,
                    'miercoles' => $value_dmi,
                    'jueves' => $value_dju,
                    'viernes' => $value_dvi,
                    'sabado' => $value_dsa,
                    'domingo' => $value_ddo,
                    'bonoAsistencia' => $value_dba,
                    'bonoPuntualidad' => $value_dbp,
                    'extras' => $value_dex
                ]);
        }
        return redirect('/calidad');
    }

    public function timesDead(Request $request)
    {
        $id = $request->input('id');
        $timeNow = strtotime(date('d-m-Y H:i'));
        $buscar = DB::table('timedead')->where('id', '=', $id)->first();
        $timeIni = $buscar->timeIni;
        $Totaltime = $timeNow - $timeIni;
        $total = round($Totaltime / 60, 2);
        $update = DB::table('timedead')->where('id', '=', $id)->update(['timeFin' => $timeNow, 'total' => $total]);
        return redirect('/calidad');
    }
    public function accepted(Request $request)
    {
        $acpt = $request->input('acpt');
        $denied = $request->input('denied');
        $cat = session('categoria');
        $value = session('user');
        if (empty($acpt) && empty($denied)) {
            $preorder = DB::table('registroparcial')->where('preCalidad', '>', 0)->get();

            return view('preorder', ['value' => $value, 'cat' => $cat, 'preorder' => $preorder]);
        } else if (!empty($acpt)) {
            $preorder = DB::table('registroparcial')->where('id', '=', $acpt)->first();
            $barcode = $preorder->codeBar;
            $pn = $preorder->pn;
            $wo = $preorder->wo;
            $qtycal = $preorder->preCalidad;
            $buscarCalida = DB::table('calidad')->where('info', '=', $barcode)->first();
            if ($buscarCalida) {
                $qty = $buscarCalida->qty + $qtycal;
                $update = DB::table('calidad')->where('info', '=', $barcode)->update(['qty' => $qty]);
                $updateParcia = DB::table('registroparcial')->where('codeBar', '=', $barcode)->update(['preCalidad' => 0, 'testPar' => $qty]);
                return redirect('/accepted');
            } else {
                $buscarIfno = DB::table('registro')->where('info', '=', $barcode)->first();
                $newCalidad = new listaCalidad;
                $newCalidad->np = $pn;
                $newCalidad->client = $buscarIfno->cliente;
                $newCalidad->wo = $wo;
                $newCalidad->po = $buscarIfno->po;
                $newCalidad->info = $barcode;
                $newCalidad->qty = $qtycal;
                $newCalidad->parcial = 'SI';
                $newCalidad->save();
                $updateParcia = DB::table('registroparcial')->where('codeBar', '=', $barcode)->update(['preCalidad' => 0, 'testPar' => $qtycal]);

                return redirect('/accepted');
            }
        } else if (!empty($denied)) {
            $buscarParcial = DB::table('registroparcial')->where('id', '=', $denied)->first();
            $preCalidad = $buscarParcial->preCalidad;
            $loomPar = $buscarParcial->loomPar;
            $sum = $loomPar + $preCalidad;
            $barcode = $buscarParcial->codeBar;
            $pn = $buscarParcial->pn;
            $ensamble = $buscarParcial->ensaPar;
            $noloomqy = $preCalidad + $ensamble;
            $noloom = [
                '910985',
                '910987',
                '91304',
                '90863',
                '90843',
                '90844',
                '910966',
                '911031',
                '91318',
                '60744',
                '60745',
                '91267',
                '910958',
                '91277',
                '90833',
                '910988',
                '910992',
                '90836',
                '91315',
                '920628',
                '40742',
                '90943',
                '910956',
                '40741',
                '91175',
                '91164',
                '910980',
                '910982',
                '90834',
                '910508',
                '91194',
                '
                            90835',
                '91583',
                '910968',
                '910350',
                '910651',
                '911028',
                '91195',
                '910886',
                '910965',
                '910962',
                '910824',
                '910887',
                '910964',
                '910659',
                '40304',
                '91222',
                '91518',
                '91518-1',
                '910957',
                '91135',
                '910974',
                '910577',
                '91138',
                '91221',
                '910792',
                '910978',
                '90841',
                '90842',
                '910908',
                '910910',
                '910444',
                '91525',
                '910981',
                '910967',
                '40601',
                '91211',
                '91682',
                '910621',
                '90798',
                '91517',
                '91516',
                '91681',
                '91133',
                '91212',
                '91224',
                '910975',
                '910325',
                '910347',
                '910907',
                '910909',
                '910979',
                '910326',
                '910960',
                '91137',
                '910511',
                '910821',
                '910940',
                '91139',
                '90839',
                '90877',
                '91223',
                '910912',
                '61522',
                '90838',
                '910911',
                '91136',
                '910390',
                '910668',
                '910400',
                '910410',
                '910955',
                '90837',
                '910953',
                '90840',
                '910678',
                '910914',
                '40199',
                '40200',
                '910971',
                '910399',
                '910969',
                '91165',
                '910661',
                '40488',
                '910972',
                '40640',
                '40599',
                '910411',
                '910913',
                '91177',
                '910973',
                '40639',
                '910954',
                '910348',
                '910650',
                '911022',
                '40602',
                '91162',
                '91163',
                '910666',
                '40600',
                '910951',
                '91176',
                '910349',
                '911024',
                '910984',
                '910702',
                '910580',
                '910784',
                '910952',
                '911023',
                '910983',
                '910970',
                '910581',
                '910733',
                '910785',
                '910976',
                '910579',
                '910701',
                '910601',
                '910611',
                '910977',
                '910610',
                '910598',
                '910786',
                '910959',
                '910609',
                '910608',
                '910961',
                '910597',
                '910600',
                '910599',
                '910536',
                '910820',
                '910664',
                '910735',
                '910512',
                '910513',
                '40747',
                '90894',
                '90919',
                '90941'
            ];
            if (in_array($pn, $noloom)) {
                $updateParcia = DB::table('registroparcial')->where('id', '=', $denied)->update(['preCalidad' => 0, 'ensaPar' => $noloomqy]);
                $upCount = DB::table('registro')->where('info', '=', $barcode)->update(['count' => '7', 'donde' => 'Denid by Quality']);
            } else {
                $updateParcia = DB::table('registroparcial')->where('id', '=', $denied)->update(['preCalidad' => 0, 'loomPar' => $sum]);
                $upCount = DB::table('registro')->where('info', '=', $barcode)->update(['count' => '8', 'donde' => 'Denid by Quality']);
            }
            return redirect('/accepted');
        }
    }

    public function fallasCalidad(Request $request)
    {
        $cat = session('categoria');
        $value = session('user');
        $fallasId = $request->input('fallas');
        if (!empty($fallasId)) {
            $buscar = DB::table('regsitrocalidad')->where('id', '=', $fallasId)->first();
            $update = DB::table('registroparcial')
                ->where('codeBar', '=', $buscar->info)
                ->update([
                    'fallasCalidad' => DB::raw('fallasCalidad - 1'),
                    'embPar' => DB::raw('embPar + 1')
                ]);
            $deleteFall = DB::table('fallascalidad')->where('idCalidad', '=', $fallasId)->delete();
            return redirect('/calidad');
        } else {
            $registrosFallas = [];
            $i = 0;
            $fallas = DB::table('fallascalidad')->get();
            foreach ($fallas as $rowfallas) {
                $id = $rowfallas->idCalidad;
                $datosCalidadFallas = DB::table('regsitrocalidad')->where('id', '=', $id)->first();
                $registrosFallas[$i][0] = $datosCalidadFallas->id;
                $registrosFallas[$i][1] = $datosCalidadFallas->pn;
                $registrosFallas[$i][2] = $datosCalidadFallas->codigo;
                $registrosFallas[$i][3] = $datosCalidadFallas->Responsable;
                $registrosFallas[$i][4] = $datosCalidadFallas->info;
                $i++;
            }


            return view('calidad/retrabajos', ['value' => $value, 'cat' => $cat, 'registrosFallas' => $registrosFallas]);
        }
    }



    public function excel_calidad(Request $request)
    {
        $di = $request->input('di'); //26-02-2025 00:00
        $df = $request->input('df'); // 26-02-2025 23.59
        $di = substr($di, 0, 10);
        $df = substr($df, 0, 10);


        // Initialize the spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $t = 2; // Row counter for the data


        $dates = (date('-m-Y'));
        $regmin = DB::table('regsitrocalidad')
            ->select('id')
            ->where('fecha', 'LiKE', $di . '%')
            ->orderBy('id', 'asc')
            ->first();
        if ($regmin) {
            $min = $regmin->id;
        } else {
            $regmin = DB::table('regsitrocalidad')
                ->select('id')
                ->where('fecha', 'LiKE', '%' . $dates . '%')
                ->orderBy('id', 'asc')
                ->first();
            $min = $regmin->id;
        }
        $regmax = DB::table('regsitrocalidad')
            ->select('id')
            ->where('fecha', 'LiKE', $df . '%')
            ->orderBy('id', 'desc')
            ->first();
        if ($regmax) {
            $max = $regmax->id;
        } else {
            $regmax = DB::table('regsitrocalidad')
                ->select('id')

                ->orderBy('id', 'desc')
                ->first();
            $max = $regmax->id;
        }






        $registro = [];

        // Set the headers for the spreadsheet
        $headers = [
            'A1' => 'Fecha',
            'B1' => 'Numero de parte',
            'C1' => 'Codigo',
            'D1' => 'Responsable',
            'E1' => 'Cuenta',
        ];
        // Loop through the headers and add them to the spreadsheet
        foreach ($headers as $cell => $header) {
            $sheet->setCellValue($cell, $header);
        }
        // Get the data within the id range
        $buscarinfo = DB::table('regsitrocalidad')
            ->whereBetween('id', [$min, $max]) // Compare only the id part (between $min, $min)
            ->orderBy('fecha', 'desc')
            ->orderBy('pn', 'desc')
            ->orderBy('codigo', 'desc')
            ->orderBy('Responsable', 'desc')
            ->get();
        foreach ($buscarinfo as $row) {
            if (!isset($registro[$row->fecha][$row->pn][$row->codigo][$row->Responsable])) {
                $registro[$row->fecha][$row->pn][$row->codigo][$row->Responsable] = 1;
            } else {
                $registro[$row->fecha][$row->pn][$row->codigo][$row->Responsable]++;
            }
        }
        // Loop through the records and add them to the spreadsheet
        foreach ($registro as $fecha => $pn) {
            foreach ($pn as $pn => $codigo) {
                foreach ($codigo as $codigo => $responsable) {
                    foreach ($responsable as $responsable => $cuenta) {
                        $sheet->setCellValue('A' . $t, $fecha);
                        $sheet->setCellValue('B' . $t, $pn);
                        $sheet->setCellValue('C' . $t, $codigo);
                        $sheet->setCellValue('D' . $t, $responsable);
                        $sheet->setCellValue('E' . $t, $cuenta);
                        $t++;
                    }
                }
            }
        }

        // Generate the Excel file and output it to the browser
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Reporte de calidad del ' . $di . ' al ' . $df . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}

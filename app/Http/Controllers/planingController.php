<?php

namespace App\Http\Controllers;

use App\Models\Corte;
use App\Models\Kits;
use App\Models\po;
use App\Models\regPar;
use App\Models\specialWireModel;
use App\Models\tiempos;
use App\Models\timesHarn;
use App\Models\Wo;
use App\Models\workScreduleModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class planingController extends Controller
{
    public function planning(Request $request)
    {
        $post = [];
        $des = [];
        $datosP[0] = 0;
        $datosP[1] = 0;
        $datosP[2] = 0;
        $datosP[3] = 0;
        $datosP[5] = 0;
        $datosP[10] = 0;
        $datosP[6] = 0;
        $datosP[8] = 0;
        $datosP[9] = 0;
        $datosP[4] = 0;
        $datosP[7] = 0;
        $datosP[11] = 0;
        $i = 0;
        $j = 0;
        $value = session('user');
        $cat = session('categoria');
        if ($value == '' or $cat == '') {
            return view('login');
        } else {
            $sono = $request->input('sono');
            if (! empty($sono)) {
                $buscarIguales = DB::table('registro')
                    ->where('NumPart', 'LIKE', '%'.$sono.'%')
                    ->orWhere('NumPart', 'LIKE', $sono.'%')
                    ->orWhere('NumPart', 'LIKE', '%'.$sono)
                    ->orderBy('NumPart', 'asc')->get();
                $desiguales = DB::table('retiradad')
                    ->where('np', 'LIKE', '%'.$sono.'%')
                    ->orwhere('np', 'LIKE', $sono.'%')
                    ->orwhere('np', 'LIKE', '%'.$sono)
                    ->orderBy('np', 'asc')->get();
            } elseif (empty($sono)) {
                $buscarIguales = DB::table('registro')
                    ->orderBy('NumPart', 'asc')->limit(100)->get();
                $desiguales = DB::table('retiradad')
                    ->orderBy('np', 'asc')->limit(100)->get();
            }
            foreach ($buscarIguales as $pos) {
                $post[$i][0] = $pos->NumPart;
                $post[$i][1] = $pos->rev;
                $post[$i][2] = $pos->po;
                $post[$i][3] = $pos->Qty;
                $post[$i][4] = $pos->fecha;
                $post[$i][5] = $pos->donde;
                $post[$i][6] = $pos->wo;
                $i++;
            }
            foreach ($desiguales as $rowdes) {
                $des[$j][0] = $rowdes->np;
                $rev = substr($rowdes->codigo, -4);
                $pos = strpos($rev, 'R');
                if ($pos !== false) {
                    $rev = substr($rev, $pos + 1);
                } else {
                    $rev = '-';
                }
                $des[$j][1] = $rev;
                $des[$j][2] = $rowdes->sono;
                $des[$j][3] = $rowdes->qty;
                $des[$j][4] = $rowdes->fechaing;
                if ($rowdes->wo != '') {
                    $des[$j][5] = $rowdes->wo;
                } else {
                    $des[$j][5] = 'Ya se fue';
                }
                $j++;
            }

            $codigoant = $request->input('wo');
            if (! empty($codigoant)) {

                $codigo = DB::select("SELECT * FROM registro  WHERE wo='$codigoant' ORDER BY id DESC LIMIT 1");
                if (count($codigo) > 0) {
                    $codes = $codigo[0]->info;

                    return view('registro/code', ['codes' => $codes, 'cat' => $cat]);
                } else {
                    return redirect()->back()->with('error', 'No se encontro el codigo');
                }
            }

            $labelwo = $request->input('wola');
            $labelbeg = $request->input('label1');
            $labelend = $request->input('label2');
            $corte = [];
            $i = 0;
            $bucarCorteLabel = DB::table('corte')->where('wo', $labelwo)->orderBy('aws', 'ASC')  // Ordena por 'aws'
                ->orderBy('color', 'ASC')  // Luego ordena por 'color'
                ->orderBy('tipo', 'ASC')  // Finalmente ordena por 'tipo'
                ->get();
            if (count($bucarCorteLabel) > 0) {
                foreach ($bucarCorteLabel as $cort) {
                    $corte[$i][0] = $cort->cliente;
                    $corte[$i][1] = $cort->np;
                    $corte[$i][2] = $cort->wo;
                    $corte[$i][3] = $cort->cons;
                    $corte[$i][4] = $cort->color;
                    $corte[$i][5] = $cort->tipo;
                    $corte[$i][6] = $cort->aws;
                    $corte[$i][7] = $cort->codigo;
                    $corte[$i][8] = $cort->term1;
                    $corte[$i][9] = $cort->term2;
                    $corte[$i][10] = $cort->dataFrom;
                    $corte[$i][11] = $cort->dataTo;
                    $corte[$i][12] = $cort->qty;
                    $corte[$i][13] = $cort->tamano;
                    $corte[$i][14] = $cort->conector;
                    $corte[$i][15] = $cort->rev;
                    $i++;
                }

                return view('registro.implabel', ['corte' => $corte, 'cat' => $cat]);
            } else {
                $buscaWo = DB::select("SELECT * FROM registro WHERE wo='$labelwo'");
                if (count($buscaWo) > 0) {
                    foreach ($buscaWo as $wo) {
                        $pn = $wo->NumPart;
                        $cliente = $wo->cliente;
                        $rev = $wo->rev;
                        $qty = $wo->Qty;
                    }

                    return view('registro/implabel', [
                        'pn' => $pn,
                        'cliente' => $cliente,
                        'rev' => $rev,
                        'qty' => $qty,
                        'labelwo' => $labelwo,
                        'labelbeg' => $labelbeg,
                        'labelend' => $labelend,
                        'cat' => $cat,
                    ]);
                }
            }

            $labelswo = $request->input('wk');
            $labelswo = strtoupper($labelswo);

            if (! empty($labelswo)) {
                $corte = [];
                $wor = [];
                $i = 0;
                $x = 0;
                $controlCorte = DB::table('wks')->where('wk', $labelswo)->get();
                foreach ($controlCorte as $row) {
                    $wor[$x] = $row->wo;
                    $x++;
                }
                for ($a = 0; $a < count($wor); $a++) {
                    $bucarCorteLabel = DB::table('corte')->where('wo', 'LIKE', '%'.$wor[$a])->orderBy('aws', 'ASC')  // Ordena por 'aws'
                        ->orderBy('color', 'ASC')  // Luego ordena por 'color'
                        ->orderBy('tipo', 'ASC')  // Finalmente ordena por 'tipo'
                        ->get();
                    if (count($bucarCorteLabel) > 0) {
                        foreach ($bucarCorteLabel as $cort) {
                            $corte[$i][0] = $cort->cliente;
                            $corte[$i][1] = $cort->np;
                            $corte[$i][2] = $cort->wo;
                            $corte[$i][3] = $cort->cons;
                            $corte[$i][4] = $cort->color;
                            $corte[$i][5] = $cort->tipo;
                            $corte[$i][6] = $cort->aws;
                            $corte[$i][7] = $cort->codigo;
                            $corte[$i][8] = $cort->term1;
                            $corte[$i][9] = $cort->term2;
                            $corte[$i][10] = $cort->dataFrom;
                            $corte[$i][11] = $cort->dataTo;
                            $corte[$i][12] = $cort->qty;
                            $corte[$i][13] = $cort->tamano;
                            $corte[$i][14] = $cort->conector;
                            $corte[$i][15] = $cort->rev;
                            $i++;
                        }
                    }
                }
                usort($corte, function ($a, $b) {

                    $result = strcmp($a[6], $b[6]);

                    if ($result === 0) {
                        $result = strcmp($a[7], $b[7]);
                        if ($result === 0) {
                            return strcmp($a[5], $b[5]);
                        }
                    }

                    return $result;
                });

                return view('registro.implabel', ['corte' => $corte, 'cat' => $cat]);
            }
        }

        $checkYear = date('Y');
        $busquedaPo = DB::table('po')->where('fecha', 'like', '%'.$checkYear.'%')->get();
        foreach ($busquedaPo as $posFecha) {
            $postF = $posFecha->fecha;
            $check = substr($postF, 3, 2);
            switch ($check) {
                case '01':
                    $datosP[0] += 1;
                    break;
                case '02':
                    $datosP[1] += 1;
                    break;
                case '03':
                    $datosP[2] += 1;
                    break;
                case '04':
                    $datosP[3] += 1;
                    break;
                case '05':
                    $datosP[4] += 1;
                    break;
                case '06':
                    $datosP[5] += 1;
                    break;
                case '07':
                    $datosP[6] += 1;
                    break;
                case '08':
                    $datosP[7] += 1;
                    break;
                case '09':
                    $datosP[8] += 1;
                    break;
                case '10':
                    $datosP[9] += 1;
                    break;
                case '11':
                    $datosP[10] += 1;
                    break;
                case '12':
                    $datosP[11] += 1;
                    break;
            }
        }
        $answer = [];
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

        return view('planing', ['answer' => $answer, 'des' => $des, 'value' => $value, 'cat' => $cat, 'post' => $post, 'datosP' => $datosP]);
    }

    public function pos(Request $request)
    {
        $cat = session('categoria');
        $value = session('user');
        if ($value == '') {
            return view('login');
        } else {
            // Validate the incoming request
            $request->validate([
                'client' => 'required',
                'pn' => 'required',
                'po' => 'required',
                'qty' => 'required',
                'Rev' => 'required',
                'Description' => 'required',
                'Uprice' => 'required',
                'Enviar' => 'required',
                'Orday' => 'required',
                'Reqday' => 'required',
                'WO' => 'required',
            ]);

            // Retrieve data from the request
            $client = strtoupper($request->input('client'));
            $np = strtoupper($request->input('pn'));
            $po = strtoupper($request->input('po'));
            $qty = $request->input('qty');
            $rev = strtoupper($request->input('Rev'));
            $desc = strtoupper($request->input('Description'));
            $price = $request->input('Uprice');
            $send = strtoupper($request->input('Enviar'));
            $orday = $request->input('Orday');
            $reqday = $request->input('Reqday');
            $wo = $request->input('WO');
            $count = 1;

            // Check for duplicate entry
            $duplicate = Po::where('po', $po)->exists();
            $dupreg = Wo::where('wo', $wo)->exists();
            if ($duplicate or $dupreg) {
                return redirect()->back()->with('error', 'Arnes ya registrado, Revíselo y vuelva a intentarlo');
            }

            $today = date('d-m-Y H:i');

            // Insert data into the Po table
            $poData = new Po;
            $poData->client = $client;
            $poData->pn = $np;
            $poData->fecha = $today;
            $poData->rev = $rev;
            $poData->po = $po;
            $poData->qty = $qty;
            $poData->description = $desc;
            $poData->price = $price;
            $poData->send = $send;
            $poData->orday = $orday;
            $poData->reqday = $reqday;
            $poData->count = $count;
            $poData->quien = $value;

            if ($poData->save()) {

                $newWo = new Wo;
                $newWo->fecha = $today;
                $newWo->NumPart = $np;
                $newWo->cliente = $client;
                $newWo->rev = $rev;
                $newWo->wo = $wo;
                $newWo->po = $po;
                $newWo->Qty = $qty;
                $newWo->Barcode = '0';

                if (substr($rev, 0, 4) == 'PPAP' || substr($rev, 0, 4) == 'PRIM') {
                    $newWo->info = (substr($np, 0, 2).substr($client, 0, 2).$qty.substr($wo, 1, 5).substr($po, 2, 4).'R'.substr($rev, 5));
                } else {
                    $newWo->info = (substr($np, 0, 2).substr($client, 0, 2).$qty.substr($wo, 1, 5).substr($po, 2, 4).'R'.$rev);
                }
                $newWo->donde = 'planeacion';
                $newWo->count = 1;
                $newWo->tiempoTotal = 0;
                $newWo->paro = '';
                $newWo->description = $desc;
                $newWo->price = $price;
                $newWo->sento = $send;
                $newWo->orday = $orday;
                $newWo->reqday = $reqday;
                $newWo->quien = $value;

                if ($newWo->save()) {
                    $times = new tiempos;
                    if (substr($rev, 0, 4) == 'PPAP' || substr($rev, 0, 4) == 'PRIM') {
                        $times->info = (substr($np, 0, 2).substr($client, 0, 2).$qty.substr($wo, 1, 5).substr($po, 2, 4).'R'.substr($rev, 5));
                    } else {
                        $times->info = (substr($np, 0, 2).substr($client, 0, 2).$qty.substr($wo, 1, 5).substr($po, 2, 4).'R'.$rev);
                    }
                    $times->planeacion = '';
                    $times->corte = '';
                    $times->liberacion = '';
                    $times->ensamble = '';
                    $times->loom = '';
                    $times->calidad = '';
                    $times->embarque = '';
                    $times->kitsinicial = '';
                    $times->kitsfinal = '';
                    $times->retrabajoi = '';
                    $times->retrabajof = '';
                    $times->totalparos = '';
                    $times->save();
                    $buscarDatos = DB::table('datos')->where('part_num', '=', $np)->get();
                    if ($buscarDatos->count() > 0) {
                        $savekits = new kits;
                        $savekits->numeroParte = $np;
                        $savekits->qty = $qty;
                        $savekits->wo = $wo;
                        $savekits->status = 'En espera';
                        $savekits->usuario = $value;
                        $savekits->save();
                    }
                    if (substr($rev, 0, 4) == 'PPAP' || substr($rev, 0, 4) == 'PRIM') {
                        $revn = substr($rev, 5);
                    } else {
                        $revn = $rev;
                    }
                    $Buscarcorte = DB::table('listascorte')
                        ->where('pn', '=', $np)
                        ->where('rev', '=', $revn)
                        ->get();
                    if (count($Buscarcorte) > 0) {
                        foreach ($Buscarcorte as $corte) {
                            $ADDcorte = new Corte;
                            $ADDcorte->np = $np;
                            $ADDcorte->cliente = $client;
                            $ADDcorte->rev = $corte->rev;
                            $ADDcorte->wo = $wo;
                            $ADDcorte->cons = $corte->cons;
                            $ADDcorte->color = $corte->color;
                            $ADDcorte->tipo = $corte->tipo;
                            $ADDcorte->aws = $corte->aws;
                            if (substr($corte->cons, 0, 5) == 'CORTE') {
                                $ADDcorte->codigo = substr($wo, 2).'C'.substr($corte->cons, 7);
                            } else {
                                $ADDcorte->codigo = substr($wo, 2).$corte->cons;
                            }
                            $ADDcorte->term1 = $corte->terminal1;
                            $ADDcorte->term2 = $corte->terminal2;
                            $ADDcorte->dataFrom = $corte->dataFrom;
                            $ADDcorte->dataTo = $corte->dataTo;
                            $ADDcorte->qty = $qty;
                            $ADDcorte->tamano = $corte->tamano;
                            $ADDcorte->conector = $corte->conector;
                            $ADDcorte->save();
                        }
                    }
                    $agegartiempos = new timesHarn;
                    $agegartiempos->pn = $np;
                    $agegartiempos->wo = $wo;
                    $agegartiempos->cut = $today;
                    if (substr($rev, 0, 4) == 'PPAP' || substr($rev, 0, 4) == 'PRIM') {
                        $agegartiempos->bar = (substr($np, 0, 2).substr($client, 0, 2).$qty.substr($wo, 1, 5).substr($po, 2, 4).'R'.substr($rev, 5));
                    } else {
                        $agegartiempos->bar = (substr($np, 0, 2).substr($client, 0, 2).$qty.substr($wo, 1, 5).substr($po, 2, 4).'R'.$rev);
                    }
                    $agegartiempos->fecha = $today;
                    $agegartiempos->save();

                    if (substr($rev, 0, 4) == 'PPAP' || substr($rev, 0, 4) == 'PRIM') {
                        $subject = 'ALTA '.substr($rev, 0, 4).' Numero de parte:'.$np.' Rev: '.substr($rev, 5);
                        $date = date('d-m-Y');
                        $time = date('H:i');
                        $content = 'Buen día,'."\n\t\n".'Les comparto que hoy '.$date.' a las '.$time."\n\t\n".' se libero a piso la '.substr($rev, 0, 4)."\n\t\n";
                        $content .= "\n\t\n".' Del cliente: '.$client;
                        $content .= "\n\t\n".' con número de parte: '.$np;
                        $content .= "\n\t\n".' Con Work order: '.$wo;
                        $content .= "\n\t\n".' Esto para seguir con el proceso de producción y revision por parte de ingeniería y calidad.';

                        $recipients = [
                            'jguillen@mx.bergstrominc.com',
                            'jlopez@mx.bergstrominc.com',

                            'jcervera@mx.bergstrominc.com',
                            'jcrodriguez@mx.bergstrominc.com',
                            'dvillalpando@mx.bergstrominc.com',
                            'egaona@mx.bergstrominc.com',
                            'mvaladez@mx.bergstrominc.com',
                            'jolaes@mx.bergstrominc.com',
                            'lramos@mx.bergstrominc.com',
                            'emedina@mx.bergstrominc.com',
                            'jgarrido@mx.bergstrominc.com',

                        ];
                        Mail::to($recipients)->send(new \App\Mail\PPAPING($subject, $content));
                    }
                    $codigo = DB::select("SELECT * FROM registro  WHERE wo='$wo' ORDER BY id DESC LIMIT 1");
                    $codes = $codigo[0]->info;

                    return view('registro/code', ['codes' => $codes, 'cat' => $cat]);
                } else {
                    return redirect()->back()->with('error', 'Error al registrar Wo');
                }
            } else {
                return redirect()->back()->with('error', 'Error al registrar Po');
            }
        }
    }

    public function codeBarPlan(request $request)
    {
        $tiempos = date('d-m-Y H:i');
        $wo = $request->input('wo_scan');
        if ($wo != '') {
            $bucar_wo = DB::table('registro')->where('wo', $wo)->first();
            if (! empty($bucar_wo)) {
                $np = $bucar_wo->NumPart;
                $info = $bucar_wo->info;
                $count = $bucar_wo->count;
                $qty_reg = $bucar_wo->Qty;
                $rev = $bucar_wo->rev;
                if ($count < 2) {
                    $noloom = '';
                    $registrosNoLoom = specialWireModel::where('partNumber', '=', $np)->orderBy('id', 'desc')->first();
                    if (! empty($registrosNoLoom)) {
                        $noloom = $registrosNoLoom->PartNumber;
                    }
                    $panel = ['0031539-4', '0031539-100', '26013301', '0031539-104', '0032192-70', '0032192-175', '0032192-77'];
                    $regcorte = new regPar;
                    $regcorte->pn = $np;
                    $regcorte->wo = $wo;
                    $regcorte->orgQty = $qty_reg;
                    if (substr($rev, 0, 4) == 'PPAP' or substr($rev, 0, 4) == 'PRIM') {
                        if ((($np == $noloom) or in_array($np, $panel))) {
                            $update = DB::table('registro')->where('wo', $wo)->update(['donde' => 'En espera Ingenieria // cables especiales', 'count' => 13]);
                        } else {
                            $update = DB::table('registro')->where('wo', $wo)->update(['donde' => 'En espera de Ingenieria // Corte', 'count' => 17]);
                        }
                        try {
                            workScreduleModel::where('pn', $np)->orderby('id', 'desc')->first()->update(['UpOrderDate' => carbon::now()->format('Y-m-d')]);
                        } catch (\Exception $e) {
                            Log::info($e);
                        }

                        $regcorte->eng = $qty_reg;
                    } else {
                        if ((($np == $noloom) or in_array($np, $panel))) {
                            $update = DB::table('registro')->where('wo', $wo)->update(['donde' => 'En espera de cables especiales', 'count' => 15]);
                            $regcorte->ensaPar = $qty_reg;
                        } else {
                            $update = DB::table('registro')->where('wo', $wo)->update(['donde' => 'En espera de corte', 'count' => 2]);
                            $regcorte->cortPar = $qty_reg;
                        }
                    }
                    $regcorte->codeBar = $info;
                    $regcorte->save();

                    $updateTime = DB::table('tiempos')->where('info', $info)->update(['planeacion' => $tiempos]);

                    return redirect('/planing');
                } else {
                    return redirect('planing')->with('response', 'Record not found');
                }
            } else {
                return redirect('planing')->with('response', 'Record not found');
            }
        } else {
            return redirect('planing')->with('response', 'Record not found');
        }
    }
}

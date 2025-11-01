<?php

namespace App\Http\Controllers;

use App\Models\listaCalidad;
use App\Models\po;
use Illuminate\Http\Request;
use App\Models\Wo;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\AssignOp\Concat;
use App\Models\tiempos;
use App\Models\Corte;
use Illuminate\Mail\Mailables;
use Illuminate\Support\Facades\Mail;

class PoController extends Controller
{

    public function po()
    {

        $value = session('user');
        $cat = session('categoria');

        return view('registro/po', ['value' => $value, 'cat' => $cat]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $client = $request->input('client');
        $np = $request->input('pn');
        $po = $request->input('po');
        $qty = $request->input('qty');
        $rev = $request->input('Rev');
        $desc = $request->input('Description');
        $price = $request->input('Uprice');
        $send = $request->input('Enviar');
        $orday = $request->input('Orday');
        $reqday = $request->input('Reqday');
        $wo = $request->input('WO');
        $count = 1;

        // Check for duplicate entry
        $duplicate = Po::where('po', $po)->exists();

        if ($duplicate) {
            return redirect()->back()->with('error', 'Arnes ya registrado, Revíselo y vuelva a intentarlo');
        }

        $today = date('d-m-Y H:i');

        // Insert data into the Po table
        $poData = new Po();
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

        if ($poData->save()) {

            $newWo = new Wo();
            $newWo->fecha = $today;
            $newWo->NumPart = $np;
            $newWo->cliente = $client;
            $newWo->rev = $rev;
            $newWo->wo = $wo;
            $newWo->po = $po;
            $newWo->Qty = $qty;
            $newWo->Barcode = '0';

            if (substr($rev, 0, 4) == 'PPAP' || substr($rev, 0, 4) == 'PRIM') {
                $newWo->info =  (substr($np, 0, 2) . substr($client, 0, 2) . $qty . substr($wo, 2, 4) . substr($po, 2, 4) . 'R' . substr($rev, 5));
            } else {
                $newWo->info = (substr($np, 0, 2) . substr($client, 0, 2) . $qty . substr($wo, 2, 4) . substr($po, 2, 4) . 'R' . $rev);
            }

            $newWo->donde = 'En espera de proceso';
            $newWo->count = $count;
            $newWo->tiempoTotal = 0;
            $newWo->paro = '';
            $newWo->description = $desc;
            $newWo->price = $price;
            $newWo->sento = $send;
            $newWo->orday = $orday;
            $newWo->reqday = $reqday;

            if ($newWo->save()) {
                $times = new tiempos;
                if (substr($rev, 0, 4) == 'PPAP' || substr($rev, 0, 4) == 'PRIM') {
                    $times->info =  (substr($np, 0, 2) . substr($client, 0, 2) . $qty . substr($wo, 2, 4) . substr($po, 2, 4) . 'R' . substr($rev, 5));
                } else {
                    $times->info = (substr($np, 0, 2) . substr($client, 0, 2) . $qty . substr($wo, 2, 4) . substr($po, 2, 4) . 'R' . $rev);
                }
                $times->planeacion = "";
                $times->corte = "";
                $times->liberacion = "";
                $times->ensamble = "";
                $times->loom = "";
                $times->calidad = "";
                $times->embarque = "";
                $times->kitsinicial = "";
                $times->kitsfinal = "";
                $times->retrabajoi = "";
                $times->retrabajof = "";
                $times->totalparos = "";
                $times->save();

                $Buscarcorte = DB::table('listascorte')->where('pn', '=', $np)->get();
                if ($Buscarcorte->count() > 0) {
                    foreach ($Buscarcorte as $corte) {
                        $ADDcorte = new Corte;
                        $ADDcorte->np = $np;
                        $ADDcorte->cliente = $client;
                        $ADDcorte->wo = $wo;
                        $ADDcorte->cons = $corte->cons;
                        $ADDcorte->color = $corte->color;
                        $ADDcorte->tipo = $corte->tipo;
                        $ADDcorte->aws = $corte->aws;
                        if (substr($corte->cons, 0, 5) == 'CORTE') {
                            $ADDcorte->codigo = substr($wo, 2) . "C" . substr($corte->cons, 7);
                        } else {
                            $ADDcorte->codigo = $wo . $corte->cons;
                        }
                        $ADDcorte->term1 = $corte->terminal1;
                        $ADDcorte->term2 = $corte->terminal2;
                        $ADDcorte->dataFrom = $corte->dataFrom;
                        $ADDcorte->dataTo = $corte->dataTo;
                        $ADDcorte->qty = $qty;
                        $ADDcorte->tamano = $corte->tamano;
                        $ADDcorte->save();
                    }
                }

                if (substr($rev, 0, 4) == 'PPAP' || substr($rev, 0, 4) == 'PRIM') {
                    $subject = 'ALTA ' . substr($rev, 0, 4) . ' Numero de parte:' . $np . ' Rev: ' . substr($rev, 5);
                    $date = date('d-m-Y');
                    $time = date('H:i');
                    $content = 'Buen día,' . "\n\n" . 'Les comparto que hoy ' . $date . ' a las ' . $time . "\n\n" . "se libero a piso la" . substr($rev, 0, 4) . "\n\n";
                    $content .= "\n\n" . " Del cliente: " . $client;
                    $content .= "\n\n" . " con número de parte: " . $np;
                    $content .= "\n\n" . " Con Work order: " . $wo;
                    $content .= "\n\n" . " Esto para seguir con el proceso de producción y revision por parte de ingeniería y calidad.";


                    $recipients = [
                        'jcervera@mx.bergstrominc.com',
                        'jcrodriguez@mx.bergstrominc.com',
                        'vestrada@mx.bergstrominc.com',
                        'david-villa88@outlook.com',
                        'egaona@mx.bergstrominc.com',
                        'mvaladez@mx.bergstrominc.com',
                        'jolaes@mx.bergstrominc.com',
                        'lramos@mx.bergstrominc.com',
                        'emedina@mx.bergstrominc.com',
                        'jgarrido@mx.bergstrominc.com',
                        'jlopez@mx.bergstrominc.com'


                    ];
                    Mail::to($recipients)->send(new \App\Mail\PPAPING($subject, $content));
                }




                return redirect()->route('code');
            } else {
                return redirect()->back()->with('error', 'Error al registrar Wo');
            }
        } else {
            return redirect()->back()->with('error', 'Error al registrar Po');
        }
    }


    public function code(Request $request)
    {
        $codigoant = $request->input('wo');
        if ($codigoant != "") {
            $codigo = DB::select("SELECT * FROM registro  WHERE wo='$codigoant' ORDER BY id DESC LIMIT 1");
            $codes = $codigo[0]->info;
        } else {
            $codigo = DB::select("SELECT * FROM registro  ORDER BY id DESC LIMIT 1");
            $codes = $codigo[0]->info;
        }
        return view('registro/code', ['codes' => $codes]);
    }
    public function label(Request $request)
    {
        $value = session('user');
        $cat = session('categoria');
        $lastlabel = $request->input('wola');
        if ($lastlabel != "") {
        } else {
            $label = DB::select("SELECT * FROM registro  ORDER BY id DESC LIMIT 1");
            $labels = $label[0]->wo;
        }
        return view('registro/label', ['value' => $value, 'labels' => $labels, 'cat' => $cat]);
    }
    public function implabel(Request $request)
    {
        $labelwo = $request->input('wola');
        $labelbeg = $request->input('label1');
        $labelend = $request->input('label2');
        $corte = [];
        $i = 0;
        $bucarCorteLabel = DB::table('corte')->where('wo', $labelwo)->orderBy('id', 'ASC')->get();
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
                $i++;
            }
            return view('registro.implabel', ['corte' => $corte]);
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
                    'labelend' => $labelend
                ]);
            } else {
                $resp = "La Wo no existe";
                return redirect()->back()->with(['resp' => $resp]);
            }
        }
    }
}

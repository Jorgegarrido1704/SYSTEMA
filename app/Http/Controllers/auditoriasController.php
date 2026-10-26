<?php

namespace App\Http\Controllers;

use App\Mail\auditorias\cvts_orders;
use App\Models\personalBergsModel;
use App\Models\regPar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class auditoriasController extends Controller
{
    //
    public function cvts_orders()
    {
        $value = session('user');
        $cat = session('categoria');
        if ($value == '' or $cat == '') {
            return view('login');
        }
        $responsables = personalBergsModel::select('employeeLider')->distinct()->get();

        return view('auditorias.cvts.auditoria_ordenes', ['value' => $value, 'cat' => $cat, 'responsables' => $responsables]);
    }

    public function jsonDatosWo(Request $request)
    {
        $wo = $request->input('wo');
        $data_wo = regPar::where('wo', $wo)->get();

        return json_encode($data_wo);
    }

    public function safeData(Request $request)
    {
        $data = $request->all();

        $status = $data['status'];
        $cuantos = count($status);
        $cuenta = 0;
        $registos = [];
        foreach ($status as $st) {
            if ($st == 'OK') {
                $cuenta++;
            }
        }
        $date = date('Y-m-d');

        $resultados = round(($cuenta / $cuantos) * 100, 2);
        $mail_senders = ['jgarrido@mx.bergstrominc.com', 'jcrodriguez@mx.bergstrominc.com', 'JRuiz@mx.bergstrominc.com',
            'ttuckley@bergstrominc.com', 'hsuarez@mx.bergstrominc.com', 'dmartinez@mx.bergstrominc.com', 'dvillalpando@mx.bergstrominc.com',
            'emedina@mx.bergstrominc.com', 'evillegas@mx.bergstrominc.com', 'fgomez@mx.bergstrominc.com', 'jamoreno@mx.bergstrominc.com',
            'JSanchez@mx.bergstrominc.com', 'jcervera@mx.bergstrominc.com', 'jerodriguez@mx.bergstrominc.com', 'jolaes@mx.bergstrominc.com',
            'lramos@mx.bergstrominc.com', 'mzacarias@mx.bergstrominc.com', 'molivares@mx.bergstrominc.com', 'rsmith@mx.bergstrominc.com',
            'jsoliz@bergstrominc.com', 'egaona@mx.bergstrominc.com',
        ];

        Mail::to($mail_senders)->send(new cvts_orders($data, $resultados, 'Daily CVTS Orders report '.$date));

        return redirect()->back()->with(['success' => 'Reportes Cargados Existosamente ']);
    }
}

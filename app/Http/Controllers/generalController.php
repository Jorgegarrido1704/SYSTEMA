<?php

namespace App\Http\Controllers;

use App\Models\desviation;
use App\Models\errores;
use App\Models\KitsAlmcen;
use App\Models\Maintanance;
use App\Models\material;
use carbon\Carbon;
use App\Models\ParosProd;
use App\Models\regfull;
use App\Models\registo_mant;
use App\Models\registoLogin;
use App\Models\regPar;
use App\Models\regParTime;
use App\Models\specialWireModel;
use App\Models\Wo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class generalController extends Controller
{
    public function general()
    {

        $value = session('user');
        $cat = session('categoria');
        if ($cat == '' or $value == '') {
            return view('login');
        }

        $registros =$previo=$iniciar =[];
        $qry = '';

        if ($cat == 'ensa') {
            $previo = regPar::select('wo', 'pn','preassembly as qty')->where('preassembly', '>', 0)->get();
            $iniciar = regPar::select('wo', 'pn','tobeassembly as qty')->WHERE('tobeassembly', '>', 0)->get();
            $registros = regPar::select('wo', 'pn','ensaPar as qty')->WHERE('ensaPar', '>', 0)->get();
        } elseif ($cat == 'emba') {
            $previo = regPar::select('wo', 'pn','preemba as qty')->WHERE('preemba', '>', 0)->get();
            $iniciar = regPar::select('wo', 'pn','embPar as qty')->WHERE('embPar', '<', 0)->get();
            $registros = regPar::select('wo', 'pn','embPar as qty')->WHERE('embPar', '>', 0)->get();
        } elseif ($cat == 'libe') {
            $previo = regPar::select('wo', 'pn','preterm as qty')->WHERE('preterm', '>', 0)->get();
            $iniciar = regPar::select('wo', 'pn','tobeterm as qty')->WHERE('tobeterm', '>', 0)->get();
            $registros = regPar::select('wo', 'pn','libePar as qty')->WHERE('libePar', '>', 0)->get();
        } elseif ($cat == 'loom') {
            $previo = regPar::select('wo', 'pn','preloom as qty')->WHERE('preloom', '>', 0)->get();
            $iniciar = regPar::select('wo', 'pn','tobeloom as qty')->WHERE('tobeloom', '>', 0)->get();
            $registros = regPar::select('wo', 'pn','loomPar as qty')->WHERE('loomPar', '>', 0)->get();
        } elseif ($cat == 'cort') {
            $previo = regPar::select('wo', 'pn','precut as qty')->WHERE('precut', '>', 0)->get();
            $iniciar = regPar::select('wo', 'pn','tobecut as qty')->WHERE('tobecut', '>', 0)->get();
            $registros = regPar::select('wo', 'pn','cortPar as qty')->WHERE('cortPar', '>', 0)->get();
        }

        $buscarparo = DB::table('registro_paro')->select('fecha', 'equipo', 'nombreEquipo', 'dano', 'atiende', 'id')->where('finHora', '=', '')->where('quien', '=', $value)->get();
        $i = 0;
        $paros = [];
        foreach ($buscarparo as $rowparo) {
            $paros[$i][0] = $rowparo->fecha;
            $paros[$i][1] = $rowparo->equipo;
            $paros[$i][2] = $rowparo->nombreEquipo;
            $paros[$i][3] = $rowparo->dano;
            if ($rowparo->atiende != 'Nadie aun') {
                $paros[$i][4] = 'En Proceso';
            } elseif ($rowparo->atiende == 'Nadie aun') {
                $paros[$i][4] = 'En espera';
            }
            $paros[$i][5] = $rowparo->id;
            $i++;
        }
        $buscardesv = DB::table('desvation')->select('*')->where('quien', '=', $value)->get();
        $i = 0;
        $desviations = [];
        foreach ($buscardesv as $rowdes) {
            $desviations[$i][0] = $rowdes->id;
            $desviations[$i][1] = $rowdes->Mafec;
            $desviations[$i][2] = $rowdes->porg;
            $desviations[$i][3] = $rowdes->psus;
            $desviations[$i][4] = $rowdes->cliente;
            if ($rowdes->fcom == '') {
                $desviations[$i][5] = 'Sin Firmar';
            } else {
                $desviations[$i][5] = 'Firmada';
            }
            if ($rowdes->fing == '') {
                $desviations[$i][6] = 'Sin Firmar';
            } else {
                $desviations[$i][6] = 'Firmada';
            }
            if ($rowdes->fcal == '') {
                $desviations[$i][7] = 'Sin Firmar';
            } else {
                $desviations[$i][7] = 'Firmada';
            }
            if ($rowdes->fpro == '') {
                $desviations[$i][8] = 'Sin Firmar';
            } else {
                $desviations[$i][8] = 'Firmada';
            }
            if ($rowdes->fimm == '') {
                $desviations[$i][9] = 'Sin Firmar';
            } else {
                $desviations[$i][9] = 'Firmada';
            }
            $desviations[$i][10] = $rowdes->fecha;

            $i++;
        }
        $buscarreqM = DB::table('material')->select('*')->where('who', '=', $value)->get();
        $i = 0;
        $materials = [];
        foreach ($buscarreqM as $rowMat) {
            $materials[$i][0] = $rowMat->folio;
            $materials[$i][1] = $rowMat->description;
            $materials[$i][2] = $rowMat->note;
            $materials[$i][3] = $rowMat->qty;
            if ($rowMat->aprovadaComp != '' and $rowMat->negada == '') {
                $materials[$i][4] = 'Aprovada por Compras';
            } elseif ($rowMat->aprovadaComp == '' and $rowMat->negada == '') {
                $materials[$i][4] = 'En espera de respuesta';
            } elseif ($rowMat->aprovadaComp == '' and $rowMat->negada != '') {
                $materials[$i][4] = 'cancelada';
            } elseif ($rowMat->aprovadaComp != '' and $rowMat->negada != '') {
                $materials[$i][4] = 'cancelada';
            }
            $i++;
        }
        $fulls = [];
        $i = 0;
        $buscarfull = DB::table('registrofull')->where('estatus', '!=', 'finalizado')->get();
        foreach ($buscarfull as $full) {
            $fulls[$i][0] = $full->fechaSolicitud;
            $fulls[$i][1] = $full->np;
            $fulls[$i][2] = $full->rev;
            $fulls[$i][3] = $full->cliente;
            $fulls[$i][4] = $full->Cuantos;
            $fulls[$i][5] = $full->estatus;
            $i++;
        }
            return view('general', ['fulls' => $fulls, 'cat' => $cat, 'value' => $value, 'registros' => $registros,
                'paros' => $paros, 'desviations' => $desviations, 'materials' => $materials,
                'previo' => $previo, 'iniciar' => $iniciar]);
        
    }

    public function responseCodigo(request $request)
    {
        $cat = session('categoria');
        $user = session('user');
        if (! $user) {
            return view('login');
        }
        $codigo = $request->input('code-bar');
        $buscarCodigo = regPar::where('codeBar', $codigo)->first();

    }

    public function previos( $wo, $status) {
         $cat = session('categoria');
        $value = session('user');
        if ($cat == '' or $value == '') {  return view('login');   }
        if($status=='accept'){
         if ($cat == 'ensa') {
            regPar::where('wo', $wo)->update(['tobeassembly' => DB::raw('preassembly + tobeassembly'),'preassembly'  => 0]);
        } elseif ($cat == 'emba') {
             regPar::where('wo', $wo)->update(['embPar' => DB::raw('preemba + embPar'),'preemba'  => 0]);
        } elseif ($cat == 'libe') {
            regPar::where('wo', $wo)->update(['tobeterm' => DB::raw('preterm + tobeterm'),'preterm'  => 0]);
        } elseif ($cat == 'loom') {
            regPar::where('wo', $wo)->update(['tobeloom' => DB::raw('preloom + tobeloom'),'preloom'  => 0]);
        } elseif ($cat == 'cort') {
            regPar::where('wo', $wo)->update(['tobecut' => DB::raw('precut + tobecut'),'precut'  => 0]);
        }
         
        }else if($status =='decline'){
         if ($cat == 'ensa') {
             regPar::where('wo', $wo)->update(['libePar' => DB::raw('preassembly + libePar'),'preassembly'  => 0]);
        } elseif ($cat == 'emba') {
            regPar::where('wo', $wo)->update(['testPar' => DB::raw('preemba + testPar'),'preemba'  => 0]);
        } elseif ($cat == 'libe') {
            regPar::where('wo', $wo)->update(['cortPar' => DB::raw('cortPar + preterm'),'preterm'  => 0]);
        } elseif ($cat == 'loom') {
             regPar::where('wo', $wo)->update(['ensaPar' => DB::raw('preloom + ensaPar'),'preloom'  => 0]);
        } elseif ($cat == 'cort') {
             regPar::where('wo', $wo)->update(['planpar' => DB::raw('precut'),'precut'  => 0]);
        }
        }
        $registroTiempo = new regParTime;
                    $registroTiempo->codeBar = $wo;
                    $registroTiempo->qtyPar = 0;
                    $registroTiempo->area = $value.'/'.$cat.'/'.$status;
                    $registroTiempo->fechaReg = carbon::now()->toDateTimeString();
                    $registroTiempo->save();
        return redirect()->back()->with('success', 'Se acceptaron correctamente los previos');

    }
    
    public function iniciar_work (request $request,$wo){
        $cat = session('categoria');
        $value = session('user');
        $qty= $request->input('qty');
        if ($cat == '' or $value == '') {  return view('login');   }
       
         if ($cat == 'ensa') {
            regPar::where('wo', $wo)->update(['ensaPar' => DB::raw('ensaPar + '.$qty),'tobeassembly'  => DB::raw('tobeassembly - '.$qty)]);
         }elseif ($cat == 'libe') {
            regPar::where('wo', $wo)->update(['libePar' => DB::raw('libePar +'.$qty),'tobeterm'  => DB::raw('tobeterm - '.$qty)]);
        } elseif ($cat == 'loom') {
            regPar::where('wo', $wo)->update(['loomPar' => DB::raw('loomPar + '.$qty),'tobeloom'  => DB::raw('tobeloom - '.$qty)]);
        } elseif ($cat == 'cort') {
            regPar::where('wo', $wo)->update(['cortPar' => DB::raw('cortPar + '.$qty),'tobecut'  => DB::raw('tobecut - '.$qty)]);
        }
        $registroTiempo = new regParTime;
                    $registroTiempo->codeBar = $wo;
                    $registroTiempo->qtyPar = $qty;
                    $registroTiempo->area = $value.'/'.$cat.'/para iniciar';
                    $registroTiempo->fechaReg = carbon::now()->toDateTimeString();
                    $registroTiempo->save();

         return redirect()->back()->with('success', 'Se acceptaron correctamente los previos');
    }
    
    public function registrar_work (request $request,$wo){
        $cat = session('categoria');
        $value = session('user');
        if ($cat == '' or $value == '') {  return view('login');   }
        $qty= $request->input('qty');
        

             if ($cat == 'ensa') {
            regPar::where('wo', $wo)->update(['preloom' => DB::raw('preloom + '.$qty),'ensaPar'  => DB::raw('ensaPar - '.$qty)]);
           
        } elseif ($cat == 'emba') {
             regPar::where('wo', $wo)->update(['embPar' => DB::raw(' embPar -'.$qty)]);
        } elseif ($cat == 'libe') {
            regPar::where('wo', $wo)->update(['preassembly' => DB::raw('preassembly +'.$qty),'libePar'  => DB::raw('libePar - '.$qty)]);

        } elseif ($cat == 'loom') {
            regPar::where('wo', $wo)->update(['preCalidad' => DB::raw('preCalidad + '.$qty),'loomPar'  => DB::raw('loomPar - '.$qty)]);
        } elseif ($cat == 'cort') {
            regPar::where('wo', $wo)->update(['preterm' => DB::raw('preterm + '.$qty),'cortPar'  => DB::raw('cortPar - '.$qty)]);
        }
         $cuentas = regPar::where('wo', $wo)->first();
      
         $corte = $cuentas->cortPar+$cuentas->precut+$cuentas->tobecut;
         $libe = $cuentas->libePar+$cuentas->preterm+$cuentas->tobeterm;
         $emb = $cuentas->embPar+$cuentas->preemba;
         $ensa = $cuentas->ensaPar+$cuentas->preloom+$cuentas->tobeloom +$cuentas->specialWire;
         $loom = $cuentas->loomPar+$cuentas->preCalidad+$cuentas->tobeloom;
         $calidad = $cuentas->testPar+$cuentas->fallasCalidad;
         $eng = $cuentas->eng;
          $donde = '';
            $count = 6;
        if(($corte + $libe +  $ensa + $loom + $calidad + $emb) == 0 ){
            $donde = 'Terminado';
            $count = 20;
        }elseif(($corte + $libe +  $ensa + $loom + $calidad  ) == 0 AND $emb > 0){
            $donde = 'En embarque';
            $count = 12;
        }elseif(($corte + $libe +  $ensa + $loom    ) == 0 AND $calidad > 0){
            $donde = 'En Calidad';
            $count = 10;
        }elseif(($corte + $libe +  $ensa) == 0 AND $loom > 0){
            $donde = 'En Loom';
            $count = 8;
        }elseif(($corte + $libe) == 0 AND $ensa > 0){
            $donde = 'En Ensamble';
            $count = 6;
        }else if($corte == 0 AND $libe > 0){
            $donde = 'En Libe';
            $count = 4;
        }else if($corte > 0){
            $donde = 'En Corte';
            $count = 2;
        }
         Wo::where('wo', $wo)->update(['donde'=>$donde,'count'=>$count,]);
      


        $registroTiempo = new regParTime;
                    $registroTiempo->codeBar = $wo;
                    $registroTiempo->qtyPar = $qty;
                    $registroTiempo->area = $value.'/'.$cat.'/ Faniaizado';
                    $registroTiempo->fechaReg = carbon::now()->toDateTimeString();
                    $registroTiempo->save();

         return redirect()->back()->with('success', 'Se acceptaron correctamente los previos');



    }

    public function codigo(request $request)
    {
      
                        $buscarinfo = DB::table('registro_pull')->where('wo', substr($wo, 2))
                            ->orWhere('wo', $wo)->get();
                        if (count($buscarinfo) <= 0) {
                            $subject = 'Urgente se necesita pull test para  NP: '.$pnReg.' con Work Order:'.$wo;
                            $date = date('d-m-Y');
                            $time = date('H:i');
                            $content['inicio'] = 'Buen día, Les comparto que el día '.$date.' a las '.$time;
                            $content['cuerpo'] = 'Salió de liberacion el número de parte: '.$pnReg.' Con Work order: '.$wo;
                            $content['final'] = ' Se solicita de su apoyo para revisar el motivo por el cual no se realizo la prueba de pull';
                            $recipients = [
                                'jcervera@mx.bergstrominc.com',
                                'jcrodriguez@mx.bergstrominc.com',
                                'jguillen@mx.bergstrominc.com',
                                'jolaes@mx.bergstrominc.com',
                                'dvillalpando@mx.bergstrominc.com',
                                'lramos@mx.bergstrominc.com',
                                'emedina@mx.bergstrominc.com',
                                'jgarrido@mx.bergstrominc.com',
                                'jlopez@mx.bergstrominc.com',
                                'scastillo@mx.bergstrominc.com',
                                'rramirez@mx.bergstrominc.com',
                                'drocha@mx.bergstrominc.com',
                            ];
                            Mail::to($recipients)->send(new \App\Mail\pull\pullError($subject, $content));
                        }
                 

            return redirect('general')->with('response', $resp);
        
    }

    public function Bom(Request $request)
    {
        $boms = $request->input('partnum');
        $value = session('user');
        if ($value == 'Brando O') {
            $results = DB::table('datos')
                ->select('item', 'qty')
                ->where('part_num', '=', $boms)
                ->where(function ($query) {
                    $query->where('item', 'LIKE', '%T1-%')
                        ->orWhere('item', 'LIKE', '%T2-%')
                        ->orWhere('item', 'LIKE', '%T3-%')
                        ->orWhere('item', 'LIKE', '%T4-%')
                        ->orWhere('item', 'LIKE', '%T5-%')
                        ->orWhere('item', 'LIKE', '%TA2-%')
                        ->orWhere('item', 'LIKE', '%DA2-%')
                        ->orWhere('item', 'LIKE', '%EA2-%')
                        ->orWhere('item', 'LIKE', '%YA2-%');
                })
                ->get();
        } else {
            $results = DB::table('datos')->select('item', 'qty')->where('part_num', $boms)->get();
        }
        $resps = [];
        foreach ($results as $rest) {
            $resps[] = [$rest->item, $rest->qty];
        }

        $invokeController = new generalController;
        $invokeResult = $invokeController->__invoke();

        // Extract the values from the invoke result
        $value = $invokeResult->getData()['value'];
        $registros = $invokeResult->getData()['registros'];
        $week = $invokeResult->getData()['week'];
        $assit = $invokeResult->getData()['assit'];
        $paros = $invokeResult->getData()['paros'];
        $desviations = $invokeResult->getData()['desviations'];
        $materials = $invokeResult->getData()['materials'];
        $cat = $invokeResult->getData()['cat'];

        // Return the view with the retrieved values
        return view('general', ['cat' => $cat, 'value' => $value, 'registros' => $registros, 'resps' => $resps, 'week' => $week, 'assit' => $assit, 'paros' => $paros, 'desviations' => $desviations, 'materials' => $materials]);
    }

    public function desviation(Request $request)
    {
        $value = session('user');
        $modelo = $request->input('modelo');
        $npo = $request->input('numPartOrg');
        $nps = $request->input('numPartSus');
        $time = $request->input('time');
        $cant = $request->input('cant');
        $text = $request->input('text');
        $evi = $request->input('evi');
        $acc = $request->input('acc');
        $busclient = DB::select("SELECT client FROM precios WHERE pn='$modelo'");
        foreach ($busclient as $row) {
            $cliente = $row->client;
        }
        $user = session('user');
        $today = date('d-m-Y H:i');
        $desv = new desviation;
        if (empty($cliente)) {
            $cliente = '';
        }
        $desv->fill([
            'fecha' => $today,
            'cliente' => $cliente,
            'quien' => $user,
            'Mafec' => $modelo,
            'porg' => $npo,
            'psus' => $nps,
            'peridoDesv' => $time,
            'clsus' => $cant,
            'Causa' => $text,
            'accion' => $acc,
            'evidencia' => $evi,
            'fcal' => '',
            'fcom' => '',
            'fpro' => '',
            'fing' => '',
            'fimm' => '',
            'rechazo' => '',
        ]);

        if ($desv->save()) {
            registoLogin::create(['fecha' => $today, 'userName' => $user, 'action' => 'Registro de desviacion para el modelo '.$modelo]);

            return redirect('/general')->with('success', 'Data successfully saved.');
        } else {
            return redirect('/general')->with('error', 'Failed to save data.');
        }
    }

    public function maintananceGen(Request $request)
    {
        $value = session('user');
        $NomEq = $request->input('nom_equipo');
        $dano = $request->input('dano');
        $area = $request->input('area');
        $quien = $request->input('quien');
        $today = date('d-m-Y H:i');
        $maint = new Maintanance;
        $maint->fill([
            'fecha' => $today,
            'equipo' => 'Mantenimiento',
            'nombreEquipo' => $NomEq,
            'dano' => $dano,
            'quien' => $quien,
            'area' => $area,
            'atiende' => 'Nadie aun',
            'trabajo' => '',
            'Tiempo' => '',
            'inimant' => '',
            'finhora' => '',
        ]);

        if ($maint->save()) {
            $idUlt = registo_mant::select('id')->where('equipo', 'Mantenimiento')->orderBy('id', 'desc')->first();
            $id_f = $idUlt->id ?? 1;
            $hoy = date('Y-m-d');
            $hora = date('H:i');
            $Paro = new registo_mant;
            $Paro->fill([
                'id_maquina' => $NomEq,
                'area' => $area,
                'tipoMant' => '',
                'periMant' => '',
                'descTrab' => '',
                'equipo' => $NomEq,
                'estatus' => '',
                'comentarios' => '',
                'solPor' => $quien,
                'fechReq' => $hoy,
                'id_falla' => $id_f,
            ]);
            if ($Paro->save()) {
                registoLogin::create(['fecha' => $today, 'userName' => $value, 'action' => 'Solicitud de Mantenimiento Registrado ID: '.$maint->id]);

                return redirect('/general')->with('success', 'Data successfully saved.');
            } else {
                return redirect('/general')->with('error', 'Failed to save data.');
            }
        }
    }

    public function material(Request $request)
    {
        $value = session('user');
        $today = date('d-m-Y');

        for ($i = 0; $i < 5; $i++) {
            $cant[$i] = $request->input('cant'.$i);
            $articulo[$i] = $request->input('articulo'.$i);
            $notas[$i] = $request->input('notas_adicionales'.$i);
        }
        $i = 0;
        $foliant = DB::select('SELECT folio FROM material ORDER BY id DESC LIMIT 1 ');
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
                $newarticulo->aprovadaComp = '';
                $newarticulo->negada = '';
                if (! empty($cant[$i])) {
                    $newarticulo->save();
                }
            }
            $i++;
        }
        registoLogin::create(['fecha' => $today, 'userName' => $value, 'action' => 'Registro de Material ID: '.$folio]);

        return redirect('/general');
    }

    public function pause(Request $request)
    {
        $id = $request->input('id_but');
        $funcion = $request->input('funcion');
        $motivo = $request->input('motivo');

        $cat = session('categoria');
        $tiempo = date('d-m-Y H:i');
        $id_Cominezo = $request->input('id_butC');
        if ($motivo == '') {
            $motivo = 'Sin motivo Por '.$cat;
        }
        if (! empty($id_Cominezo)) {
            switch ($cat) {
                case 'cort':
                    $update = DB::table('timesharn')->where('wo', '=', $id_Cominezo)->update(['cut' => $tiempo]);
                    break;
                case 'ensa':
                    $update = DB::table('timesharn')->where('wo', '=', $id_Cominezo)->update(['ensa' => $tiempo]);

                case 'libe':
                    $update = DB::table('timesharn')->where('wo', '=', $id_Cominezo)->update(['term' => $tiempo]);
                    break;
                case 'loom':
                    $update = DB::table('timesharn')->where('wo', '=', $id_Cominezo)->update(['loom' => $tiempo]);
                case 'cali':
                    $update = DB::table('timesharn')->where('wo', '=', $id_Cominezo)->update(['qly' => $tiempo]);
                    break;
                case 'emba':
                    $update = DB::table('timesharn')->where('wo', '=', $id_Cominezo)->update(['emba' => $tiempo]);
                    break;
            }
            $alta = DB::table('registro')->where('wo', '=', $id_Cominezo)->update(['paro' => 'En proceso']);
        }
        if (! empty($id) && $funcion == 'pausar') {
            switch ($cat) {
                case 'cort':
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['cutF' => $tiempo]);
                    $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => $motivo]);
                    $prod = new ParosProd;
                    $prod->fecha = $tiempo;
                    $prod->area = 'Corte';
                    $prod->trabajo = $motivo;
                    $prod->finhora = '';
                    $prod->id_request = $id;
                    $prod->save();
                    break;
                case 'ensa':
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['ensaF' => $tiempo]);
                    $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => $motivo]);
                    $prod = new ParosProd;
                    $prod->fecha = $tiempo;
                    $prod->area = 'Ensamble';
                    $prod->trabajo = $motivo;
                    $prod->finhora = '';
                    $prod->id_request = $id;
                    $prod->save();
                    break;
                case 'libe':
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['termF' => $tiempo]);
                    $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => $motivo]);
                    $prod = new ParosProd;
                    $prod->fecha = $tiempo;
                    $prod->area = 'Liberacion';
                    $prod->trabajo = $motivo;
                    $prod->finhora = '';
                    $prod->id_request = $id;
                    $prod->save();
                    break;
                case 'loom':
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['loomF' => $tiempo]);
                    $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => $motivo]);
                    $prod = new ParosProd;
                    $prod->fecha = $tiempo;
                    $prod->area = 'Loom';
                    $prod->trabajo = $motivo;
                    $prod->finhora = '';
                    $prod->id_request = $id;
                    $prod->save();
                case 'cali':
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['qlyF' => $tiempo]);
                    $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => $motivo]);
                    $prod = new ParosProd;
                    $prod->fecha = $tiempo;
                    $prod->area = 'Calidad';
                    $prod->trabajo = $motivo;
                    $prod->finhora = '';
                    $prod->id_request = $id;
                    $prod->save();
                    break;
                case 'emba':
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['embaF' => $tiempo]);
                    $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => $motivo]);
                    $prod = new ParosProd;
                    $prod->fecha = $tiempo;
                    $prod->area = 'Embarque';
                    $prod->trabajo = $motivo;
                    $prod->finhora = '';
                    $prod->id_request = $id;
                    $prod->save();
                    break;
                default:
                    break;
            }
        } elseif (! empty($id) && $funcion == 'continuar') {
            switch ($cat) {
                case 'cort':
                    $select = DB::table('timesharn')->where('wo', '=', $id)->first();
                    $ini = $select->cut;
                    $fin = $select->cutF;
                    $tiempodiff = strtotime($fin) - strtotime($ini);
                    $newTime = date('d-m-Y h:i', (strtotime($tiempo) - $tiempodiff));
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['cut' => $newTime, 'cutF' => '']);
                    $buscarReg = DB::table('registro')->where('wo', '=', $id)->first();
                    if ($buscarReg) {
                        $registro = DB::table('registro_paro_corte')->where('id_request', '=', $id)->orderBy('id', 'desc')->limit(1)->update(['finhora' => $newTime]);
                        $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => 'En proceso']);
                    }
                    break;
                case 'ensa':
                    $select = DB::table('timesharn')->where('wo', '=', $id)->first();
                    $ini = $select->ensa;
                    $fin = $select->ensaF;
                    $tiempodiff = strtotime($fin) - strtotime($ini);
                    $newTime = date('d-m-Y h:i', (strtotime($tiempo) - $tiempodiff));
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['ensa' => $newTime, 'ensaF' => '']);
                    $buscarReg = DB::table('registro')->where('wo', '=', $id)->first();
                    if ($buscarReg) {
                        $registro = DB::table('registro_paro_corte')->where('id_request', '=', $id)->orderBy('id', 'desc')->limit(1)->update(['finhora' => $newTime]);
                        $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => 'En proceso']);
                    }
                    break;
                case 'libe':
                    $select = DB::table('timesharn')->where('wo', '=', $id)->first();
                    $ini = $select->term;
                    $fin = $select->termF;
                    $tiempodiff = strtotime($fin) - strtotime($ini);
                    $newTime = date('d-m-Y h:i', (strtotime($tiempo) - $tiempodiff));
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['term' => $newTime, 'termF' => '']);
                    $buscarReg = DB::table('registro')->where('wo', '=', $id)->first();
                    if ($buscarReg) {
                        $registro = DB::table('registro_paro_corte')->where('id_request', '=', $id)->orderBy('id', 'desc')->limit(1)->update(['finhora' => $newTime]);
                        $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => 'En proceso']);
                    }
                    break;
                case 'loom':
                    $select = DB::table('timesharn')->where('wo', '=', $id)->first();
                    $ini = $select->loom;
                    $fin = $select->loomF;
                    $tiempodiff = strtotime($fin) - strtotime($ini);
                    $newTime = date('d-m-Y h:i', (strtotime($tiempo) - $tiempodiff));
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['loom' => $newTime, 'loomF' => '']);
                    $buscarReg = DB::table('registro')->where('wo', '=', $id)->first();
                    if ($buscarReg) {
                        $registro = DB::table('registro_paro_corte')->where('id_request', '=', $id)->orderBy('id', 'desc')->limit(1)->update(['finhora' => $newTime]);
                        $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => 'En proceso']);
                    }
                case 'cali':
                    $select = DB::table('timesharn')->where('wo', '=', $id)->first();
                    $ini = $select->qly;
                    $fin = $select->qlyF;
                    $tiempodiff = strtotime($fin) - strtotime($ini);
                    $newTime = date('d-m-Y h:i', (strtotime($tiempo) - $tiempodiff));
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['qly' => $newTime, 'qlyF' => '']);
                    $buscarReg = DB::table('registro')->where('wo', '=', $id)->first();
                    if ($buscarReg) {
                        $registro = DB::table('registro_paro_corte')->where('id_request', '=', $id)->orderBy('id', 'desc')->limit(1)->update(['finhora' => $newTime]);
                        $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => 'En proceso']);
                    }
                    break;
                case 'emba':
                    $select = DB::table('timesharn')->where('wo', '=', $id)->first();
                    $ini = $select->emba;
                    $fin = $select->embaF;
                    $tiempodiff = strtotime($fin) - strtotime($ini);
                    $newTime = date('d-m-Y h:i', (strtotime($tiempo) - $tiempodiff));
                    $update = DB::table('timesharn')->where('wo', '=', $id)->update(['emba' => $newTime, 'embaF' => '']);
                    $buscarReg = DB::table('registro')->where('wo', '=', $id)->first();
                    if ($buscarReg) {
                        $registro = DB::table('registro_paro_corte')->where('id_request', '=', $id)->orderBy('id', 'desc')->limit(1)->update(['finhora' => $newTime]);
                        $alta = DB::table('registro')->where('wo', '=', $id)->update(['paro' => 'En proceso']);
                    }
                    break;
                default:
                    break;
            }

        }

        return redirect('/general');
    }

    public function finishWork(Request $request)
    {
        $id = $request->input('id_but');
        $today = date('d-m-Y H:i');
        $uptimes = DB::table('registro_paro')->where('id', '=', $id)->update(['finhora' => $today, 'trabajo' => 'Finalizado']);
        registoLogin::create(['fecha' => $today, 'userName' => session('user'), 'action' => 'Finalizo el paro ID: '.$id]);

        return redirect('/general');
    }

    public function KitsReq(Request $request)
    {
        $cat = session('categoria');
        $value = session('user');
        $work = $request->input('workO');
        $nivel = $request->input('equipo');
        $time = date('d-m-Y H:i');
        if ($work != '' && $nivel != '') {
            $buscar = DB::table('kitenespera')->where('wo', '=', $work)->first();
            if (! empty($buscar)) {
                $update = DB::table('kitenespera')->where('wo', '=', $work)->update(['QuienSolicita' => $value, 'Area' => 'Ensamble', 'horaSolicitud' => $time, 'nivel' => $nivel]);

                return redirect('/general');
            } else {
                $buscarWOReg = DB::table('registro')->where('wo', '=', $work)->first();
                $np = $buscarWOReg->NumPart;
                $addKit = new KitsAlmcen;
                $addKit->np = $np;
                $addKit->wo = $work;
                $addKit->status = 'En espera';
                $addKit->fechaCreation = 'No Aun';
                $addKit->Quien = 'No Aun';
                $addKit->fechaSalida = 'No Aun';
                $addKit->QuienSolicita = $value;
                $addKit->Area = 'Ensamble';
                $addKit->horaSolicitud = $time;
                $addKit->nivel = $nivel;
                if ($addKit->save()) {
                    registoLogin::create(['fecha' => $time, 'userName' => $value, 'action' => 'Solicitud de kit para el WO: '.$work.' con NP: '.$np]);

                    return redirect('/general');
                }
            }
        }
    }

    public function regfull(Request $request)
    {
        $value = session('user');
        $wo = $request->input('parte');
        $cant = $request->input('cant');
        $buscarDatos = Wo::where('wo', '=', $wo)->first();
        if (! $buscarDatos) {
            return redirect('/general')->with('error', 'No se encontro el WO');
        }
        $pn = $buscarDatos->NumPart;
        $rev = $buscarDatos->rev;
        $client = $buscarDatos->cliente;

        $tablero = 1;
        $time = date('d-m-Y H:i');

        $tablero = strtoupper($tablero);
        $addfull = new regfull;
        $addfull->SolicitadoPor = $value;
        $addfull->fechaSolicitud = $time;
        $addfull->np = $pn;
        $addfull->rev = $rev;
        $addfull->cliente = $client;
        $addfull->Cuantos = $cant;
        $addfull->estatus = 'Pendiente';
        $addfull->fechaColocacion = 'No Aun';
        $addfull->QuienIng = 'No Aun';
        $addfull->fechaMant = 'No Aun';
        $addfull->fechaPiso = 'No Aun';
        $addfull->fechaCalidad = 'No Aun';
        $addfull->tablero = $tablero;
        if ($addfull->save()) {
            registoLogin::create(['fecha' => $time, 'userName' => $value, 'action' => 'Registro de FULLSIZE ID: '.$addfull->id]);

            return redirect('/general');
        }
    }

    public function problemas_general(Request $request)
    {
        $value = session('user');
        $date = date('d-m-Y');
        $pn = $request->input('pnIs');
        $wo = $request->input('workIs');
        $rev = $request->input('revIs');
        $prob = $request->input('probIs');
        $descIs = $request->input('descIs');
        $answer = $request->input('answer');
        $val = $request->input('val');

        $wo = substr($wo, 0, 6);
        $addProb = new errores;
        $addProb->pn = $pn;
        $addProb->wo = $wo;
        $addProb->rev = $rev;
        $addProb->problem = $prob;
        if ($prob == 'Paper work' || $prob == 'Both(Prosses Error and Paper work)') {
            $addProb->mostrar_ing = 1;
        }
        $addProb->descriptionIs = $descIs;
        $addProb->resp = $answer;
        $addProb->WhoReg = $value;
        $addProb->DateIs = $date;
        $addProb->validator = $val;
        if ($addProb->save()) {
            registoLogin::create(['fecha' => $date, 'userName' => $value, 'action' => 'Problemas Generales Registrado ID: '.$addProb->id]);

            return redirect('/general');
        }
    }

    public function getBraid(Request $request)
    {
        $value = session('user');
        $cat = session('categoria');
        if ($value == '' or $cat == '') {
            return view('login');
        }
        $braid = $request->input('braid');
        $datos = DB::table('datos')->select('part_num', 'qty')->where('item', $braid)->get();

        return response()->json($datos);
    }
}

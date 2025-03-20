<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\entSalAlamacen;
use App\Models\desviation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class AlmacenController extends Controller
{

    public function __invoke()    {
        $value=session('user');
        $cat=session('categoria');
        if($cat==''){
            return view('login');
        }else{
        $i=0;
        $listas=$kispendientes=[];
        $buscarInfo=DB::table('almacen')->orderBy('id','DESC')->get();
        foreach($buscarInfo as $rowInfo){
            $listas[$i][0]=$rowInfo->fecha;
            $listas[$i][1]=$rowInfo->articulo;
            $listas[$i][2]=$rowInfo->qty;
            $listas[$i][3]=$rowInfo->movimeinto;
            $listas[$i][4]=$rowInfo->wo;
            $i++;
        }
        $buscardesv=DB::table("desvation")->select("*")->where('count','!=',4)->where('count','!=',5)->get();
            $i=0;$desviations=[];
            foreach($buscardesv as $rowdes){
                $desviations[$i][0]=$rowdes->id;
                $desviations[$i][1]=$rowdes->Mafec;
                $desviations[$i][2]=$rowdes->porg;
                $desviations[$i][3]=$rowdes->psus;
                $desviations[$i][4]=$rowdes->cliente;
                if($rowdes->fcom==""){
                    $desviations[$i][5]="Sin Firmar";
                }else{
                    $desviations[$i][5]="Firmada";
                }if($rowdes->fing==""){
                    $desviations[$i][6]="Sin Firmar";
                }else{
                    $desviations[$i][6]="Firmada";
                }if($rowdes->fcal==""){
                    $desviations[$i][7]="Sin Firmar";
                }else{
                    $desviations[$i][7]="Firmada";
                }if($rowdes->fpro==""){
                    $desviations[$i][8]="Sin Firmar";
                }else{
                    $desviations[$i][8]="Firmada";
                }
                if($rowdes->fimm==""){
                    $desviations[$i][9]="Sin Firmar";
                }else{
                    $desviations[$i][9]="Firmada";
                }
                $desviations[$i][10]=$rowdes->fecha;
                $i++;
            }
            $busquedaKits=DB::table('kits')
            ->where('status','!=','Compleated')
            ->get();
            if(count($busquedaKits)>0){
                $i=0;
                foreach($busquedaKits as $rowkits){
                    $kispendientes[$i][0]=$rowkits->id;
                    $kispendientes[$i][1]=$rowkits->numeroParte;
                    $kispendientes[$i][2]=$rowkits->wo;
                    $kispendientes[$i][3]=$rowkits->status;
                    $kispendientes[$i][4]=$rowkits->qty;
                    $i++;
                }
            }

        return view('almacen',['value'=>$value,'listas'=>$listas,'cat'=>$cat,'desviations'=>$desviations,'kispendientes'=>$kispendientes]);}
    }

    public function registroKit(Request $request)    {
        $cat=session('categoria');
        $value = session('user');
        $i = 0;
        $response="";
        $date = date('d-m-Y H:i');
        $codeWo=$request->input('idkit');
        $listas=$diff=$kits=$infoPar=$datosPn=[];
        if(!empty($codeWo)){
            $i=0;
            $buscarInfo=DB::table('kits')
            ->where('kits.id','=',$codeWo)->first();
            if(!empty($buscarInfo)){
                $kitswo=$buscarInfo->wo;
                $kitsqty=$buscarInfo->qty;
                $kitsPn=$buscarInfo->numeroParte;
                $buscarItems=DB::table('creacionkits')->where('wo',"=",$kitswo)->get();
                $buscarTotal = DB::table('datos')
                ->where('part_num', $kitsPn)
                ->get();


                foreach($buscarTotal as $rowTotal){  $diff[$rowTotal->item]=$rowTotal->qty;}
                if(count($buscarItems)>0){ foreach($buscarItems as $rowItems){$infoPar[$rowItems->item]=$rowItems->qty;}

                    foreach($diff as $key=>$valor){
                        $kits[$i][0]=$kitsPn;
                        $kits[$i][1]=$kitswo;
                        $kits[$i][2]=$key;
                        $kits[$i][3]=($valor*$kitsqty)-$infoPar[$key];
                        $i++;

                    }
                 }else{
                    foreach($diff as $key=>$valor){
                        $kits[$i][0]=$kitsPn;
                        $kits[$i][1]=$kitswo;
                        $kits[$i][2]=$key;
                        $kits[$i][3]=($valor*$kitsqty);
                        $i++;
                    }

                 }

        }
            $datosPn[0]=$kitsPn;
            $datosPn[1]=$kitswo;
            $datosPn[2]=$kitsqty;
        return view('almacen.kits',['value'=>$value,'cat'=>$cat,'kits'=>$kits,'datosPn'=>$datosPn]);


    }
}

    public function BomAlm(Request $request){
        $value=session('user');
        $invokeData=new AlmacenController;
        $invokeRes=$invokeData->__invoke();
        $listas=$invokeRes->getData()['listas'];
        $cat=$invokeRes->getData()['cat'];
        $i=0;
        $BomResp=[];
        $Np=$request->input('NpBom');
        $qty=$request->input('qtyBom');

        $buscarBom=DB::table('datos')->where('part_num',$Np)->get();
        foreach($buscarBom as $rowBom){
            $BomResp[$i][0]=$rowBom->item;
            $BomResp[$i][1]=$rowBom->qty*$qty;
            $i++;
        }
        if(!empty($BomResp)){
        return view('almacen',['value'=>$value,'listas'=>$listas,'BomResp'=>$BomResp,'cat'=>$cat]);
        }else{
            return redirect('almacen');
        }
        }

        public function entradas(Request $request){
            $value=session('user');
            $cat=session('categoria');
            $work=$request->input('Work');
            $id_ret=$request->input('id_return');
            $cant=$request->input('cant');
        if($cat==''){
            return view('login');
        }else{
            if($work){
                $table=[];
                $i=0;
            $buscar=DB::table('creacionkits')->where('creacionkits.wo','=',$work)->get();
            foreach($buscar as $bus){
                $table[$i][0]=$bus->pn;
                $table[$i][1]=$bus->wo;
                $table[$i][2]=$bus->item;
                $table[$i][3]=$bus->qty;
                $table[$i][4]=$bus->id;
                $i++;
            }
            if(!empty($table)){
            return view('almacen.retorno')->with(['value'=>$value,'cat'=>$cat,'table'=>$table]);
        }else{
            return redirect('almacen');
        }
    }else if(count($cant)>0){
            for($i=0;$i<count($cant);$i++){
                $buscarCant=DB::table('creacionkits')->where('id','=',$id_ret[$i])->first();
                $cantDiff=$buscarCant->qty-$cant[$i];
                $item=$buscarCant->item;
                $wo=$buscarCant->wo;
                if($cant[$i]>0){

                $buscarItems=DB::table('itemsconsumidos')->where('NumPart','=',$item)->first();
                $donde=$buscarItems->Area;
                $immex=$buscarItems->immex;
                $nacional=$buscarItems->national;
                $bodega=$buscarItems->Bodega;
                if($immex>0 && $nacional==0 && $bodega==0 || $immex>0 && $nacional==0 && $bodega>0 && $donde=='IMMEX' || $immex>0 && $nacional>0 && $bodega==0 && $donde=='IMMEX' || $immex>0 && $nacional>0 && $bodega>0 && $donde=='IMMEX'){
                    $updateItemsCons=DB::table('itemsconsumidos')->where('NumPart','=',$item)->increment('immex',$cant[$i]);
                }else if($immex==0 && $nacional>0 && $bodega==0 || $immex==0 && $nacional>0 && $bodega>0 && $donde=='NACIONAL' || $immex>0 && $nacional>0 && $bodega==0 && $donde=='NACIONAL' || $immex>0 && $nacional>0 && $bodega>0 && $donde=='NACIONAL'){
                    $updateItemsCons=DB::table('itemsconsumidos')->where('NumPart','=',$item)->increment('national',$cant[$i]);
                }else if($immex==0 && $nacional==0 && $bodega>0){
                    $updateItemsCons=DB::table('itemsconsumidos')->where('NumPart','=',$item)->increment('Bodega',$cant[$i]);
                }
                if($cantDiff>0){
              $updatekits=DB::table('creacionkits')->where('id','=',$id_ret[$i])->update(['qty'=>$cantDiff]);
              $updatekitsdenuevo=DB::table('kits')->where('wo','=',$wo)->update(['status'=>'Parcial']);
                $updenuevo=DB::table('kitenespera')->where('wo','=',$wo)->update(['status'=>'Parcial']);
              $movi=new entSalAlamacen();
              $movi->item=$item;
              $movi->Qty=$cant[$i];
              $movi->movimiento='Retorno de kit';
              $movi->usuario=$value;
              $movi->fecha=date("d-m-Y H:i");
              $movi->wo=$wo;
              $movi->save();
            }
             if($cantDiff==0){
                $updatekitsdenuevo=DB::table('kits')->where('wo','=',$wo)->update(['status'=>'Parcial']);
                $updenuevo=DB::table('kitenespera')->where('wo','=',$wo)->update(['status'=>'Parcial']);
                $movi=new entSalAlamacen();
                $movi->item=$item;
                $movi->Qty=$cant[$i];
                $movi->movimiento='Retorno de kit';
                $movi->usuario=$value;
                $movi->fecha=date("d-m-Y H:i");
                $movi->wo=$wo;
                if($movi->save()){
                $delete=DB::table('creacionkits')->where('id','=',$id_ret[$i])->delete();}
            }

            }}
        return redirect('almacen');
    }

        }

        }

        public function concentrado(Request $request){
            $works=$request->input('Works');
            $cant=$request->input('cant');
            $work=explode(",",$works);
            $cants=explode(",",$cant);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $t = 2;
            $headers = [
                'A1' => 'Numero de parte ',
                'B1' => 'Item',
                'C1' => 'Cantidad'

            ];
            foreach ($headers as $cell => $header) {
                $sheet->setCellValue($cell, $header);
            }
            for ($i=0;$i<count($work);$i++){

                $trabajo=DB::table('datos')->where('part_num', '=', $work[$i])->get();
                foreach ($trabajo as $trabajos){
                    $sheet->setCellValue('A' . $t, $work[$i]);
                    $sheet->setCellValue('B' . $t, $trabajos->item);
                    $sheet->setCellValue('C' . $t, $trabajos->qty*$cants[$i]);
                    $t++;
                }}
                $writer = new Xlsx($spreadsheet);

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Explocion de materiales.xlsx"');
                header('Cache-Control: max-age=0');

                $writer->save('php://output');


        }
        public function desviationAlm(Request $request){
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
                $cliente = $row->client;    }
            $user = session('user');
            $today = date('d-m-Y H:i');
            $desv = new desviation();
            if(empty($cliente)){
                $cliente='';
            }
            $desv->fill([
                'fecha'=>$today,
                'cliente'=>$cliente,
                'quien'=>$user,
                'Mafec' => $modelo,
                'porg' => $npo,
                'psus' => $nps,
                'peridoDesv' => $time,
                'clsus' => $cant,
                'Causa' => $text,
                'accion' => $acc,
                'evidencia' => $evi,
                'fcal'=>"",
                'fcom'=>"",
                'fpro'=>"",
                'fing'=>"",
                'fimm'=>"",
                'rechazo'=>"",    ]);

            if ($desv->save()) {
                return redirect('/almacen')->with('success', 'Data successfully saved.');
            } else {
                return redirect('/almacen')->with('error', 'Failed to save data.');
            }
        }

        public function regItem(Request $request){

                // Get the JSON data from the request body
                $data = $request->json()->all();

                $codigo = $data['codigo'];
                $pn = $data['pn'];
                $wo = $data['wo'];

                $items = explode("-", $codigo);
                $registro = $items[1] . "-" . $items[2];

                $buscar = DB::table('datos')
                    ->where('part_num', '=', $pn)
                    ->where('item', '=', $registro)
                    ->get();

                if ($buscar->isNotEmpty()) {
                    return response()->json(['status' => 200, 'message' => 'Item found']);
                } else {
                    return response()->json(['status' => 400, 'message' => 'Item not found']);
                }
            }
            public function qtyItem(Request $request){

                // Get the JSON data from the request body
                $data = $request->json()->all();

                $codigo = $data['codigo'];
                $pn = $data['pn'];
                $wo = $data['wo'];

                $items = explode("-", $codigo);
                $registro = $items[1] . "-" . $items[2];

                $buscar = DB::table('datos')
                    ->where('part_num', '=', $pn)
                    ->where('item', '=', $registro)
                    ->get();

                if ($buscar->isNotEmpty()) {
                    return response()->json(['status' => 200, 'message' => 'Item found']);
                } else {
                    return response()->json(['status' => 400, 'message' => 'Item not found']);
                }
            }

    }

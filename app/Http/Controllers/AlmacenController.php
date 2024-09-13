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
        $listas=[];
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
        return view('almacen',['value'=>$value,'listas'=>$listas,'cat'=>$cat,'desviations'=>$desviations]);}
    }

    public function store(Request $request)    {
        $invoke=new AlmacenController;
        $reqinvoko=$invoke->__invoke();
        $listas=$reqinvoko->getData()['listas'];
        $cat=$reqinvoko->getData()['cat'];
        $value = session('user');
$infoPar = [];

$i = 0;
$response="";
$date = date('d-m-Y H:i');
$codeWo=$request->input('codigo');
$codeWo=str_replace("'", '-', $codeWo);
$woItem=$request->input('woitem');
if(!empty($codeWo)){
    $i=0;
    $buscarInfo=DB::table('registro')->join('kitenespera','registro.wo','=','kitenespera.wo')->where('info','=',$codeWo)->first();
    if(!empty($buscarInfo)){
        $wo=$buscarInfo->wo;
        $buscarItems=DB::table('creacionkits')->where('wo',$wo)->get();
        if(count($buscarItems)>0){
            foreach($buscarItems as $rowItems){


                $buscarEntregados=DB::table('almacen')->where('articulo',$rowItems->item)->where('wo',$wo)->first();
                if(!empty($buscarEntregados)){
                    if(($rowItems->qty-$buscarEntregados->qty)>0){
                    $infoPar[$i][0] = $rowItems->item;
                    $infoPar[$i][1] = $rowItems->qty-$buscarEntregados->qty;
                    $infoPar[$i][2] = $wo;
                    }
                }else{
                    $infoPar[$i][0] = $rowItems->item;
                    $infoPar[$i][1] = $rowItems->qty;
                    $infoPar[$i][2] = $wo;
                    $i++;
                }

        }
      }  return view('almacen', ['cat'=>$cat,'infoPar' => $infoPar, 'value' => $value,'listas'=>$listas]);
    } else {
        return redirect('almacen');
    }
}
if(!empty($woItem)){
    $buscarItems=DB::table('creacionkits')->where('wo',$woItem)->get();
    if(count($buscarItems)>0){
        foreach($buscarItems as $rowItems){
            $item=$rowItems->item;
            $buscarEntregados=DB::table('almacen')->where('articulo','=',$item)->where('wo','=',$woItem)->first();
            if(!empty($buscarEntregados)){
                $diff=$rowItems->qty-$buscarEntregados->qty;
            }else{
                $diff=$rowItems->qty;
            }
            if($diff>0){
                $registro= new Almacen();
                $registro->fecha=$date;
                $registro->articulo=$rowItems->item;
                $registro->qty=$diff;
                $registro->movimeinto='Salida a piso';
                $registro->wo=$woItem;
                $registro->quien=$value;
                $registro->save();}

    }
    if($registro->save()){
        $update= DB::table('kitenespera')->where('wo', $woItem)->update(['Quien' => $value,'fechasalida' => $date]);
        return redirect('almacen');
    }
    }}

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




    }

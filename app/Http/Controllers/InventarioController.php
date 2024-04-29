<?php

namespace App\Http\Controllers;

use App\Models\entSalAlamacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\Kits;



class InventarioController extends Controller
{
public function __invoke()    {
    $value=session('user');
        $cat=session('categoria');
        if($cat==''){
            return view('login');
        }else{
            $moth=date('m');
            $itemOut=$kitsWo=[];
            $i=0;
            $buscaractual=DB::table('movimientosalmacen')->get();
            foreach($buscaractual as $val){
                $itemOut[$i][0]=$val->fecha;
                $itemOut[$i][1]=$val->item;
                $itemOut[$i][2]=$val->Qty;
                $itemOut[$i][3]=$val->movimiento;
                $i++;
            }
            $i=0;
            $buscarkitsWo=DB::table('kits')->get();
            foreach($buscarkitsWo as $kit){
                if($kit->status!='Completo'){
                $kitsWo[$i][0]=$kit->numeroParte;
                $kitsWo[$i][1]=$kit->qty;
                $kitsWo[$i][2]=$kit->wo;
                $kitsWo[$i][3]=$kit->status;
                $kitsWo[$i][4]=$kit->id;
                $i++;}
            }

            return view('inventario',['kitsWo'=>$kitsWo,'value'=>$value,'cat'=>$cat,'itemOut'=>$itemOut]);}
}
public function savedataAlm(Request $request){
    $value = session('user');
    $cat = session('categoria');
    $data = $request->input('set_Data');
    $qty = $request->input('set_Qty');
    $items = [];
    $cant = [];

    if ($data && $qty) {

        $items = explode(',', $data);
        $cant = explode(',', $qty);
        $cant = array_map('strval', $cant);
        $items = array_map('strval', $items);

        if (count($items) > 0 && count($cant) > 0) {
            for ($i = 0; $i < count($items); $i++) {
                $items[$i] = str_replace(['[', ']', '"'], '', $items[$i]);
                $cant[$i] = str_replace(['[', ']', '"'], '', $cant[$i]);
                $cant[$i] = floatval($cant[$i]);
                if($items[$i]!='NA' and $cant[$i]!=""){
                $nueva = new entSalAlamacen();
                $nueva->item = $items[$i];
                $nueva->Qty = $cant[$i];
                $nueva->movimiento = 'Entrada';
                $nueva->usuario = $value;
                $nueva->fecha = date('d-m-Y H:i');
            $nueva->save();}
        }

        return Redirect::to('inventario')->with('success','Se guardaron los datos exitosamente');
    }else{
        return Redirect::to('/')->with('error','No se guardaron los datos');
    }}
}
    public function Kits(Request $request){
        $value=session('user');
        $categoria=session('categoria');
        $id=$request->input('id');
        $today=strtotime(date('d-m-Y H:i'));
        $kits=[];
        if($id!=""){
            $i=0;
            $busqueda=DB::table('kits')->where('id','=',$id)->first();
            $np=$busqueda->numeroParte;
            $qty=$busqueda->qty;
            $wo=$busqueda->wo;
            $fechaIni=$busqueda->fechaIni;
            $fechaFin=$busqueda->fechaFin;
            if($fechaIni=='No aun'){
               $update=DB::table('kits')->where('id','=',$id)->update(['fechaIni'=>$today,'status'=>'Parcial']);
            }else if($fechaIni!='No aun'){
                $fechaIni=intval($fechaIni);
                $newDate=$today-$fechaIni;
                $update=DB::table('kits')->where('id','=',$id)->update(['fechaFin'=>$newDate]);
            }
            $values=DB::table('datos')->where('part_num','=',$np)->get();
            foreach($values as $val){
                $kits[$i][0]=$np;
                $kits[$i][1]=$wo;
                $kits[$i][2]=$val->item;
                $kits[$i][3]=intval($val->qty)*$qty;
                $i++;
            }

        return view('almacen/kits',['kits'=>$kits,'value'=>$value,'cat'=>$categoria,'id'=>$id,'today'=>$today]);}

    }
}

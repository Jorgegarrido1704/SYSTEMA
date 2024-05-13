<?php

namespace App\Http\Controllers;

use App\Models\entSalAlamacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\creacionKit;
use App\Models\Kits;
use App\Models\KitsAlmcen;
use App\Models\itemsConsumidos;



class InventarioController extends Controller
{
public function __invoke()    {
    $value=session('user');
        $cat=session('categoria');
        if($cat==''){
            return view('login');
        }else{
            $moth=date('m');
            $itemOut=$kitsWo=$rep=[];
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
            $i=0;
        $reporte=DB::table('itemsconsumidos')->get();
        foreach($reporte as $valrep){
            $rep[$i][0]=$valrep->NumPart;
            $rep[$i][1]=$valrep->manofacture;
            $rep[$i][2]=$valrep->parttype;
            $rep[$i][3]=$valrep->immex+$valrep->national+$valrep->Bodega;
            $i++;
        }


            return view('inventario',['rep'=>$rep,'kitsWo'=>$kitsWo,'value'=>$value,'cat'=>$cat,'itemOut'=>$itemOut]);}
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
                    $ExistinIC=DB::table('itemsconsumidos')->where('item', '=', $items[$i])->first();
                    if($ExistinIC){
                        $buscar = DB::table('itemsconsumidos')->where('item', '=', $items[$i])->increment('Qty', $cant[$i]);
                        $nueva = new entSalAlamacen();
                        $nueva->item = $items[$i];
                        $nueva->Qty = $cant[$i];
                        $nueva->movimiento = 'Entrada';
                        $nueva->usuario = $value;
                        $nueva->fecha = date('d-m-Y H:i');
                    $nueva->save();
                    }else{
                        $nuevoItem = new itemsConsumidos();
                        $nuevoItem->item = $items[$i];
                        $nuevoItem->Qty = $cant[$i];
                        if($nuevoItem->save()){
                            $nueva = new entSalAlamacen();
                            $nueva->item = $items[$i];
                            $nueva->Qty = $cant[$i];
                            $nueva->movimiento = 'Entrada';
                            $nueva->usuario = $value;
                            $nueva->fecha = date('d-m-Y H:i');
                            $nueva->save();
                        }

                    }
                }
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

             if($fechaIni!='No Aun' and $fechaFin!='No Aun'){
                $fechaIni=intval($fechaIni)-intval($fechaFin);
                $newDate=$today-$fechaIni;
                $update=DB::table('kits')->where('id','=',$id)->update(['fechaIni'=>$newDate,'fechaFin'=>$today]);
            }else if($fechaIni=='No Aun'){
                $update=DB::table('kits')->where('id','=',$id)->update(['usuario'=>$value,'fechaIni'=>$today,'status'=>'Parcial']);}

            $values=DB::table('datos')->where('part_num','=',$np)->join('itemsconsumidos','itemsconsumidos.NumPart','=','datos.item')->where('itemsconsumidos.kit', '=', 'yes')->get();
            foreach($values as $val){
                $buskit=DB::table('creacionkits')->where('pn','=',$np)->where('item','=',$val->item)->first();
                if($buskit){
                $reduce=(floatval($val->qty)*$qty)-floatval($buskit->qty);
                if($reduce>0){
                $kits[$i][0]=$np;
                $kits[$i][1]=$wo;
                $kits[$i][2]=$val->item;
                $kits[$i][3]=floatval($reduce);
                $i++;}
                }else{
                    $kits[$i][0]=$np;
                    $kits[$i][1]=$wo;
                    $kits[$i][2]=$val->item;
                    $kits[$i][3]=floatval($val->qty)*$qty;
                    $i++;
                }
            }

        return view('almacen/kits',['kits'=>$kits,'value'=>$value,'cat'=>$categoria,'id'=>$id,'today'=>$today]);}

    }
    public function trabajoKits(Request $request){
        $value=session('user');
        $categoria=session('categoria');
        $pn=$request->input('np');
        $wo=$request->input('wo');
        $qty=$request->input('qty');
        $item=$request->input('item');
        $today=(date('d-m-Y H:i'));
        $fin=strtotime(date('d-m-Y H:i'));
        if($pn!="" and $wo!="" and $qty!="" and $item!=""){
            for($i=0;$i<count($item);$i++){
                $buscardatos=DB::table('creacionkits')->where('wo','=',$wo)->where('pn','=',$pn)->where('item','=',$item[$i])->first();
                if($buscardatos){
                    $QtyAnt=$buscardatos->qty;
                    if($qty[$i]>0){
                   $updateDatos=DB::table('creacionkits')->where('wo','=',$wo)->where('pn','=',$pn)->where('item','=',$item[$i])->update(['qty'=>$QtyAnt+$qty[$i]]);
                   $salidaAlmacen= new entSalAlamacen();
                   $salidaAlmacen->item = $item[$i];
                   $salidaAlmacen->Qty = $qty[$i];
                   $salidaAlmacen->movimiento = 'En kits';
                   $salidaAlmacen->usuario = $value;
                   $salidaAlmacen->fecha = $today;
                   if($salidaAlmacen->save()){
                    $buscarInfoInve=DB::table('itemsconsumidos')->where('NumPart','=',$item[$i])->first();
                    if($buscarInfoInve->immex>0){
                       $decremente=DB::table('itemsconsumidos')->where('NumPart','=',$item[$i])->decrement('immex',$qty[$i]);
                    }else if($buscarInfoInve->national>0){
                        $decremente=DB::table('itemsconsumidos')->where('NumPart','=',$item[$i])->decrement('national',$qty[$i]);
                     }else if($buscarInfoInve->Bodega>0){
                        $decremente=DB::table('itemsconsumidos')->where('NumPart','=',$item[$i])->decrement('Bodega',$qty[$i]);
                     }
                   }

                }
                }else{
                    if($qty[$i]>0){
                $nueva = new creacionKit;
                $nueva->fecha = $today;
                $nueva->pn = $pn;
                $nueva->wo = $wo;
                $nueva->item = $item[$i];
                $nueva->qty = $qty[$i];
                $nueva->usuario = $value;
                $nueva->save();
                $salidaAlmacen= new entSalAlamacen();
                $salidaAlmacen->item = $item[$i];
                $salidaAlmacen->Qty = $qty[$i];
                $salidaAlmacen->movimiento = 'En kits';
                $salidaAlmacen->usuario = $value;
                $salidaAlmacen->fecha = $today;
                if($salidaAlmacen->save()){
                    $buscarInfoInve=DB::table('itemsconsumidos')->where('NumPart','=',$item[$i])->first();
                    if($buscarInfoInve->immex>0){
                       $decremente=DB::table('itemsconsumidos')->where('NumPart','=',$item[$i])->decrement('immex',$qty[$i]);
                    }else if($buscarInfoInve->national>0){
                        $decremente=DB::table('itemsconsumidos')->where('NumPart','=',$item[$i])->decrement('national',$qty[$i]);
                     }else if($buscarInfoInve->Bodega>0){
                        $decremente=DB::table('itemsconsumidos')->where('NumPart','=',$item[$i])->decrement('Bodega',$qty[$i]);
                     }
                   }

                    }}
    }if($salidaAlmacen->save()){

        $resultado=0;
        $buscarresulta=DB::table('kits')->where('numeroParte','=',$pn)->where('wo','=',$wo)->first();
        $cantidad=$buscarresulta->qty;
        $buscardatos=DB::table('datos')->where('part_num','=',$pn)->join('itemsconsumidos','itemsconsumidos.NumPart','=','datos.item')->where('itemsconsumidos.kit', '=', 'yes')->get();
        foreach($buscardatos as $rowdatos){
            $item=$rowdatos->item;
            $itemQty=$rowdatos->qty*$cantidad;
            $buscarkits=DB::table('creacionkits')->where('pn','=',$pn)->where('item','=',$item)->first();
            if($buscarkits){
                $diff=$itemQty-$buscarkits->qty;
                $resultado=$resultado+$diff;
            }else if(!$buscarkits){
            $resultado+=1;
            }

        }if($resultado>0){
        $update=DB::table('kits')->where('numeroParte','=',$pn)->where('wo','=',$wo)->update(['fechaFin'=>$fin]);
        $buscarIguales=DB::table('kitenespera')->where('wo','=',$wo)->first();
        if($buscarIguales==null){
            $kitsespera= new KitsAlmcen();
            $kitsespera->np = $pn;
            $kitsespera->wo = $wo;
            $kitsespera->status ="Parcial";
            $kitsespera->fechaCreation = $today;
            $kitsespera->save();
        }
        return Redirect::to('inventario')->with('success','Se guardaron los datos exitosamente');
    }else if($resultado==0){
        $update=DB::table('kits')->where('numeroParte','=',$pn)->where('wo','=',$wo)->update(['status'=>'Completo','fechaFin'=>$fin]);

        $buscarIguales=DB::table('kitenespera')->where('wo','=',$wo)->first();
        if($buscarIguales==null){
            $kitsespera= new KitsAlmcen();
            $kitsespera->np = $pn;
            $kitsespera->wo = $wo;
            $kitsespera->status ="Completo";
            $kitsespera->fechaCreation = $today;
            $kitsespera->save();
        }else{
            $update=DB::table('kitenespera')->where('wo','=',$wo)->where('np','=',$pn)->update(['status'=>'Completo','fechaCreation'=>$today]);
        }
        return Redirect::to('inventario')->with('success','Se guardaron los datos exitosamente');
    }
    }

}else{
    return Redirect::to('inventario');
    //return
}
}

}

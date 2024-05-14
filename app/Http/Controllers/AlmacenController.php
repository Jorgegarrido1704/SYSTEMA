<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return view('almacen',['value'=>$value,'listas'=>$listas,'cat'=>$cat]);}
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
            $buscarEntregados=DB::table('almacen')->where('articulo',$rowItems->item)->where('wo',$woItem)->get();
            if(count($buscarEntregados)>0){
                $registro= new Almacen();
                $registro->fecha=$date;
                $registro->articulo=$rowItems->item;
                $registro->qty=$rowItems->qty-$buscarEntregados->qty;
                $registro->movimeinto='Salida a piso';
                $registro->wo=$woItem;
                $registro->quien=$value;
                $registro->save();
            }else{
                $registro= new Almacen();
                $registro->fecha=$date;
                $registro->articulo=$rowItems->item;
                $registro->qty=$rowItems->qty;
                $registro->movimeinto='Salida a piso';
                $registro->wo=$woItem;
                $registro->quien=$value;
                $registro->save();
            }
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
            $suma=0;
            $item=$request->input('Art');
            $qty=$request->input('qtyArt');
            $buscarItem=DB::table('itemsconsumidos')->where('item',$item)->limit(1)->first();
            if($buscarItem){
                $qtySave=$buscarItem->qty;
                $suma=$qty+$qtySave;
                $updateItemsConsume=DB::table('itemsconsumidos')->where('item',$item)->update(['qty'=>$suma]);
            }


        }

}

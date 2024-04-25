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
$alta = [];
$i = 0;
$response="";
$date = date('d-m-Y H:i');
$regpar = $request->input('codPar');
$altaItem = $request->input('item');
$altaQty = $request->input('cant');
$wo = $request->input('wo');
$codeWo=$request->input('codigo');
        if (!empty($codeWo)) {
            $busqWo = DB::table('registro')->where('info', $codeWo)->first();
            if ($busqWo) {
                $woNum = $busqWo->NumPart;
                $woQty = $busqWo->Qty;
                $wowo=$busqWo->wo;

                $buscarItems = DB::table('datos')->select('item', 'qty')->where('part_num', '=', $woNum)->get();
                foreach ($buscarItems as $rowit) {
                    $saveitem = new Almacen;
                    $saveitem->fecha = $date;
                    $saveitem->articulo = $rowit->item;
                    $saveitem->qty = $rowit->qty * $woQty;
                    $saveitem->movimeinto = "Salida de mercancia(Kit Completo)";
                    $saveitem->wo = $wowo;
                    $saveitem->quien = $value;
                    $saveitem->save();
                }
                $response = "Se Registró correctamente";
            } else {
                $response = "No se encontró ningún registro para el código WO proporcionado";
            }
            return redirect('almacen')->with('response', $response);
        }
if (!empty($altaQty)) {
    foreach ($altaQty as $index => $qty) {
        if($altaQty[$index]>0){
        $updaQty=DB::table('almacen')->select('qty')->where('wo',$wo)->where('articulo', $altaItem[$index])->first();
        if($updaQty){
            $cantidad=$updaQty->qty+$qty;
            $updatableAlm=DB::table('almacen')->where('wo',$wo)->where('articulo', $altaItem[$index])->update(['qty'=>$cantidad]);
        }else{
        $saveitem = new Almacen;
        $saveitem->fecha = $date;
        $saveitem->articulo = $altaItem[$index];
        $saveitem->qty = $qty;
        $saveitem->movimeinto = "Salida de mercancia(Kit Parcial)";
        $saveitem->wo = $wo;
        $saveitem->quien = $value;
        $saveitem->save();
        }}
    }
    return redirect('almacen');
}

if (!empty($regpar)) {

    $mostrarWo = DB::table('registro')->select('NumPart', 'Qty', 'wo')->where('info', $regpar)->first();
    if ($mostrarWo) {
        $NumWo = $mostrarWo->NumPart;
        $NumWoQty = $mostrarWo->Qty;
        $word=$mostrarWo->wo;
        $infos = DB::table('datos')->where('part_num', $NumWo)->get();
        foreach ($infos as $rowInf) {
            $buscarAlmacen=DB::table('almacen')->select('qty')->where('articulo',$rowInf->item)->first();
            if($buscarAlmacen){
                    if((($rowInf->qty * $NumWoQty)-$buscarAlmacen->qty)>0){
                $infoPar[$i][0] = $rowInf->item;
                $infoPar[$i][1] = ($rowInf->qty * $NumWoQty)-$buscarAlmacen->qty;}
            }else{
                $infoPar[$i][0] = $rowInf->item;
            $infoPar[$i][1] = $rowInf->qty * $NumWoQty;}
            $i++;
        }
        return view('almacen', ['cat'=>$cat,'infoPar' => $infoPar, 'value' => $value, 'regpar' => $regpar,'listas'=>$listas]);
    } else {
        // Handle case where no record is found for the given 'wo'
        return redirect()->back()->with('error', 'No record found for the provided WO.');
    }
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

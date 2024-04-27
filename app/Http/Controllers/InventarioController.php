<?php

namespace App\Http\Controllers;

use App\Models\entSalAlamacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;



class InventarioController extends Controller
{
public function __invoke()    {
    $value=session('user');
        $cat=session('categoria');
        if($cat==''){
            return view('login');
        }else{

            return view('inventario',['value'=>$value,'cat'=>$cat]);}
}
public function savedataAlm(Request $request){
$value=session('user');
$cat=session('categoria');
$data = $request-> input('set_Data');
$qty = $request->input('set_Qty');
$items=[];
$cant=[];
if($data){
    $itmes[]= explode(',', $data);
    $cant[]= explode(',', $qty);
}
    if(count($itmes)>0){
        return Redirect::to('inventario')->with('success','Se guardaron los datos exitosamente');
    }else{
        return Redirect::to('/')->with('error','No se guardaron los datos');
    }



}
}

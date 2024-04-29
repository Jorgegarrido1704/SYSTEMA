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
                $nueva = new entSalAlamacen();
                $nueva->item = $items[$i];
                $nueva->Qty = $cant[$i];
                $nueva->movimiento = 'Entrada';
                $nueva->usuario = $value;
                $nueva->fecha = date('d-m-Y H:i');

            $nueva->save();
        }

        return Redirect::to('inventario')->with('success','Se guardaron los datos exitosamente');
    }else{
        return Redirect::to('/')->with('error','No se guardaron los datos');
    }

}

}

}

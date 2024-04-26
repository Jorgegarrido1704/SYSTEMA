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
$file = $request->input('fileInput');
$items = [];
$qtys = [];



return Redirect::to('/inventario');

}

}

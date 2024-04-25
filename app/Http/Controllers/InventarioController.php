<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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



}


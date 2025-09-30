<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventariosController extends Controller
{
    //
    public function index_inventarios()
    {
        $cat=session('categoria');
        $value=session('user');
        if( $value=="" or $cat!="inventario" ){
            return redirect('/');
        }

        return view('inventarios.RecopilacionDeInventario'
        , ['value' => session('user'), 'cat' => session('categoria')]);
    }
}

<?php

namespace App\Http\Controllers;

class corteController extends Controller
{
    //
    public function indexCorte()
    {
        $cat = session('categoria');
        $value = session('user');

        return view('corte.terminales', ['value' => $value, 'cat' => $cat]);
    }
}

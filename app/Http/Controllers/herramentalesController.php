<?php

namespace App\Http\Controllers;

class herramentalesController extends Controller
{
    //
    public function index()
    {
        $value = session('user');
        $cat = session('categoria');
        if ($value != 'Admin' or $cat == 'herramentales') {
            return redirect('/login');
        }

        return view('herramentales.index');
    }
}

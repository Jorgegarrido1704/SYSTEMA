<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mantainenceController extends Controller
{
    public function index()
    {
        $cat = session('categoria')?? '';
        $value = session('user')?? '';
        return view('mantainence.qrs', compact('cat'));
    }
}

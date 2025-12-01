<?php

namespace App\Http\Controllers;

class mantainenceController extends Controller
{
    public function index()
    {
        $cat = session('categoria') ?? '';
        $value = session('user') ?? '';

        return view('mantainence.qrs', ['cat' => $cat, 'value' => $value]);
    }
}

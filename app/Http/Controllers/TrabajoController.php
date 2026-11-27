<?php

namespace App\Http\Controllers;

use App\Models\Trabajo;

class TrabajoController extends Controller
{
    //
    public function show(Trabajo $trabajo)
    {
        $trabajo->load('pasos.plantilla');

        return view('trabajos.show', compact('trabajo'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Trabajo;
use Illuminate\Support\Facades\Storage;

class TrabajoController extends Controller
{
    public function index()
    {
        $trabajos = Trabajo::withCount('pasos')->latest()->paginate(20);

        return view('trabajos.index', compact('trabajos'));
    }

    public function show(Trabajo $trabajo)
    {
        $trabajo->load('pasos.plantilla');

        return view('trabajos.show', compact('trabajo'));
    }

    public function descargar(Trabajo $trabajo)
    {
        abort_unless(
            $trabajo->excel_path && Storage::disk('public')->exists($trabajo->excel_path),
            404,
            'El Excel aún no se ha generado.'
        );

        return Storage::disk('public')->download($trabajo->excel_path);
    }
}
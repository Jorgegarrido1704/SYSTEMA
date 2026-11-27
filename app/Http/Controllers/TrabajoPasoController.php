<?php

namespace App\Http\Controllers;

use App\Models\Trabajo;
use App\Models\TrabajoPaso;
use App\Services\ExcelBuilder;
use Illuminate\Http\Request;
use Storage;

class TrabajoPasoController extends Controller
{
    public function evidencia(Request $request, TrabajoPaso $paso, ExcelBuilder $builder)
    {
        $request->validate(['foto' => 'required|image|max:8192']);

        $paso->update([
            'imagen_prueba' => $request->file('foto')->store("evidencias/{$paso->trabajo_id}", 'public'),
            'completado_at' => now(),
        ]);

        $builder->build($paso->trabajo);   // regenera con la foto real

        return back();
    }

    // TrabajoController
    public function descargar(Trabajo $trabajo)
    {
        return Storage::disk('public')->download($trabajo->excel_path);
    }
}

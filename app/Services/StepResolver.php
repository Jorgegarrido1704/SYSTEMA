<?php

namespace App\Services;

use App\Models\PlantillaPaso;
use App\Models\Trabajo;
use Illuminate\Support\Collection;

class StepResolver
{
    public function resolve(Trabajo $trabajo, string $proceso = 'corte'): Collection
    {
        return PlantillaPaso::where('proceso', $proceso)
            ->where('activo', true)
            ->orderBy('orden')
            ->get()
            ->filter(fn ($paso) => $this->cumple($paso->condicion, $trabajo->datos ?? []))
            ->values();
    }

    private function cumple(?array $condicion, array $datos): bool
    {
        if (empty($condicion)) {
            return true;
        }           // sin condición = siempre aplica

        foreach ($condicion as $campo => $esperado) {
            if (($datos[$campo] ?? null) != $esperado) {
                return false;
            }
        }

        return true;
    }

    /** Crea los registros trabajo_pasos para que el operador suba su evidencia. */
    public function asignar(Trabajo $trabajo): void
    {
        foreach ($this->resolve($trabajo) as $i => $paso) {
            $trabajo->pasos()->firstOrCreate(
                ['plantilla_paso_id' => $paso->id],
                ['orden' => $i + 1]
            );
        }
    }
}

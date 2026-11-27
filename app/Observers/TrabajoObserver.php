<?php

namespace App\Observers;

use App\Jobs\GenerarExcelTrabajo;
use App\Models\Trabajo;

class TrabajoObserver
{
    public function created(Trabajo $trabajo): void
    {
        GenerarExcelTrabajo::dispatch($trabajo);
    }
}

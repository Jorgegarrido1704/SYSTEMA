<?php

namespace App\Jobs;

use App\Models\Trabajo;
use App\Services\ExcelBuilder;
use App\Services\StepResolver;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerarExcelTrabajo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Trabajo $trabajo) {}

    public function handle(StepResolver $resolver, ExcelBuilder $builder): void
    {
        $resolver->asignar($this->trabajo);   // 1. detecta pasos
        $builder->build($this->trabajo);      // 2. genera el Excel
    }
}

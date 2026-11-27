<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trabajo_pasos', function (Blueprint $t) {
            $t->id();
            $t->foreignId('trabajo_id')->constrained()->cascadeOnDelete();
            $t->foreignId('plantilla_paso_id')->constrained('plantilla_pasos');
            $t->unsignedSmallInteger('orden');
            $t->string('imagen_prueba')->nullable();
            $t->timestamp('completado_at')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trabajo_pasos');
    }
};

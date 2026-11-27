<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantilla_pasos', function (Blueprint $t) {
            $t->id();
            $t->string('proceso')->default('corte');
            $t->unsignedSmallInteger('orden');
            $t->string('titulo');
            $t->text('descripcion');
            $t->string('imagen_referencia')->nullable();
            $t->json('condicion')->nullable();
            $t->boolean('activo')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plantilla_pasos');
    }
};

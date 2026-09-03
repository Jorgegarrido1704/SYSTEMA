<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mantenimiento_contras_electricas', function (Blueprint $table) {
            $table->id()->unique()->autoIncrement();
            $table->string('pn')->nullable();
            $table->string('reparacion')->nullable();
            $table->string('estatus')->nullable();
            $table->string('fecha_programada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento_contras_electricas');
    }
};

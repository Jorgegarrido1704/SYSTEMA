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
        Schema::create('eliminacion_accion_correctivas', function (Blueprint $table) {
            $table->id();
            $table->string('folioAccion');
            $table->string('campoEliminado');
            $table->string('motivoEliminacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eliminacion_accion_correctivas');
    }
};

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
        Schema::create('monitoreos_acciones', function (Blueprint $table) {
            $table->id();
            $table->integet('idAccion');
            $table->string('folioAccion');
            $table->string('descripcionSeguimiento')->nullable();
            $table->string('AprobadorSeguimiento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoreos_acciones');
    }
};

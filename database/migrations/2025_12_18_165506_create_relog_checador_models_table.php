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
        Schema::create('relogchecador', function (Blueprint $table) {
            $table->id();
            $table->text('employeeNumer')->default('');
            $table->date('fechaRegistro')->nullable;
            $table->time('entrada')->nullable;
            $table->time('salida')->nullable;
            $table->time('desayunoSalida')->nullable;
            $table->time('desayunoEntrada')->nullable;
            $table->time('comidaSalida')->nullable;
            $table->time('comidaEntrada')->nullable;
            $table->time('permisoSalida')->nullable;
            $table->time('permisoEntrada')->nullable;
            $table->time('permiso2Salida')->nullable;
            $table->time('permiso2Entrada')->nullable;
            $table->time('permiso3Salida')->nullable;
            $table->time('permiso3Entrada')->nullable;
            $table->time('comentario')->nullable;

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relogchecador');
    }
};

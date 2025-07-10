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
        Schema::create('acciones', function (Blueprint $table) {
            $table->id();
            $table->string('folioAccion');
            $table->string('accion')->nullable();
            $table->string('reponsableAccion')->nullable();
            $table->date('fechaInicioAccion')->nullable();
            $table->date('fechaFinAccion')->nullable();
            $table->string('verificadorAccion')->nullable();
            $table->date('ultimoEmail')->nullable();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acciones');
    }
};

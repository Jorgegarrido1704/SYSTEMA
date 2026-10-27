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
        Schema::create('cortes_maquina_cortes', function (Blueprint $table) {
            $table->id();
            $table->integer('M1')->default(0);
            $table->integer('M2')->default(0);
            $table->integer('M3')->default(0);
            $table->integer('M4')->default(0); 
            $table->integer('M5')->default(0);
            $table->integer('M6')->default(0);
            $table->integer('M7')->default(0);
            $table->date('fecha_de_trabajo')->nullable();
            $table->integer('turno')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cortes_maquina_cortes');
    }
};

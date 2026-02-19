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
        Schema::create('mant_golpes_diarios', function (Blueprint $table) {
            $table->id()->autoincrement()->unique();
            $table->string('herramental')->max(10);
            $table->string('terminal')->max(10);
            $table->string('fecha_reg')->max(10);
            $table->integer('golpesDiarios')->default(0);
            $table->integer('golpesTotales')->default(0);
            $table->string('maquina')->max(30);
            $table->integer('totalmant')->default(0);
            $table->string('mantenimiento')->max(10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mant_golpes_diarios');
    }
};

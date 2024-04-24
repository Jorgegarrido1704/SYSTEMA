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
        //
        Schema::create('desvation', function (Blueprint $table) {
            $table->id();
            $table->string('fecha');
            $table->string('cliente')->default("");
            $table->string('quien');
            $table->string('Mafec');
            $table->string('porg');
            $table->string('psus');
            $table->integer('clsus');
            $table->string('peridoDesv');
            $table->string('Causa');
            $table->string('accion');
            $table->string('fcom')->default('');
            $table->string('fing')->default('');
            $table->string('fcal')->default('');
            $table->string('fpro')->default('');
            $table->string('fimm')->default('');
            $table->string('evidencia')->default('');
            $table->integer('count')->default(0);
            $table->string('rechazo')->default('');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

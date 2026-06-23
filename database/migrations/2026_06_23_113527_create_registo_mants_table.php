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
        Schema::create('registo_mant', function (Blueprint $table) {
            $table->id()->unique()->autoIncrement();
            $table->string('id_maquina');
            $table->string('area');
            $table->string('tipoMant');
            $table->string('periMant');
            $table->text('descTrab');
            $table->string('equipo');
            $table->string('estatus')->default('PENDIENTE');
            $table->string('comentarios')->nullable();
            $table->date('fechReq')->currentTimestamp();
            $table->string('fechaProg')->default('NA')->nullable();
            $table->string('fechaEntre')->default('PEND')->nullable();
            $table->string('horaIniServ')->default('PEND')->nullable();
            $table->string('horaFinServ')->default('PEND')->nullable();
            $table->string('ttServ')->nullable();
            $table->string('solPor')->nullable();
            $table->string('SupMant')->default('Javier Cervantes');
            $table->string('tecMant')->nullable();
            $table->string('ValGer')->nullable();
            $table->string('id_falla')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_mant');
    }
};

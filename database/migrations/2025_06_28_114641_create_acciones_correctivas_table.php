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
        Schema::create('acciones_correctivas', function (Blueprint $table) {
            $table->id('id_acciones_correctivas')->autoincrement();
            $table->string('folioAccion');
            $table->date('fechaAccion')->nullable();
            $table->string('Afecta')->nullable();
            $table->string('origenAccion')->nullable();
            $table->string('resposableAccion')->nullable();
            $table->text('descripcionAccion')->nullable();
            $table->date('fechaCompromiso')->nullable();
            $table->string('status')->default('Activa - Etapa 1')->nullable();
            $table->string('asistenciaCausaRaiz')->nullable();
            $table->string('descripcionContencion')->nullable();
            $table->string('porques')->nullable();
            $table->string('Ishikawa')->nullable();
            $table->date('fechaRegistroAcciones')->nullable();
            $table->string('conclusiones')->nullable();
            $table->boolean('IsSistemicProblem')->default(false);
           






        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acciones_correctivas');
    }
};

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
        Schema::create('material_pruebas_electricas', function (Blueprint $table) {
            $table->id();
            $table->string('pn');
            $table->string('rev');
            $table->string('customer');
            $table->string('priority')->default('');
            $table->string('connector')->default('N/A');
            $table->integer('connectorQty')->default(0);
            $table->string('terminal')->default('N/A');
            $table->integer('terminalQty')->default(0);
            $table->date('dateRecepcion')->default(now());
            $table->date('deliveryDate')->nullable();
            $table->string('status')->default('Pendiente');
            $table->string('po')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('materialAtLaredo')->nullable();
            $table->string('eta_bea')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_pruebas_electricas');
    }
};

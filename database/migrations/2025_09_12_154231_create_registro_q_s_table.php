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
        Schema::create('registro_q_s', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->date('fecha');
            $table->string('userReg')->max(50);
            $table->string('presentacion')->max(50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_q_s');
    }
};

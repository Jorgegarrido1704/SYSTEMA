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
        Schema::create('assistence',function (Blueprint $table){
            $table->id();
            $table->string('week')->default('');
            $table->string('lider')->default('');
            $table->string('name')->default('');
            $table->string('lunes')->default(null);
            $table->string('martes')->default(null);
            $table->string('miercoles')->default(null);
            $table->string('jueves')->default(null);
            $table->string('viernes')->default(null);
            $table->string('sabado')->default(null);
            $table->string('domingo')->default(null);
            $table->string('bonoAsistencia')->default(null);
            $table->string('bonoPuntualidad')->default(null);
            $table->integer('extras')->default(0);

        });
    }

    public function down(): void
    {

    }
};

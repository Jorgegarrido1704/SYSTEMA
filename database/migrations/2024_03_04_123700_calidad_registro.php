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
        Schema::create('regsitrocalidad', function(Blueprint $table){
            $table->id();
            $table->integer('fecha');
            $table->string('client');
            $table->string('pn');
            $table->string('info');
            $table->integer('resto');
            $table->string('codigo');
            $table->string('prueba')->nullable();
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

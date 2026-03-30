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
        Schema::table('regsitrocalidad', function (Blueprint $table) {
            $table->id()->unique()->autoIncrement();
            $table->string('fecha', 20);
            $table->string('client', 50);
            $table->string('pn', 40);
            $table->string('info', 30);
            $table->integer('resto')->default(1);
            $table->string('codigo', 80);
            $table->string('prueba', 80)->nullable();
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

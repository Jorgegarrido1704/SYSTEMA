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
        Schema::create('precios', function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->string('client', 50);
            $table->string('pn', 25);
            $table->string('desc', 225);
            $table->string('rev', 7);
            $table->decimal('price', 10, 2);
            $table->string('send', 255)->default('-');
            $table->date('dateUpdate', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precios');
    }
};

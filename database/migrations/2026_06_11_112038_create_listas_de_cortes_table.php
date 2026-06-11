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
        Schema::create('listascorte', function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->string('pn');
            $table->string('rev')->default('-')->nullable();
            $table->string('cons');
            $table->string('tipo')->nullable();
             $table->string('aws')->nullable();
            $table->decimal('tamano')->default(0);
            $table->string('strip1')->nullable();
            $table->string('terminal1')->nullable();
            $table->string('app1')->nullable();
            $table->string('strip2')->nullable();
            $table->string('terminal2')->nullable();
            $table->string('app2')->nullable();
            $table->string('conector')->nullable();
            $table->string('colorTinta')->nullable();
            $table->string('dataFrom')->nullable();
            $table->string('dataTo')->nullable();
            $table->decimal('defaultTime')->default(2.92)->nullable();
            $table->date('last_updated')->currentTimestamp();
           

        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listas_de_cortes');
    }
};

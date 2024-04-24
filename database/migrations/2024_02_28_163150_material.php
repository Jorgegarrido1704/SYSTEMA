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
        Schema::create('material', function(Blueprint $table){
            $table->id();
            $table->integer('folio');
            $table->string('fecha')->nullable();
            $table->string('who')->nullable();
            $table->string('description')->nullable();
            $table->string('note')->nullable();
            $table->integer('qty');
            $table->string('aprovadaComp')->nullable();
            $table->string('negada')->nullable();
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

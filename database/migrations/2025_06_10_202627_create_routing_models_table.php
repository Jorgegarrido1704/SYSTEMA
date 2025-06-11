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
        Schema::create('routing_models', function (Blueprint $table) {
        $table->integer('id_routing')->primary_key()->autoincrement(); // or integer if it's numeric
        $table->string('pn_routing')->max(50);           // part number
        $table->string('work_routing');         // name or type of work
        $table->string('posible_stations');     // station codes or names
        $table->text('work_description')->nullable(); // optional description
        $table->integer('QtyTimes')->default(1);     // quantity
        $table->integer('setUp_routing')->default(5);   // setup or teardown
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routing_models');
    }
};

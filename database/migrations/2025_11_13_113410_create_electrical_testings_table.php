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
        Schema::create('electricalTesting', function (Blueprint $table) {
            $table->id()->primary_key()->autoIncrement()->unique()->nullable(false);
            $table->string('pn')->nullable(false);
            $table->string('wo')->nullable(false);
            $table->string('client')->nullable(false);
            $table->string('requested_by')->nullable(false);
            $table->string('status_of_order')->nullable(false);
             $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electrical_testings');
    }
};

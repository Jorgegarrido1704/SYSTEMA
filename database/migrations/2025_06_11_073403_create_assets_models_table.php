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
        Schema::create('assets_models', function (Blueprint $table) {
           $table->id("id_asset")->primary_key()->autoIncrement();
           $table->string("numberProccess");
           $table->string("descriptionProccess");
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets_models');
    }
};

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
        Schema::table('fallascalidad', function (Blueprint $table) {
            // add columns

            $table->string('wo')->max(10);
            $table->text('porqueCalidad')->nullable();
            $table->text('responsable_produccion')->nullable();
            $table->text('porqueProduccion')->nullable();
            $table->text('accionCorrectiva')->nullable();
            $table->text('status')->default('Open')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
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

<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        schema::create('mant_golpes', function ($table) {
            $table->id()->autoIncrement()->unique();
            $table->string('herramental');
            $table->string('terminal');
            $table->string('fecha_reg');
            $table->integer('golpesDiarios');

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

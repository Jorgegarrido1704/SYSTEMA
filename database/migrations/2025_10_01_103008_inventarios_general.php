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
        Schema::create('inventarioGlobal', function (Blueprint $table) {
            $table->id('id_item')->autoIncrement();
            $table->string('items')->nullable(false);
            $table->string('Register_first_count')->nullable(false);
            $table->decimal('first_qty_count', 10, 2)->nullable(false);
            $table->date('date_first_count')->nullable(false);
            $table->string('Register_second_count')->nullable();
            $table->decimal('second_qty_count', 10, 2)->nullable();
            $table->date('date_second_count')->nullable();
            $table->decimal('difference', 10, 2)->default(0);
            $table->string('id_workOrder')->nullable();
            $table->string('auditor')->nullable();
            $table->string('Folio_sheet_audited')->nullable();
            $table->date('fecha_auditor')->nullable();
            $table->string('status_folio_general')->default('Ok');

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

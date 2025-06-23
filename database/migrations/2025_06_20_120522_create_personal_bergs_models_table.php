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
        Schema::create('personalberg', function (Blueprint $table) {
           $table->id(); // id
            $table->string('employeeNumber')->unique(); // unique employee identifier
            $table->string('employeeName'); // full name
            $table->string('employeeArea'); // area/department
            $table->string('employeeLider'); // leader or supervisor
            $table->date('DateIngreso'); // joining date
            $table->integer('DaysVacationsAvailble')->default(0); // total available vacation days
            $table->integer('lastYear')->default(0); // vacation days carried over from last year
            $table->integer('currentYear')->default(0); // current year vacation days
            $table->integer('nextYear')->default(0); // projected vacation days
            $table->enum('Gender', ['male', 'female', 'other'])->nullable(); // gender
            $table->string('typeWorker'); // worker type (e.g. permanent, temporary)
            $table->string('status')->default('active'); // active, inactive, etc.
            $table->date('DateSalida')->nullable(); // leaving date
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalberg');
    }
};

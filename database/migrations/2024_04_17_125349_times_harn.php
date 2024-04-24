<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
    {
        Schema::create('timesHarn', function (Blueprint $table) {
            $table->id()->primary()->autoIncrement();
            $table->string('pn');
            $table->string('wo');
            $table->string('cut')->nullable();
            $table->string('term')->nullable();
            $table->string('ensa')->nullable();
            $table->string('loom')->nullable();
            $table->string('qly')->nullable();
            $table->string('emba')->nullable();
            $table->string('bar');
            $table->string('fecha');
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

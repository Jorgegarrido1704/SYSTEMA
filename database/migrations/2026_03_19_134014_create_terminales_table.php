<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.accio
     */
    public function up(): void
    {
        Schema::create('terminales', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('terminal', 20)->unique();
            $table->string('externalPartNumero', 25)->unique();
            $table->string('insulationWeight', 15);
            $table->string('insulationHeight', 15);
            $table->string('terminalWeight', 15);
            $table->string('terminalHeight', 15);
            $table->string('pullTest', 25);
            $table->text('substitution')->nullable();
            $table->text('nameImage')->nullable();
            $table->text('infoDownload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminales');
    }
};

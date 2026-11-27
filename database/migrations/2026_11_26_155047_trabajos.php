<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trabajos', function (Blueprint $t) {
            $t->id();
            $t->string('job')->unique();
            $t->string('no_parte');
            $t->string('rev');
            $t->string('cliente');
            $t->string('operador')->nullable();
            $t->json('datos')->nullable();
            $t->string('excel_path')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trabajos');
    }
};

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
        Schema::table('login', function (Blueprint $table) {
            $table->boolean('ventas_module')->default(false);
            $table->boolean('calidad_module')->default(false);
            $table->boolean('produccion_module')->default(false);
            $table->boolean('herramientales_module')->default(false);
            $table->boolean('inventario_module')->default(false);
            $table->boolean('rh_module')->default(false);
            $table->boolean('compras_module')->default(false);
            $table->boolean('mps_module')->default(false);
            $table->boolean('asistencia_module')->default(false);
            $table->boolean('npi_module')->default(false);
            $table->boolean('vacation_module')->default(false);
            $table->boolean('accionesCorrectivas_module')->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('login', function (Blueprint $table) {
            $table->dropColumn([
                'category', 'user_email', 'ventas_module', 'calidad_module',
                'produccion_module', 'herramientales_module', 'inventario_module',
                'rh_module', 'compras_module', 'mps_module', 'asistencia_module',
                'npi_module', 'vacation_module', 'accionesCorrectivas_module',
            ]);
        });
    }
};

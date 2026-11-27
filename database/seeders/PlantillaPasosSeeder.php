<?php

namespace Database\Seeders;

use App\Models\PlantillaPaso;
use Illuminate\Database\Seeder;

class PlantillaPasosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasos = [
            [1, 'Verificar lista de corte', 'Verificar la información de la lista de corte, tomando en cuenta los elementos de cada cable requerido.', null],
            [2, 'Revisar leyenda a imprimir', 'Revisar la leyenda a imprimir en el cable y agregarla en la impresora.', ['tiene_estampado' => true]],
            [3, 'Capturar longitud y configuración', 'Ingresar la longitud del cable y la configuración necesaria en la máquina.', null],
            [4, 'Tomar la primera muestra', 'Tomar la primera muestra.', null],
            [5, 'Validar muestra', 'Validar la longitud, el estampado y las terminales (estas últimas en caso de ser aplicadas).', null],
            [6, 'Liberar y producir', 'Una vez liberada la primera pieza, cortar la cantidad indicada de producción y embobinar al final.', null],
        ];

        foreach ($pasos as [$orden, $titulo, $desc, $cond]) {
            PlantillaPaso::updateOrCreate(
                ['proceso' => 'corte', 'orden' => $orden],
                ['titulo' => $titulo, 'descripcion' => $desc,
                    'imagen_referencia' => "pasos/paso_{$orden}.jpg", 'condicion' => $cond]
            );
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use ZipArchive;

class BackupDatabaseCommand extends Command
{
    protected $signature = 'backup:database';

    protected $description = 'Backup specific tables and generate SQL insert files with zip';

    public function handle(): void
    {
        $date = Carbon::now()->format('d-m-Y');
        $hours = Carbon::now()->format('H');

        $registroTipos = ['Resto', 'corte', 'actividades', 'calidad', 'acciones', 'auditoria', 'embarques', 'inventario', 'mantenimiento', 'po', 'registros', 'routing', 'timeproces', 'tiempos'];
        $outputPath = storage_path('app/respaldos/');

        foreach ($registroTipos as $tipo) {
            $sqlDump = $this->generateSqlDump($tipo);
            $fileName = "{$tipo}.sql";

            $zipName = $hours == '07' || $hours == '20' ? "{$fileName}_{$date}_{$hours}.zip" : "{$fileName}.zip";
            // $zipName = "{$fileName}.zip";
            // Guarda el archivo SQL
            File::ensureDirectoryExists($outputPath);
            File::put($outputPath.$fileName, $sqlDump);

            // Comprimir archivo en zip
            $zip = new ZipArchive;
            if ($zip->open($outputPath.$zipName, ZipArchive::CREATE) === true) {
                $zip->addFile($outputPath.$fileName, $fileName);
                $zip->close();
            } else {
                $this->error("No se pudo crear el archivo ZIP para $fileName");
            }
        }

        $this->info('Backup completado con éxito.');
    }

    private function generateSqlDump(string $registro): string
    {
        $tables_locate = ['corte',  'itemsconsumidos', 'listascorte'];
        $tables_locate2 = ['precios', 'registros', 'registro_paro', 'registro_pull', 'ingactividades'];
        $tabla_calidad = ['regsitrocalidad'];
        $table_accione = ['accidentes', 'acciones', 'acciones_correctivas', 'almacen', 'assets', 'assistence', 'auditoria'];
        $table_auditoria = ['boms', 'calidad', 'clavecali', 'consterm', 'controlalmacen', 'creacionKits', 'croning', 'dashboard', 'desviation'];
        $table_embarques = ['embarque', 'errores', 'fallascalidad', 'faltantes', 'fullsizes', 'herramental', 'impresion', 'mant_golpes_diarios'];
        $table_inv = ['inv', 'inventario', 'inventary_medicine', 'issuesfloor', 'itemsproceso', 'kitenespera', 'kits', 'login', 'mant_golpes'];
        $table_mant = ['mant_herramental', 'material', 'metas', 'monitoreos_acciones', 'movimentsmedicament', 'movimientosalmacen', 'paros', 'parostotal', 'personalberg'];
        $table_po = ['po', 'ppap', 'ppapandprim', 'pulltest', 'registrofull', 'registrokits', 'registroparcial', 'registroparcialtiempo', 'registroqrs', 'registro_mant'];
        $table_qr = ['registro_paro_corte', 'registro_vacaciones', 'reqing', 'respaldos', 'retiradad', 'routing_process', 'salud', 'tiempoman', 'timedead'];
        $table_wa = ['routing_models'];
        $table_wa2 = ['timeprocess'];
        $table_wa3 = ['tiempos', 'timesharn', 'vacaciones', 'weekactivities', 'wks', 'workschedule'];

        $allTables = DB::select('SHOW TABLES');
        $tables = [];
        foreach ($allTables as $table) {
            $tables[] = array_values((array) $table)[0];
        }

        $dump = '';

        foreach ($tables as $table) {
            $include = match ($registro) {
                'Resto' => ! in_array($table, $tables_locate) && ! in_array($table, $tables_locate2) && ! in_array($table, $tabla_calidad)
                    && ! in_array($table, $table_accione) && ! in_array($table, $table_auditoria) && ! in_array($table, $table_embarques)
                    && ! in_array($table, $table_inv) && ! in_array($table, $table_mant) && ! in_array($table, $table_po)
                    && ! in_array($table, $table_qr) && ! in_array($table, $table_wa) && ! in_array($table, $table_wa2)
                    && ! in_array($table, $table_wa3),
                'corte' => in_array($table, $tables_locate),'actividades' => in_array($table, $tables_locate2),'calidad' => in_array($table, $tabla_calidad),
                'acciones' => in_array($table, $table_accione),'auditoria' => in_array($table, $table_auditoria),'embarques' => in_array($table, $table_embarques),
                'inventario' => in_array($table, $table_inv),
                'mantenimiento' => in_array($table, $table_mant),
                'po' => in_array($table, $table_po),
                'registros' => in_array($table, $table_qr),
                'routing' => in_array($table, $table_wa),
                'timeproces' => in_array($table, $table_wa2),
                'tiempos' => in_array($table, $table_wa3),

                default => false,
            };

            if (! $include) {
                continue;
            }

            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    $escaped = addslashes((string) $value);

                    return '"'.str_replace("\n", '\\n', $escaped).'"';
                }, (array) $row);

                $dump .= "INSERT INTO `$table` VALUES (".implode(',', $values).");\n";
            }
            $dump .= "\n";
        }

        return $dump;
    }
}

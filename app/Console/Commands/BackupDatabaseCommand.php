<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use ZipArchive;

class BackupDatabaseCommand extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Backup specific tables and generate SQL insert files with zip';

    public function handle(): void
    {
        $date = Carbon::now()->format('d-m-Y');
        $registroTipos = ['principal', 'reg1', 'reg2', 'reg3'];
        $outputPath = storage_path("app/respaldos/");

        foreach ($registroTipos as $tipo) {
            $sqlDump = $this->generateSqlDump($tipo);
            $fileName = "{$tipo}{$date}.sql";
            $zipName = "{$fileName}.zip";

            // Guarda el archivo SQL
            File::ensureDirectoryExists($outputPath);
            File::put($outputPath . $fileName, $sqlDump);

            // Comprimir archivo en zip
            $zip = new ZipArchive();
            if ($zip->open($outputPath . $zipName, ZipArchive::CREATE) === true) {
                $zip->addFile($outputPath . $fileName, $fileName);
                $zip->close();
            } else {
                $this->error("No se pudo crear el archivo ZIP para $fileName");
            }
        }

        $this->info("Backup completado con éxito.");
    }

    private function generateSqlDump(string $registro): string
    {
        $tables_locate = ['corte', 'datos', 'itemsconsumidos', 'listascorte'];
        $tables_locate2 = ['precios', 'registros', 'registro_paro', 'registro_pull', 'ingactividades'];
        $tabla_calidad = ['regsitrocalidad'];

        $allTables = DB::select('SHOW TABLES');
        $tables = [];
        foreach ($allTables as $table) {
            $tables[] = array_values((array)$table)[0];
        }

        $dump = "";

        foreach ($tables as $table) {
            $include = match ($registro) {
                'principal' => !in_array($table, $tables_locate) && !in_array($table, $tables_locate2) && !in_array($table, $tabla_calidad),
                'reg1' => in_array($table, $tables_locate),
                'reg2' => in_array($table, $tables_locate2),
                'reg3' => in_array($table, $tabla_calidad),
                default => false,
            };

            if (!$include) continue;

            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    $escaped = addslashes((string)$value);
                    return '"' . str_replace("\n", "\\n", $escaped) . '"';
                }, (array)$row);

                $dump .= "INSERT INTO `$table` VALUES (" . implode(',', $values) . ");\n";
            }
            $dump .= "\n";
        }

        return $dump;
    }
}

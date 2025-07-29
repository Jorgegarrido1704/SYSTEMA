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
        $registroTipos = ['principal', 'reg1', 'reg2', 'reg3',
    'reg4' ,'reg5','reg6', 'reg7' , 'reg8' , 'reg9' , 'reg10' , 'reg11' ,
 'reg12' , 'reg13' ];
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
        $table_accione = ['accidentes', 'acciones', 'acciones_correctivas','almacen','assets','assistence','auditoria'];
        $table_auditoria = ['boms','calidad','clavecali','consterm','controlalmacen','creacionKits','croning','dashboard','desviation'];
        $table_embarques = ['embarque','errores','fallascalidad','faltantes','fullsizes','herramental','impresion','mant_golpes_diarios'];
        $table_inv = ['inv','inventario','inventary_medicine','issuesfloor','itemsproceso','kitenespera','kits','login','mant_golpes'];
        $table_mant = ['mant_herramental','material','metas','monitoreos_acciones','movimentsmedicament','movimientosalmacen','paros','parostotal','personalberg'];
        $table_po = ['po','ppap','ppapandprim','pulltest','registrofull','registrokits','registroparcial','registroparcialtiempo','registroqrs','registro_mant',];
        $table_qr = ['registro_paro_corte','registro_vacaciones','reqing','respaldos','retiradad','routing_process','salud','tiempoman','timedead'];
        $table_wa= ['routing_models'];
        $table_wa2= ['timeprocess'];
        $table_wa3= ['tiempos','timesharn','vacaciones','weekactivities','wks','workschedule'];

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
                'reg4' => in_array($table, $table_accione),
                'reg5' => in_array($table, $table_auditoria),
                'reg6' => in_array($table, $table_embarques),
                'reg7' => in_array($table, $table_inv),
                'reg8' => in_array($table, $table_mant),
                'reg9' => in_array($table, $table_po),
                'reg10' => in_array($table, $table_qr),
                'reg11' => in_array($table, $table_wa),
                'reg12' => in_array($table, $table_wa2),
                'reg13' => in_array($table, $table_wa3),


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

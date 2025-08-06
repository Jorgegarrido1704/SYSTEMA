<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workScreduleModel extends Model
{
    use HasFactory;

    protected $table = 'workschedule';

    protected $fillable = [
        'pn',
        'customer',
        'WorkRev',
        'size',
        'FullSize',
        'MRP',
        'receiptDate',
        'commitmentDate',
        'CompletionDate',
        'documentsApproved',
        'Status',
        'resposible',
        'customerDate',
        'comments',
        'UpOrderDate',
        'Color',
        'qtyInPo'
    ];

    public $timestamps = false;

    public static function getWorkSchedule()
    {
        return workScreduleModel::all();
    }


    public static function getDatesWorks($pn,$rev)
    {
        return workScreduleModel::where('pn', $pn)->where('WorkRev', $rev)->first();
    }
    public static function getWorkScheduleStatus()
    {
        return workScreduleModel::where('status', '!=', 'Completed' )->get();
    }
    public static function getWorkScheduleCompleted($year)
{
    $datos = [];

    $registros = workScreduleModel::where('CompletionDate','LIKE', $year.'-07%'  )->where('status', 'Completed')
        ->orderBy('CompletionDate', 'DESC')
        ->get();

    foreach ($registros as $registro) {

        $mes = intval(substr($registro->commitmentDate, 5, 2)); // "01" a "12"

        // Inicializar si no existe
        if (!isset($datos[$mes])) {
            $datos[$mes] = [0, 0]; // [buenos, malos]
        }

        if ($registro->commitmentDate >= $registro->CompletionDate) {
            $datos[$mes][0]++; // buenos
        } else {
            $datos[$mes][1]++; // malos
        }
    }

    return ($datos);
}



}

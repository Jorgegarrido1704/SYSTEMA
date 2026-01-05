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
        'qtyInPo',
    ];

    public $timestamps = false;

    public static function getWorkSchedule()
    {
        return workScreduleModel::all();
    }

    public static function getDatesWorks($pn, $rev)
    {
        return workScreduleModel::where('pn', $pn)->where('WorkRev', $rev)->first();
    }

    public static function getWorkScheduleStatus()
    {
        return workScreduleModel::where('status', '!=', 'Completed')->get();
    }

    public static function getWorkScheduleCompleted($year)
    {
        $datos = [];
        $last13Months = [];
        for ($i = 1; $i < 13; $i++) {
            $month = date('Y-m', strtotime('-'.$i.' month'));
            $last13Months[] = $month;

        }

        foreach ($last13Months as $meses) {
            $mes = explode('-', $meses)[1];
            $datos[$mes] = [0, 0]; // [buenos, malos]
            if ($mes < 10) {
                $mes = '0'.$mes;
            }
            $registros = workScreduleModel::where('CompletionDate', 'LIKE', $meses.'-%')->where('status', 'Completed')
                ->orderBy('CompletionDate', 'DESC')
                ->get();
            $mes = intval($mes);
            foreach ($registros as $registro) {

                if ($registro->commitmentDate >= $registro->CompletionDate) {
                    $datos[$mes][0]++; // buenos
                } else {
                    $datos[$mes][1]++; // malos
                }
            }
        }

        return $datos;
    }
}

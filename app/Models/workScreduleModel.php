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
    public static function getWorkScheduleCompleted($year,$month)
    {
            $datos=[0,0];
        $registros=workScreduleModel::whereYear('commitmentDate', '=', $year)->whereMonth('commitmentDate', '=', $month)->get();
       foreach ($registros as $registro) {
           if ($registro->commitmentDate <= $registro->CompletionDate) {
               $datos[0]++ ;
           }else{
            $datos[1]++;
           }
       }
       return $datos;
    }


}

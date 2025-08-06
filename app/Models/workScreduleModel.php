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
            $datos[]=[0,0];
        $registros=workScreduleModel::whereYear('commitmentDate', '=', $year)->orderby('commitmentDate', 'asc')->get();
       foreach ($registros as $registro) {
            if(key_exists(substr($registro->commitmentDate, 5, 2), $datos)){
           if ($registro->commitmentDate <= $registro->CompletionDate) {
               $datos[substr($registro->commitmentDate, 5, 2)][0]++ ;
           }else{
            $datos[substr($registro->commitmentDate, 5, 2)][1]++;
           }}else{
            if ($registro->commitmentDate <= $registro->CompletionDate) {
                $datos[substr($registro->commitmentDate, 5, 2)][0]=1 ;
            }else{
                $datos[substr($registro->commitmentDate, 5, 2)][1]=1;
            }
           }

       }
       return $datos;
    }


}

<?php

namespace App\Models;

use Carbon\Carbon;
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
        for ($i = 1; $i <= 12; $i++) {
            $datos[$i] = [0, 0]; // [buenos, malos]
        }
        $last12MonthsfirstDay = Carbon::now()->subMonths(12)->startOfMonth()->format('Y-m-d');
        $lastMonthlastDay = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $registros = workScreduleModel::whereBetween('CompletionDate', [$last12MonthsfirstDay, $lastMonthlastDay])->where('status', 'Completed')
            ->orderBy('CompletionDate', 'DESC')
            ->get();

        foreach ($registros as $registro) {
            $mes = (int) date('m', strtotime($registro->CompletionDate));
            if ($registro->commitmentDate >= $registro->CompletionDate) {
                $datos[$mes][0]++; // buenos
            } else {
                $datos[$mes][1]++; // malos
            }
        }
        // dd($last12MonthsfirstDay, $lastMonthlastDay, $registros, $datos);

        return $datos;
    }
}

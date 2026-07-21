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
        'creation_date',
        'material',
        'kit',
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

    public static function getWorkScheduleCompleted($fecha = '2026-06-01')
    {

        $last12MonthsfirstDay = carbon::parse($fecha)->subMonths(12)->startOfMonth()->format('Y-m-d');
        $lastMonthlastDay = carbon::parse($fecha)->endOfMonth()->format('Y-m-d');
        $registros = workScreduleModel::selectRaw('
        SUM(CASE WHEN commitmentDate >= CompletionDate THEN 1 ELSE 0 END) as buenos,
        SUM(CASE WHEN commitmentDate < CompletionDate THEN 1 ELSE 0 END) as malos,     
        MONTH(CompletionDate) as mes,
        YEAR(CompletionDate) as anio')
            ->whereBetween('CompletionDate', [$last12MonthsfirstDay, $lastMonthlastDay])
            ->where('status', 'Completed')
            ->groupBy('anio', 'mes')
            ->orderBy('CompletionDate', 'ASC')
            ->get();
        //   dd($registros);

        return $registros;
    }

    public static function getWorkScheduleCompletedMonthly($fecha = '2026-06-01')
    {

        $incio_mes = Carbon::parse($fecha)->startOfMonth()->format('Y-m-d');
        $fin_mes = Carbon::parse($fecha)->endOfMonth()->format('Y-m-d');

        $registros = workScreduleModel::selectRaw('
        SUM(CASE WHEN commitmentDate >= CompletionDate THEN 1 ELSE 0 END) as buenos,
        SUM(CASE WHEN commitmentDate < CompletionDate THEN 1 ELSE 0 END) as malos,     
        MONTH(CompletionDate) as mes,
        YEAR(CompletionDate) as anio')
            ->whereBetween('CompletionDate', [$incio_mes, $fin_mes])
            ->where('status', 'Completed')
            ->groupBy('anio', 'mes')
            ->orderBy('CompletionDate', 'ASC')
            ->get();
        //   dd($registros);

        return $registros;
    }
}

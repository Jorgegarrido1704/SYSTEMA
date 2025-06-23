<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personalBergsModel extends Model
{
    use HasFactory;
    protected $table = 'personalberg';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $autoIncrement = true;
    public $timestamps = false;
    protected $fillable = [
        'employeeNumber', 'employeeName', 'employeeArea', 'employeeLider',
         'DateIngreso', 'DaysVacationsAvailble', 'lastYear', 'currentYear',
         'nextYear', 'Gender', 'typeWorker', 'status', 'DateSalida'
    ];
    
}

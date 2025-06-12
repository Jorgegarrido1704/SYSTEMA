<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timeproces extends Model
{
    use HasFactory;

    protected $table = 'timeprocess';
    protected $primaryKey = 'id_tp';
    public $incrementing = false;
    public $fillable = [
        'dayHourProcess',
        'process',
        'subProcess',
        'Process_Number',
        'DescriptionProcess',
        'mm',
        'partnum',
        'Operator',
        'obs',
        'laps',
        'registrado'
    ];
    public $timestamps = false;


    public function scopeSearch($query, $search)
    {
        return $query->where('partnum', '=',   $search );
    }
    
}

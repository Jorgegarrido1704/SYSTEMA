<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class desviation extends Model
{
    use HasFactory;
    public $fillable=[
        'fecha',
        'cliente',
        'quien',
        'Mafec',
        'porg',
        'psus',
        'clsus',
        'peridoDesv',
        'Causa',
        'accion',
        'fcom',
        'fing',
        'fcal',
        'fpro',
        'fimm',
        'evidencia',
        'count',
        'rechazo'
    ];
    protected $table = 'desvation'; // Adjust the table name if it's different

    public $timestamps = false; 

}

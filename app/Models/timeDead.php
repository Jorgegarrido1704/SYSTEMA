<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timeDead extends Model
{
    use HasFactory;
    public $fillable = ['id',
    'fecha',
    'cliente',
    'np',
    'codigo',
    'defecto',
    'timeIni',
    'timeFin',
    'Total',
    'whoDet',
    'respArea',
    'area'
];
    protected $table = 'timedead';
    public $timestamps = false;
}

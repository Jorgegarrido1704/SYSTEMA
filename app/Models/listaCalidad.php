<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listaCalidad extends Model
{
    use HasFactory;
    protected $fillable=[
        'np',
        'client',
        'wo',
        'po',
        'info',
        'qty',
        'parcial'
    ];
    protected $table='calidad';

    public $timestamps=false;
}

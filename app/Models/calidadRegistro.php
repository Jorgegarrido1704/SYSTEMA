<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calidadRegistro extends Model
{
    use HasFactory;
    public $fillable=[
        'fecha',
        'client',
        'pn',
        'info',
        'resto',
        'codigo',
        'prueba',
        'Responsable',
    ];
    protected $table='regsitrocalidad';
    public $timestamps=false;
}

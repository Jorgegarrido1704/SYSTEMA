<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relogChecadorModel extends Model
{
    use HasFactory;

    protected $table = 'relogchecador';

    protected $fillable = [
        'fechaRegistro',
        'entrada',
        'salida',
        'desayunoSalida',
        'desayunoEntrada',
        'comidaSalida',
        'comidaEntrada',
        'permisoSalida',
        'permisoEntrada',
        'permiso2Salida',
        'permiso2Entrada',
        'permiso3Salida',
        'permiso3Entrada',
        'comentario',

    ];

    public $timestamps = false;
}

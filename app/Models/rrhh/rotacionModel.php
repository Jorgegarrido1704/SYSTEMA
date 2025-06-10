<?php

namespace App\Models\rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rotacionModel extends Model
{
    use HasFactory;
    protected $connection = 'rrhh';
    protected $table = 'rotacion';
    protected $primaryKey = 'id_rotacion';
    public $timestamps = false;

    protected $fillable = [
        'id_rotacion' ,
        'id_empleado',
        'fecha_rotacion',
        'motivo_rotacion',
        'observaciones',
        'estado'
    ];
    protected $casts = [
        'id_rotacion' => 'string',
        'assistencia' => ['integer', 'max:6'],
        'fecha_rotacion' => 'date',
        'vacaciones' => ['integer', 'max:6'],
        'faltas' => ['integer', 'max:6'],
        'permisos_gose' => ['integer', 'max:6'],
        'permisos_sin_gose' => ['integer', 'max:6'],
        'incapacidad' => ['integer', 'max:6'],
        'estado' => 'string',
        'retardos' => ['integer', 'max:4'],

    ];
    protected $keyType = 'integer';
    public $incrementing = true;
    protected $attributes = [
        'estado' => 'Registrado',
        'assistencia' => 0,
        'vacaciones' => 0,
        'faltas' => 0,
        'permisos_gose' => 0,
        'permisos_sin_gose' => 0,
        'incapacidad' => 0,
        'retardos' => 0

    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}

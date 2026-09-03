<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mantenimiento_contras_electricas extends Model
{
    use HasFactory;

    protected $table = 'mantenimiento_contras_electricas';

    protected $fillable = [
        'pn',
        'reparacion',
        'estatus',
        'fecha_programada',
    ];

    public $timestamps = true;
}

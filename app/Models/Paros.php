<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paros extends Model
{
    use HasFactory;
    public $fillable=[
        'fecha',
        'hora',
        'equipo',
        'nombreEquipo',
        'dano',
        'quien',
        'area',
        'atiende',
        'trabajo',
        'Tiempo',
        'finhora'
    ];
    protected $table='registro_paro_corte';
    public $timestamps = false;
}

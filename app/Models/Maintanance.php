<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintanance extends Model
{
    use HasFactory;

    public $fillable=[
        'fecha',
        'equipo',
        'nombreEquipo',
        'dano',
        'quien',
        'area',
        'atiende',
        'trabajo',
        'Tiempo',
        'inimant',
        'finhora'

    ];
    protected $table='registro_paro';
    public $timestamps=false;
}

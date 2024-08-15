<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paros extends Model
{
    use HasFactory;
    public $fillable=[
        'id_maquina',
        'area',
        'tipoMant',
        'periMant',
        'descTrab',
        'equipo',
        'estatus',
        'comentarios',
        'fechReq',
        'fechaProg',
        'fechaEntre',
        'horaIniServ',
        'horaFinServ',
        'ttServ',
        'solPor',
        'SupMant',
        'tecMant',
        'ValGer',
        'id_falla',

    ];
    protected $table='registro_mant';
    public $timestamps = false;
}

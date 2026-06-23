<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registo_mant extends Model
{
    use HasFactory;

    protected $table = 'registo_mant';

    protected $primaryKey = 'id';

    protected $fillable = [
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
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;
}

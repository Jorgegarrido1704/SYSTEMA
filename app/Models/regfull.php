<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class regfull extends Model
{
    use HasFactory;
    public $fillable = ['SolicitadoPor','fechaSolicitud','np', 'rev', 'cliente', 'Cuantos','estatus','fechaColocacion', 'QuienIng','fechaMant','fechaPiso','fechaCalidad'];
    protected $table = 'registrofull';
    public $timestamps = false;
}

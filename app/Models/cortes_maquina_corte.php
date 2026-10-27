<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cortes_maquina_corte extends Model
{
    use HasFactory;
    protected $table ='cortes_maquina_cortes';
    public $timestamps = true;
    protected $fillable = [
        'M1','M2','M3','M4','M5','M6','M7','fecha_de_trabajo','turno'
    ];

}

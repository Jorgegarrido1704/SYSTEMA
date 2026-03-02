<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eliminacionAccionCorrectiva extends Model
{
    use HasFactory;

    protected $fillable = [
        'folioAccion',
        'campoEliminado',
        'motivoEliminacion',
    ];

    protected $table = 'eliminacion_accion_correctivas';

    public $timestamps = true;
}

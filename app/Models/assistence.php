<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assistence extends Model
{
    use HasFactory;

    public $fillable=
    [
        'week',
        'lider',
        'name',
        'lunes',
        'martes',
        'miercoles',
        'jueves',
        'viernes',
        'sabado',
        'domingo',
        'bonoAsistencia',
        'bonoPuntualidad',
        'extras'
    ];
    protected $table="assistence";
    public $timestamps = false;

}

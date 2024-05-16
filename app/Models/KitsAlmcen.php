<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitsAlmcen extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'np',
        'wo',
        'status',
        'fechaCreation',
        'Quien',
        'fechaSalida',
        'QuienSolicita',
        'Area',
        'horaSolicitud',
        'nivel'
    ];
    protected $table = 'kitenespera';
    public $timestamps = false;
}

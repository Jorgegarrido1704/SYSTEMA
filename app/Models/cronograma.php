<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cronograma extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cliente',
        'pn',
        'rev',
        'fechaReg',
        'fechaCompromiso',
        'fechaCambio',
        'fechaFin',
        'quienReg',
        'quienCamb'
    ];
    protected $table = "croning";

    public $timestamps = false;
}

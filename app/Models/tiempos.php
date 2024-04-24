<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tiempos extends Model
{
    use HasFactory;

    public $fillabe=[
        'info',
        'planeacion',
        'corte',
        'liberacion',
        'ensamble',
        'loom',
        'calidad',
        'embarque',
        'kitsinicial',
        'kitsfinal',
        'retrabajoi',
        'retrabajof',
        'totalparos'

    ];
    protected $table="tiempos";
    public $timestamps=FALSE;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entSalAlamacen extends Model
{
    use HasFactory;
    public $fillable=[
        'item',
        'Qty',
        'movimiento',
        'usuario',
        'fecha',
        'wo',
    ];
    protected $table = "movimientosalmacen";
    public $timestamps = false;
}


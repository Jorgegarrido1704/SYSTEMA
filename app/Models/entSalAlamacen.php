<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entSalAlamacen extends Model
{
    use HasFactory;
    public $fillable=[
        'id',
        'item',
        'Qty',
        'movimiento',
        'usuario',
        'fecha'
    ];
    protected $table = "movimientosalmacen";
    public $timestamps = false;
}

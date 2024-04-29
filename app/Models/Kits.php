<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kits extends Model
{
    use HasFactory;
    public $fillable=[
        'id',
        'numeroParte',
        'qty',
        'wo',
        'status',
        'usuario',
        'fechaIni',
        'fechaFin'
    ];
    protected $table = "kits";
    public $timestamps = false;
}

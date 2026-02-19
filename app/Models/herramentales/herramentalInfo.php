<?php

namespace App\Models\herramentales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class herramentalInfo extends Model
{
    use HasFactory;

    protected $table = 'mant_golpes_diarios';

    protected $fillable = [
        'herramental',
        'terminal',
        'fecha_reg',
        'golpesDiarios',
        'golpesTotales',
        'maquina',
        'totalmant',
        'mantenimiento',
    ];

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = false;
}

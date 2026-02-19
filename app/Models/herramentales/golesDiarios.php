<?php

namespace App\Models\herramentales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class golesDiarios extends Model
{
    use HasFactory;

    protected $table = 'mant_golpes';

    protected $fillable = [
        'herramental',
        'terminal',
        'fecha_reg',
        'golpesDiarios',
    ];

    public $timestamps = false;

    public $casts = [
        'golpesDiarios' => 'integer',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fallasCalidadModel extends Model
{
    use HasFactory;

    protected $fillable = ['idCalidad', 'wo', 'porqueCalidad', 'responsable_produccion', 'porqueProduccion',
        'accionCorrectiva', 'status', 'created_at', 'updated_at'];

    protected $table = 'fallascalidad';

    public $timestamps = true;
}

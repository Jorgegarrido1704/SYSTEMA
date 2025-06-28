<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class accionesCorrectivas extends Model
{
    use HasFactory;
    protected $table = 'acciones_correctivas';
    protected $primaryKey = 'id_acciones_correctivas';
    public $timestamps = false;
    public $autoIncrement = true;
    protected $keyType = 'int';

    protected $fillable = [
        'fechaAccion',
        'Afecta',
        'origenAccion',
        'resposableAccion',
        'descripcionAccion',
        'fechaCompromiso',
        'status',
    ];
    protected $casts = [
        'fechaAccion' => 'datetime',
        'fechaCompromiso' => 'datetime',
    ];

    public function getDateForFinisg($id)
    {
        $accion = accionesCorrectivas::find($id);
        if ($accion) {
           $inicio = $accion->fechaAccion;
           $fin = $accion->fechaCompromiso;
           $diff= carbon::parse($fin)->diffInDays(carbon::parse($inicio));
           return $diff;
        }
        return null;
    }

}

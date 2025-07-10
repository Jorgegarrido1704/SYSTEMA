<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\accionesCorrectivas\acciones;

class accionesCorrectivas extends Model
{
    use HasFactory;
    protected $table = 'acciones_correctivas';
    protected $primaryKey = 'id_acciones_correctivas';
    public $timestamps = false;
    public $autoIncrement = true;
    protected $keyType = 'int';

    protected $fillable = [
        'folioAccion',
        'fechaAccion',
        'Afecta',
        'origenAccion',
        'resposableAccion',
        'descripcionAccion',
        'fechaCompromiso',
        'status',
        'asistenciaCausaRaiz',
        'descripcionContencion',
        'porques',
        'Ishikawa',
        'fechaRegistroAcciones',
        'conclusiones',
        'IsSistemicProblem',
        'accion',
        'responsableAccion',
        'fechaInicioAccion',
        'fechaFinAccion',
        'verificadorAccion',
        'ultimoEmail',

    ];
    protected $casts = [
        'fechaAccion' => 'date',
        'fechaCompromiso' => 'date',
    ];

        public function registroAcciones(){
            return $this->hasMany(acciones::class)->where('folioAccion', $this->folioAccion);
        }



}

<?php

namespace App\Models\accionesCorrectivas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monitoreosAcciones extends Model
{
    use HasFactory;
    protected $table = 'monitoreos_acciones';
    protected $primaryKey = 'idAccion';
    public $timestamps = true;
    protected $fillable = [
        'folioAccion',
        'descripcionSeguimiento',
        'AprobadorSeguimiento',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

   function getBunchAcciones($idAccion){
       return acciones::where('folioAccion', $idAccion)->get();
   }



}

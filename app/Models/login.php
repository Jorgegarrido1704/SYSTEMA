<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class login extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'clave',
        'category',
        'user_email', 'ventas_module', 'calidad_module', 'produccion_module', 'herramientales_module',
        'inventario_module', 'rh_module', 'compras_module', 'mps_module', 'asistencia_module', 'npi_module', 'vacation_module', 'accionesCorrectivas_module',

    ];

    protected $table = 'login';

    public $timestamps = false;
}

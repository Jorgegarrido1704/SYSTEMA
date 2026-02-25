<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sub_acciones_model extends Model
{
    use HasFactory;

    protected $table = 'sub_acciones_models';

    protected $primaryKey = 'id';

    protected $keyType = 'integer';

    protected $autoIncrement = true;

    public $timestamps = true;

    protected $fillable = [
        'folioAccion', 'descripcionSubAccion', 'resposableSubAccion', 'fechaInicioSubAccion', 'fechaFinSubAccion', 'auditorSubAccion',
    ];
}

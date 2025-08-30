<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registroVacacionesModel extends Model
{
    use HasFactory;

    protected $table = 'registro_vacaciones';
    protected $primaryKey = 'id';

    protected $fillable = [ 'id_empleado', 'fecha_de_solicitud', 'estatus', 'dias_solicitados','usedYear','superVisor'  ];
    public $timestamps = false;

    public function scopeRegistros()
    {
        
    }


}

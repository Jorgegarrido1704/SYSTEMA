<?php

namespace App\Models\accionesCorrectivas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\accionesCorrectivas;


class acciones extends Model
{
    use HasFactory;
    protected $table = 'acciones';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;
    protected $fillable = ['folioAccion', 'accion', 'reponsableAccion', 'fecha',
    'fechaInicioAccion', 'fechaFinAccion', 'verificadorAccion', 'ultimoEmail',];

    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['fechaInicioAccion' => 'date', 'fechaFinAccion' => 'date'];

    public function accionesregistradas(){
        return $this->hasMany(accionesCorrectivas::class)->where('folioAccion', $this->folioAccion);
    }


}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assistence extends Model
{
    use HasFactory;

    public $fillable=
    [
        'week', 'lider', 'name', 'lunes', 'extLunes', 'martes', 'extMartes', 'miercoles', 'extMiercoles', 'jueves',
        'extJueves', 'viernes', 'extViernes', 'sabado', 'extSabado', 'domingo', 'extDomingo', 'bonoAsistencia', 'bonoPuntualidad',
         'extras', 'tiempoPorTiempo', 'id_empleado','tt_lunes','tt_martes','tt_miercoles','tt_jueves','tt_viernes','tt_sabado',
         'tt_domingo'
    ];
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $incrementing = true;
    protected $table="assistence";
    public $timestamps = false;
    protected $casts = [
        'week' => 'string',
        'lider' => 'string',
        'name' => 'string',
        'lunes' => 'string',
        'extLunes' => 'float',
        'martes' => 'string',
        'extMartes' => 'float',
        'miercoles' => 'string',
        'extMiercoles' => 'float',
        'jueves' => 'string',
        'extJueves' => 'float',
        'viernes' => 'string',
        'extViernes' => 'float',
        'sabado' => 'string',
        'extSabado' => 'string',
        'domingo' => 'string',
        'extDomingo' => 'string',
        'bonoAsistencia' => 'string',
        'bonoPuntualidad' => 'string',
        'extras' => 'string',
        'tiempoPorTiempo' => 'string',
        'id_empleado' => 'string',
        'tt_lunes' => 'float',
        'tt_martes' => 'float',
        'tt_miercoles' => 'float',
        'tt_jueves' => 'float',
        'tt_viernes' => 'float',
        'tt_sabado' => 'float',
        'tt_domingo' => 'float',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    //indexes

   public function scopeLeader($query,$leader)
{
    $week = date('W');
    if($leader == 'Admin' or $leader == 'Paola A'){
        return $query->where('week', $week)->OrderBy('lider', 'desc');
    }else{
    return $query->where('week', $week)->where('lider', '=', $leader)->OrderBy('lider', 'desc');
        }
}

}

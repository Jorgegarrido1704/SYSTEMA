<?php

namespace App\Models\calidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calidad_registro_baja extends Model
{
    use HasFactory;
    protected $table = 'calidad';

    protected $fillable = [
        'np',
        'client',
        'wo',
        'po',
        'info',
        'qty',
        'parcial'

    ];
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $autoIncrement = true;
    protected $keyType = 'int';


    public function calidadRegistro()
    {
        return $this->hasMany(calidad_registro_baja::class, 'id');
    }

}

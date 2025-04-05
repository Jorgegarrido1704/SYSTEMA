<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class controlAlmacen extends Model
{
    use HasFactory;
    public $fillable=[
        'fechaMov',//aaaa-mm-dd
        'itIdInt',
        'Qty',
        'MovType',
        'UserReg',
        'id_importacion',
        'codUnic',
        'comentario',
    ];
    protected $table = "controlalmacen";
    public $timestamps = false;
}

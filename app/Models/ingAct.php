<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ingAct extends Model
{
    use HasFactory;
    protected $fillable = [
        'Id_request',
        'fecha',
        'finT',
        'actividades',
        'desciption',
        'count',
        'analisisPlano',
        'bom',
        'AyudasVizuales',
        'bomRmp',
        'fullSize',
        'fechaEncuesta',
        'listaCort'
    ];
    protected $table = "ingactividades";
    public $timestamps = false;
}

<?php

namespace App\Models;
use App\Models\Wo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class regPar extends Model
{
    use HasFactory;
    protected $fillable=[
        'pn',
        'wo',
        'orgQty',
        'cortPar',
        'libePar',
        'ensaPar',
        'preCalidad',
        'loomPar',
        'testPar',
        'embPar',
        'eng',
        'codeBar',
        'fallasCalidad',
        'specialWire'

    ];
    protected $table = 'registroparcial';
    public $timestamps = false;

    public function registos()
    {
       return $this->hasMany(Wo::class)->whereColumn('codeBar','info');
    }
}

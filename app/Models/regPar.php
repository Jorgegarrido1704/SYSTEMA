<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class regPar extends Model
{
    use HasFactory;

    protected $fillable = [
        'pn', 'wo', 'orgQty', 'planpar', 'precut', 'tobecut', 'cortPar', 'preterm',
        'tobeterm', 'libePar', 'preassembly', 'tobeassembly', 'ensaPar', 'preCalidad',
        'preloom', 'tobeloom', 'loomPar', 'testPar', 'preemba', 'embPar', 'eng', 'codeBar',
        'fallasCalidad', 'specialWire', 'auditoria',

    ];

    protected $table = 'registroparcial';

    public $timestamps = false;

    public function registos()
    {
        return $this->hasMany(Wo::class)->whereColumn('codeBar', 'info');
    }
}

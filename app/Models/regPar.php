<?php

namespace App\Models;

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
        'espWPar',
        'loomPar',
        'testPar',
        'embPar',
        'codeBar'

    ];
    protected $table = 'registroparcial';
    public $timestamps = false;
}

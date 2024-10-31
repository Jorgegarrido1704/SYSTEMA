<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class errores extends Model
{

    use HasFactory;
    public $fillable=[

        'pn',
        'wo',
        'rev',
        'problem',
        'descriptionIs',
        'resp',
        'WhoReg',
        'DateIs',
        'validator'
    ];
    protected $table = "errores";
    public $timestamps = false;

}

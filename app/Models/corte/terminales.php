<?php

namespace App\Models\corte;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class terminales extends Model
{
    use HasFactory;

    protected $table = 'terminales';

    protected $fillable = [
        'terminal',
        'externalPartNumero',
        'insulationWeight',
        'insulationHeight',
        'terminalWeight',
        'terminalHeight',
        'pullTest',
        'substitution',
        'nameImage',
        'infoDownload',
    ];
}

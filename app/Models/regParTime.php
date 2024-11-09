<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class regParTime extends Model
{
    use HasFactory;
    protected $fillable=[
        'codeBar',
        'qtyPar',
        'area',
        'fechaReg'

    ];
    protected $table = 'registroparcialtiempo';
    public $timestamps = false;
}

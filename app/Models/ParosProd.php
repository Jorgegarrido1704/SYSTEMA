<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParosProd extends Model
{
    use HasFactory;
    protected $fillable=['fecha','area','trabajo','finhora','id_request'];
    public $timestamps = false;

    protected $table = 'registro_paro_corte';
}

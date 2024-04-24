<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class material extends Model
{
    use HasFactory;
    public $fillable=[
        'folio',
        'fecha',
        'who',
        'description',
        'note',
        'qty',
        'aprovadaComp',
        'negada'
    ];

    protected $table="material";
    public $timestamps = false;
}

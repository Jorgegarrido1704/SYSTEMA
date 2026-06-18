<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listasDeCorte extends Model
{
    use HasFactory;

    protected $table = 'listascorte';

    public $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'pn', 'rev', 'cons', 'tipo', 'aws', 'color', 'tamano', 'strip1', 'terminal1',
        'app1', 'strip2', 'terminal2', 'app2', 'conector', 'colorTinta', 'dataFrom',
        'dataTo', 'defaultTime', 'dist_stamp', 'last_updated',
    ];

    public $timestamps = false;
}

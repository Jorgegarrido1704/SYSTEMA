<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registroQ extends Model
{
    use HasFactory;
    protected $table = 'registro_q_s';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $filallable = [
        'fecha',
        'userReg',
        'presentacion'
    ];
}

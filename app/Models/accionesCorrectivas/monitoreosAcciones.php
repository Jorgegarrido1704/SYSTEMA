<?php

namespace App\Models\accionesCorrectivas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class monitoreosAcciones extends Model
{
    use HasFactory;
    protected $table = 'monitoreos_acciones';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
}

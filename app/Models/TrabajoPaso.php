<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabajoPaso extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function plantilla()
    {
        return $this->belongsTo(PlantillaPaso::class, 'plantilla_paso_id');
    }
}

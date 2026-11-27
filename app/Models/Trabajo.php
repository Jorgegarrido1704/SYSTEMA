<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['datos' => 'array'];

    public function pasos()
    {
        return $this->hasMany(TrabajoPaso::class)->orderBy('orden');
    }
}

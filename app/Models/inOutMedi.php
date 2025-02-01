<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inOutMedi extends Model
{
    use HasFactory;
    protected $fillable = ['id_moviment ', 'medicament', 'dateMove', 'qtyMove', 'id_visEnf'];
    public $timestamps = false;
    protected $table = 'movimentsmedicament';
}

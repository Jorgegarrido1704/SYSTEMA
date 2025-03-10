<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fallasCalidadModel extends Model
{
    use HasFactory;
    protected $fillable = ['idCalidad'];

    protected $table = 'fallascalidad';
    public $timestamps = false;
}

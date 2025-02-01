<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salud extends Model
{
    use HasFactory;
    protected $fillable = ['id_salud', 'employee', 'motive', 'Diagnostic', 'dateVisit'];
    public $timestamps = false;
    protected $table = 'salud';
}

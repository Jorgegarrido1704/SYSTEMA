<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class creacionKit extends Model
{
    use HasFactory;
    public $fillable=[
        'id',
        'fecha',
        'pn',
        'wo',
        'item',
        'qty',
        'usuario'
    ];
    protected $table = "creacionKits";
    public $timestamps = false;
}

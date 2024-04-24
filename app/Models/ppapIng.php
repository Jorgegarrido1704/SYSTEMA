<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ppapIng extends Model
{
    use HasFactory;

    public $fillable=[
        'info',
        'fecha',
        'codigo',
        'area'
    ];
    protected $table='ppap';
    public $timestamps=false;

}

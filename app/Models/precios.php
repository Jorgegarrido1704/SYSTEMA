<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class precios extends Model
{
    use HasFactory;

    public $fillable = [
        'client',
        'pn',
        'desc',
        'rev',
        'price',
        'send',
        'dateUpdate',
    ];

    protected $table = 'precios';

    public $timestamps = false;

    protected $primaryKey = 'id';
}

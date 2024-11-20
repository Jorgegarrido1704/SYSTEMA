<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
    use HasFactory;
    protected $fillable = [
        'np',
        'cliente',
        'rev',
        'wo',
        'cons',
        'color',
        'tipo',
        'aws',
        'codigo',
        'term1',
        'term2',
        'dataFrom',
        'dataTo',
        'qty',
        'tamano',
        'conector'
    ];

    protected $table = 'corte'; // Adjust the table name if it's different

    public $timestamps = false; // Set to false if you don't have created_at and updated_at columns
}

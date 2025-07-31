<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wo extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'NumPart',
        'Cliente',
        'rev',
        'wo',
        'po',
        'Qty',
        'Barcode',
        'info',
        'donde',
        'count',
        'timpototal',
        'paro',
        'description',
        'price',
        'sento',
        'orday',
        'reqday'
    ];

    protected $table = 'registro'; // Adjust the table name if it's different

    public $timestamps = false; 

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    use HasFactory;

    protected $fillable = [
        'client',
        'pn',
        'fecha',
        'rev',
        'po',
        'qty',
        'description',
        'price',
        'send',
        'orday',
        'reqday',
        'count',
    ];

    protected $table = 'po'; // Adjust the table name if it's different

    public $timestamps = false; // Set to false if you don't have created_at and updated_at columns

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class getPnDetail extends Model
{
    use HasFactory;

    protected $fillable = ['client', 'rev', 'desc', 'price', 'send'];
    protected $table = 'precios'; // Adjust the table name

    public $timestamps = false;
}

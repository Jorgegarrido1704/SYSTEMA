<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventaryMedicine extends Model
{
    use HasFactory;
    protected $fillable = ['id_medicine', 'medicine', 'qty_medicine'];
    public $timestamps = false;

    protected $table = 'inventary_medicine';

}

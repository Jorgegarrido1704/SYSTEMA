<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class globalInventarios extends Model
{
    use HasFactory;
    protected $fillable =['items', 'Register', 'qty', 'fecha', 'hora', 'id_workOrder', 'Validador'];
    protected $table = 'inventario';

    public $timestamps = false;
}

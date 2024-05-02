<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemsConsumidos extends Model
{
    use HasFactory;
    public $fillable = ['id', 'item', 'qty'];
    protected $table = 'itemsconsumidos';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class specialWireModel extends Model
{
    use HasFactory;

    protected$fiilable = [
        'id',
        'partNumber'
    ];
    public $timestamps = true;
    protected $table = 'special_wire_models';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class specialWireModel extends Model
{
    use HasFactory;

    protected$fiilable = [
        'id',
        'partNumber',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
    protected $table = 'special_wire_models';

    public function scopeSpecialWire($registroLoom)
    {

       return specialWireModel::where('partNumber', $registroLoom)->orderBy('id', 'desc')->first();
    }
}

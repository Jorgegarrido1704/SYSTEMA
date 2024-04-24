<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registoLogin extends Model
{
    use HasFactory;
    protected $fillable=[
        'fecha',
        'userName',
        'action'

    ];
    protected $table = 'registros';
    public $timestamps = false;
}


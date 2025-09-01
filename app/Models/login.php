<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class login extends Model
{
    use HasFactory;
    protected $fillable = [
        'user',
        'clave',
        'category',
        'user_email',
        



    ];
    protected $table = 'login';

    public $timestamps = false;
}

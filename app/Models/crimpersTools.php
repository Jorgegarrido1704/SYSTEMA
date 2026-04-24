<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crimpersTools extends Model
{
    use HasFactory;

    protected $fillable = [
        'DateRegistered',
        'StartHour',
        'EndHour',
        'toolingCrimperName',
        'TerminalsUsed',

    ];

    protected $table = 'crimpers_tools';
}

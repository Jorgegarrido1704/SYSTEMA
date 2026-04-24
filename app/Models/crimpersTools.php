<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crimpersTools extends Model
{
    use HasFactory;

    protected $fillable = [
        'dateRegistered',
        'startHour',
        'endHour',
        'toolingCrimperName',
        'TerminalsUsed',
        'minutesStop',
        'reasonStop',
        'observations',
    ];

    protected $table = 'crimpers_tools';

    protected $primaryKey = 'id';

    public $timestamps = true;
}

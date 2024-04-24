<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timesHarn extends Model
{
    use HasFactory;
    public $fillable = [
        'pn',
        'wo',
        'cut',
        'term',
        'ensa',
        'loom',
        'qly',
        'emba',
        'bar',
        'fecha'

    ];
    protected $table = 'timesharn';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class issuesFloor extends Model
{
    use HasFactory;

    protected $table = 'issuesfloor';
    protected $fillable = ['id_tiempos', 'comment_issue', 'date', 'responsable','actionOfComment'];
    public $timestamps = false ;
    protected $primaryKey = 'id_issuesfloor';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'id_issuesfloor' => 'string',
        'id_tiempos' => 'string',
        'comment_issue' => 'string',
        'date' => 'datetime',
        'responsable' => 'string',
        'actionOfComment' => 'string'
    ];

}

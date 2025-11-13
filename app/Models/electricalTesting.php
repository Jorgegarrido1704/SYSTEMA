<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class electricalTesting extends Model
{
    use HasFactory;
    protected $table = 'electricalTesting';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'pn',
        'wo',
        'client',
        'requested_by',
        'status_of_order',
        'created_at',
        'updated_at'
    ];

    protected $cast = [
        'pn' => 'string',
        'wo' => 'string',
        'client' => 'string',
        'requested_by' => 'string',
        'status_of_order' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];




}

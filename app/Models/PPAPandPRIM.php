<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPAPandPRIM extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
  'tp',
  'client',
  'tipo',
  'pn',
  'REV1',
  'REV2',
  'cambios',

  'fecha',
  'eng',
  'quality',
  'ime',
  'test',
  'production',
  'compras',
  'gernete',
  'count'

    ];
    protected $table = "ppapandprim";
    public $timestamps = false;
}

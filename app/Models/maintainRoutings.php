<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maintainRoutings extends Model
{
    use HasFactory;
    protected $table = 'maintain_routings';
    protected $primaryKey = 'id';
    protected $fillable = ['pn','created_at','updated_at'];
}

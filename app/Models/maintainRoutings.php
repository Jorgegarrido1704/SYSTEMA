<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maintainRoutings extends Model
{
    use HasFactory;

    protected $table = 'maintain_routings';

    protected $primaryKey = 'id';

    protected $fillable = ['pn', 'routing_status', 'created_at', 'updated_at'];

    public $timestamps = true;
}

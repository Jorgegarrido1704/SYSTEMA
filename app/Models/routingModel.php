<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class routingModel extends Model
{
    use HasFactory;

    protected $table = 'routing_models';
    public $primaryKey = 'id_routing';
    public $incrementing = true;
    public $keyType = 'integer';
    public $fillable = [ 'pn_routing', 'work_routing', 'posibleStations','workDescription','QtyTimes','setUp_routing','tiemposPromedio'];
    public $timestamps = false;

    public function scopeSearch($query, $search)
    {
        return $query->where('pn_routing', '=',   $search )->get();
    }
     public function timeProcesses()
    {
        return $this->hasMany(timeproces::class, 'Process_Number','work_routing');
    }

}

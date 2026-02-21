<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materialPruebasElectricas extends Model
{
    use HasFactory;
    protected $table = 'material_pruebas_electricas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pn',
        'rev',
        'customer',
        'priority',
        'connector',
        'connectorQty',
        'terminal',
        'terminalQty',
        'dateRecepcion',
        'deliveryDate',
        'status',
        'po',
        'observaciones',
        'materialAtLaredo',
        'eta_bea',
    ];
    protected $dates = ['dateRecepcion', 'deliveryDate'];
    protected $casts = [
        'dateRecepcion' => 'date',
        'deliveryDate' => 'date',
        'pn'=>'string',
        'rev'=>'string',
        'customer'=>'string',
        'priority'=>'string',
        'connector'=>'string',
        'connectorQty'=>'integer',
        'terminal'=>'string',
        'terminalQty'=>'integer',
        'status'=>'string',
        'po'=>'string',
        'observaciones'=>'string',
        'materialAtLaredo'=>'string',
        'eta_bea'=>'string',
    ];


}

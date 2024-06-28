<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fullsizes extends Model
{
    use HasFactory;

    protected $fillable=['cliente','np','rev','tipo_full','EmailVal','fechaElaboracion','noTablas','enAlmacen','enPiso','deschado','porqueDesecho','fechaDesecho','catDesecho'  ];

    protected $table ='fullsizes';

    public $timestamps= false;
}

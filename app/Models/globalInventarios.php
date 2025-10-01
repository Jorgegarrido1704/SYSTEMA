<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class globalInventarios extends Model
{
    use HasFactory;
    protected $fillable =['items','Register_first_count','first_qty_count','date_first_count',
    'Register_second_count','second_qty_count','date_second_count','difference','id_workOrder','auditor',
    'Folio_sheet_audited','fecha_auditor','status_folio_general'];
    protected $table = 'inventarioGlobal';

    public $timestamps = false;
}

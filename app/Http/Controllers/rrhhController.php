<?php

namespace App\Http\Controllers;

use App\Models\assistence;
use Illuminate\Http\Request;

class rrhhController extends Controller
{
    public function rrhhDashBoard()
    {
        $value=session('user');
        $cat=session('categoria');
       $datosRHWEEK = assistence::changeInfo()->get(); 
        return view('juntas/hrDocs/rrhhDashBoard',['datosRHWEEK'=>$datosRHWEEK,'value'=>$value,'cat'=>$cat]);
    }
}

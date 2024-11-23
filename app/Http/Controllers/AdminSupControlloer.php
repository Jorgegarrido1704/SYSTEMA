<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSupControlloer extends Controller
{
    //
    public function __invoke(){
        if(session('categoria')!='SupAdmin'){
            return redirect('/login');
        }else{
        return view('SupAdmin');}

    }
}

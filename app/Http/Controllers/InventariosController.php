<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\globalInventarios;
use Illuminate\Support\Facades\DB;
use App\Models\Wo;

class InventariosController extends Controller
{
    //
    public function index_inventarios()
    {
        $cat=session('categoria');
        $value=session('user');
        $datosRegistros=[];
        if( $value=="" ){
            return redirect('/');
        }
        if($cat=="invreg1" || $cat=="invreg2" || $cat=="capt" || $cat=="invwo1" || $cat=="invwo2"  ){

        $datosRegistros=globalInventarios::where('Register_first_count','=',$value)->orWhere('Register_second_count','=',$value)->get();

        }else if($cat=="Boss"){
            $datosRegistros=globalInventarios::all();
        }

        return view('inventarios.InventarioGeneral'
        , ['value' => session('user'), 'cat' => session('categoria'),'datosRegistros'=>$datosRegistros]);
    }

    public function pisoWork(Request $request)
    {
        $cat=session('categoria');
        $value=session('user');
        if( $value=="" ){
            return redirect('/');
        }
        $datosRegistros=globalInventarios::where('Register_first_count','=',$value)->orWhere('Register_second_count','=',$value)->get();


        return view('inventarios.RecopilacionDeInventario'
        , ['value' => session('user'), 'cat' => session('categoria'),'datosRegistros'=>$datosRegistros]);
    }

    public function getDatosInventarioWork(Request $request)
    {
        $cat=session('categoria');
        $value=session('user');
        if( $value=="" ){
            return redirect('/');
        }
        $workOrder=$request->input('workOrder');
        $datosWo=Wo::select('NumPart','rev')->where('wo',$workOrder)->first();
        if(!$datosWo){
            return response()->json(['status' => 'error', 'message' => 'Work Order not found']);
        }
        $partNum=$datosWo->NumPart;
        $rev=$datosWo->rev;

        $datosRegistros=DB::table('datos')->select('item','qty')->where('part_num', $partNum)->where('rev', $rev)->get();
        return response()->json(['status' => 'success', 'data' => $datosRegistros]);
    }
}

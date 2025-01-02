<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\globalInventarios;
use Illuminate\Http\Request;

class globalInventario extends Controller
{
    //index
    public function index_inventario(Request $request){
        $cat=session('categoria');
        $user=session('user');
        $wo=request('wo');
        $qt=request('qty_pn');
        $items=[];
        $i=0;
        if(DB::table('datos')->where('part_num',$wo)->exists()){
            if($user=="Andrea"){
            $buscarItems=DB::table('datos')
            ->where('part_num',$wo)
            ->where('item','NOT LIKE','TAPE%')
            ->where('item','NOT LIKE','LW%')
            ->where('item','NOT LIKE','%T5-%')
            ->where('item','NOT LIKE','%T4-%')
            ->where('item','NOT LIKE','%T1-%')
            ->where('item','NOT LIKE','%T2-%')
            ->where('item','NOT LIKE','%T3-%')
            ->where('item','NOT LIKE','LTP%')
            ->where('item','NOT LIKE','WGX%')
            ->where('item','NOT LIKE','WSG%')
            ->where('item','NOT LIKE','WTX%')
            ->where('item','NOT LIKE','SK%')
            ->get();
        }else{
            $buscarItems=DB::table('datos')
            ->where('part_num',$wo)->get();}
            foreach($buscarItems as $rowItems){
                $items[$i][0]=$rowItems->item;
                $items[$i][1]=round($rowItems->qty*$qt,2);
                $i++;
            }

            return view('globalInventary', ['cat'=>$cat,'user'=>$user,'wo'=>$wo,'qt'=>$qt,'items'=>$items]);
        }else{

        return view('globalInventary', ['cat'=>$cat,'user'=>$user]);}
    }
    public function WOitems(Request $request){
        $cat=session('categoria');
        $user=session('user');
        $wo=request('wo');
        $qty=request('qty');
        $items=request('items');
        $i=0;
        foreach($items as $item){
            if($qty[$i]>0){
            $addItem=new globalInventarios;
            $addItem->items=$item;
            $addItem->Register=$user;
            $addItem->qty=$qty[$i];
            $addItem->fecha=date('d-m-Y');
            $addItem->hora=date('H:i');
            $addItem->id_workOrder=$wo;
            $addItem->Validador='-';
            $addItem->save();
            }
            $i++;
        }
        if($addItem){
            return redirect('globalInventario')->with('success','Items agregados correctamente');
        }
    }

        public function indItems(Request $request){
            $cat=session(key: 'categoria');
            $user=session('user');
           $qty=request('qtyunic');
            $items=request('itemunic');
            $item=strtoupper($items);
                $addItem=new globalInventarios;
                $addItem->items=$item;
                $addItem->Register=$user;
                $addItem->qty=$qty;
                $addItem->fecha=date('d-m-Y');
                $addItem->hora=date('H:i');
                $addItem->id_workOrder='individual';
                $addItem->Validador='-';
              if(  $addItem->save()){
                return redirect('globalInventario')->with('success','Items agregados correctamente');
            }
        }

}

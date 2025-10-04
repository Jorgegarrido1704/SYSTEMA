<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\globalInventarios;
use Illuminate\Support\Facades\DB;
use App\Models\Wo;
use Carbon\Carbon;
use Validator;

class InventariosController extends Controller
{
    //
    public function index_inventarios()
    {
        $cat = session('categoria');
        $value = session('user');
        $folio="";
        $datosRegistros = [];
        if ($value == "") {
            return redirect('/');
        }
        if ($cat == "invreg1" || $cat == "invreg2" || $cat == "capt" || $cat == "invwo1" || $cat == "invwo2") {
            $folio=globalInventarios::where('Register_first_count', '=', $value)->orderBy('id_item', 'desc')->first();
            $datosRegistros = globalInventarios::where('Register_first_count', '=', $value)->orWhere('Register_second_count', '=', $value)->orderBy('difference', 'desc')->get();
        } else if ($cat == "auditor") {
            $datosRegistros = globalInventarios::all();
        }

        return view(
            'inventarios.InventarioGeneral',
            ['value' => session('user'), 'cat' => session('categoria'), 'datosRegistros' => $datosRegistros,'folio'=>$folio]
        );
    }

    public function pisoWork(Request $request)
    {
        $cat = session('categoria');
        $value = session('user');
        if ($value == "") {
            return redirect('/');
        }
        $datosRegistros = globalInventarios::where('Register_first_count', '=', $value)->orWhere('Register_second_count', '=', $value)->get();


        return view(
            'inventarios.RecopilacionDeInventario',
            ['value' => session('user'), 'cat' => session('categoria'), 'datosRegistros' => $datosRegistros]
        );
    }

    public function getDatosInventarioWork(Request $request)
    {
        $cat = session('categoria');
        $value = session('user');
        if ($value == "") {
            return redirect('/');
        }
        $workOrder = $request->input('workOrder');
        $cantidad = $request->input('cantidad')??0;
        $datosWo = Wo::select('NumPart', 'rev', 'Qty')->where('wo', $workOrder)->first();
        if (!$datosWo) {
            return response()->json(['status' => 'error', 'message' => 'Work Order not found']);
        }
        $partNum = $datosWo->NumPart;
        $rev = $datosWo->rev;
        if(strpos($rev," ")){$rev=explode(" ",$rev)[1];  }


        $qtyWo = $datosWo->Qty;

        $datosRegistros = DB::table('datos')->select('item', DB::raw('(Round(qty,2)*' . $cantidad . ') as qty'))->where('part_num', $partNum)->where('rev', $rev)->get();
        return response()->json(['status' => 'success', 'data' => $datosRegistros]);
    }
    public function addInventarios(Request $request)
    {
        $cat = session('categoria');
        $request->validate([
            'item' => 'required|string',
            'qty' => 'required|numeric',
            'folios' => 'required|string',
        ]);
        $registros=explode("-", session('user'))[1];
        if ($cat == "invreg1") {
            $buscarfolios = globalInventarios::where('Folio_sheet_audited', '=', $request->input('folios'))->where('items','=',$request->input('item'))->exists();
            if ($buscarfolios) {
                $agregar= globalInventarios::where('Folio_sheet_audited', '=', $request->input('folios'))->where('items','=',$request->input('item'))->first();
                $primero=$agregar->first_qty_count??0;
                $actualizado=globalInventarios::where('Folio_sheet_audited', '=', $request->input('folios'))->where('items','=',$request->input('item'))->update([
                    'first_qty_count' => $primero+$request->input('qty')
                ]);
                return redirect()->back()->with('message', 'Inventory added successfully.');
            } else {
                $inventario = new globalInventarios();
                $inventario->items = strtoupper($request->input('item'));
                $inventario->Register_first_count = session('user');
                $inventario->id_workOrder = $registros;
                $inventario->first_qty_count = $request->input('qty');
                $inventario->date_first_count = Carbon::now()->format('Y-m-d H:i');
                $inventario->Folio_sheet_audited = $request->input('folios');
                $inventario->status_folio_general = 'First Count';
                $inventario->save();
                return redirect()->back()->with('message', 'Inventory added successfully.');
            }
        } else if ($cat == "invreg2") {
            $buscarfolios = globalInventarios::where('Folio_sheet_audited', '=', $request->input('folios'))->where('items','=',$request->input('item'))->first();
            if (!$buscarfolios) {
                return redirect()->back()->with('message', 'The folio needs a first count.');
            } else {
                if($buscarfolios->second_qty_count != null or $buscarfolios->second_qty_count != 0){
                    $agregar= globalInventarios::where('Folio_sheet_audited', '=', $request->input('folios'))->where('items','=',$request->input('item'))->update([
                        "second_qty_count"=>$buscarfolios->second_qty_count+$request->input('qty')
                    ]);
                }else{
                $difference = abs($buscarfolios->first_qty_count - $request->input('qty'));
                $inventario = globalInventarios::where('Folio_sheet_audited', '=', $request->input('folios'))->where('items','=',$request->input('item'))->update([
                    'Register_second_count' => session('user'),
                    'second_qty_count' => $request->input('qty'),
                    'date_second_count' => Carbon::now()->format('Y-m-d H:i'),
                    'status_folio_general' => 'Second Count',
                    'difference' => $difference,
                ]);
                }
                return redirect()->back()->with('message', 'Inventory updated successfully.');
            }
        }
    }
    public function addWorkOrder(Request $request)
    {
        $cat = session('categoria');
        $registros=explode("-", session('user'))[1];
        $request->validate([
            'item' => 'required|array',
            'qty' => 'required|array',
            'id_workOrder' => 'required|string',
        ]);
        $repWO= "wip-".$request->input('id_workOrder');
        if ($cat == "invwo1") {
            $buscarfolios = globalInventarios::where('id_workOrder', '=', $repWO)->first();
            if (!empty($buscarfolios)) {
                 for ($i=0; $i < count($request->input('item')); $i++) {
                    $buscaYaregistro = globalInventarios::where('id_workOrder', '=', $repWO)
                    ->where('items','=',$request->input('item')[$i])->first();
                    $cantidad=$buscaYaregistro->first_qty_count??0;
                    $updatedatos=globalInventarios::where('id_workOrder', '=', $repWO)
                    ->where('items','=',$request->input('item')[$i])->update([
                        'first_qty_count' => $cantidad+$request->input('qty')[$i]
                    ]);
                }
                return redirect()->back()->with('message', 'Inventory added successfully.');
            } else {
                for ($i=0; $i < count($request->input('item')); $i++) {
                    $item = $request->input('item')[$i];
                    $item = strtoupper($item);
                    $qty = $request->input('qty')[$i];
                    $inventario = new globalInventarios();
                    $inventario->items = $item;
                    $inventario->Register_first_count = session('user');
                    $inventario->first_qty_count = $qty;
                    $inventario->date_first_count = Carbon::now()->format('Y-m-d H:i');
                    $inventario->id_workOrder = $registros.'-'.$request->input('id_workOrder');
                    $inventario->status_folio_general = 'First Count';
                    $inventario->save();
                }
                return redirect()->back()->with('message', 'Inventory added successfully.');
            }
        } else if ($cat == "invwo2") {
            $buscarfolios = globalInventarios::where('id_workOrder', '=', $repWO)
            ->where('second_qty_count','!=', '0')
            ->first();
            if ($buscarfolios) {
                for ($i=0; $i < count($request->input('item')); $i++) {
                    $buscaYaregistro = globalInventarios::where('id_workOrder', '=', $repWO)
                    ->where('items','=',$request->input('item')[$i])->first();
                    $cantidad = $buscaYaregistro->first_qty_count;
                    $updatedatos=globalInventarios::where('id_workOrder', '=', $repWO)
                    ->where('items','=',$request->input('item')[$i])->update([
                        'first_qty_count' => $cantidad+$request->input('qty')[$i]
                    ]);
                }
                return redirect()->back()->with('message', 'Inventory added successfully.');
            } else {
                 for ($i=0; $i < count($request->input('item')); $i++) {
                    $item = $request->input('item')[$i];
                    $item = strtoupper($item);
                    $qty = $request->input('qty')[$i];

                $difference = abs($buscarfolios->first_qty_count??0 - $qty);

                $inventario = globalInventarios::where('id_workOrder', '=', $repWO)
                ->where('items', '=', $item)->update([
                    'Register_second_count' => session('user'),
                    'second_qty_count' => $qty,
                    'date_second_count' => Carbon::now()->format('Y-m-d H:i'),
                    'status_folio_general' => 'Second Count',
                    'difference' => $difference,
                ]);
            }
                return redirect()->back()->with('message', 'Inventory updated successfully.');
            }
        }
    }
}

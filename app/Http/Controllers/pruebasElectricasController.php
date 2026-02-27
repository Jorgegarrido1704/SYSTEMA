<?php

namespace App\Http\Controllers;

use App\Models\electricalTesting;
use App\Models\materialPruebasElectricas;
use App\Models\regPar;
use App\Models\Wo;
use Illuminate\Http\Request;

class pruebasElectricasController extends Controller
{
    //
    public function pruebasElecticas()
    {
        $value = session('user');
        $cat = session('categoria');
        if ($value == '') {
            return redirect('/');
        }
        $pruebas = $arneses = [];
        $pruebas = electricalTesting::where('status_of_order', '=', 'Pending')->get();
        $racks = electricalTesting::select('pn')->where('status_of_order', '=', 'In rack')
            ->groupBy('pn')->get();
        foreach ($racks as $rack) {
            $woks = regPar::select('orgQty')
                ->selectRaw('(
        COALESCE(ensaPar, 0) +
        COALESCE(testPar, 0) +
        COALESCE(loomPar, 0) +
        COALESCE(preCalidad, 0) +
        COALESCE(eng, 0) +
        COALESCE(fallasCalidad, 0) +
        COALESCE(specialWire, 0)
      ) as total')
                ->where('pn', '=', $rack->pn)
                ->get();
            foreach ($woks as $wok) {
                $rack->total += $wok->total;
                $rack->orgQty += $wok->orgQty;
            }

        }

        // $arneses = regPar::where('ensaPar', '!=', 0)->orWhere('loomPar', '!=', 0)->orWhere('eng', '!=', 0)->orWhere('specialWire', '!=', 0)->orderBy('pn', 'asc')->get();
        $arneseses = regPar::whereRaw(
            'COALESCE(ensaPar, 0) +
        COALESCE(loomPar, 0) +
        COALESCE(preCalidad, 0) +
        COALESCE(eng, 0) +
        COALESCE(fallasCalidad, 0) +
        COALESCE(specialWire, 0) > 0'
        )->orderBy('pn', 'asc')->get();
        foreach ($arneseses as $arnes) {
            if (! electricalTesting::where('pn', $arnes->pn)->where('status_of_order', '=', 'In rack')->exists()) {
                $arneses[] = $arnes;
            }
        }

        return view('inge.pruebasElectricas.index', ['racks' => $racks, 'value' => $value, 'cat' => $cat, 'pruebas' => $pruebas, 'arneses' => $arneses]);
    }

    public function dispatchElecticalTest(request $request)
    {
        if ($request->input('id') != null) {
            $distch = electricalTesting::where('id', $request->input('id'))->update([
                'status_of_order' => 'In rack']);
        } elseif ($request->input('remove') != null) {
            $distch = electricalTesting::where('pn', $request->input('remove'))->update([
                'status_of_order' => 'Completed']);
        } elseif ($request->input('addRack') != null) {
            $searchDataByWo = Wo::where('wo', '=', $request->input('addRack'))->first();
            $inRack = electricalTesting::insert([
                'pn' => $searchDataByWo->NumPart,
                'client' => $searchDataByWo->cliente,
                'wo' => $request->input('addRack'),
                'requested_by' => session('user'),
                'status_of_order' => 'In rack',

            ]);
        }

        return redirect()->back()->with('message', 'Inventory added successfully.');
    }

    public function testingMaterialRequeriment()
    {
        $cat = session('categoria');
        $value = session('user');
        if ($value == '') {
            return redirect('/');
        }

        return view('inge.pruebasElectricas.testingMaterialRequeriment', ['value' => $value, 'cat' => $cat]);
    }

    public function searchMaterialPruebas(Request $request)
    {
        $data = materialPruebasElectricas::all();

        // dd($data);
        return response()->json($data);

    }

    public function addMaterial(Request $request)
    {

        $validated = $request->validate([
            'pn' => ['required', 'string'],
            'rev' => ['required', 'string'],
            'customer' => ['required', 'string'],
            'priority' => ['required', 'string'],
            'connector' => ['required', 'string'],
            'connqty' => ['required', 'numeric', 'min:0'],
            'terminal' => ['required', 'string'],
            'termqty' => ['required', 'numeric', 'min:0'],
            'observ' => ['required', 'string'],
        ]);

        $material = new materialPruebasElectricas;

        $material->pn = $validated['pn'];
        $material->rev = $validated['rev'];
        $material->customer = $validated['customer'];
        $material->priority = $validated['priority'];
        $material->connector = $validated['connector'];
        $material->connectorQty = $validated['connqty'];
        $material->terminal = $validated['terminal'];
        $material->terminalQty = $validated['termqty'];
        $material->observaciones = $validated['observ'];

        $material->save();
        $userPurchase = [
            'jgarrido@mx.bergstrominc.com',
        ];

        Mail::to($userPurchase)->send(new \App\Mail\pruebasElectricas\addMaterial($material, 'New Material Added for Electrical Testing'));

        return redirect()->back()->with('message', 'Material added successfully.');

    }
}

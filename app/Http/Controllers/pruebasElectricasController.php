<?php

namespace App\Http\Controllers;

use App\Models\electricalTesting;
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
        $racks = electricalTesting::where('status_of_order', '=', 'In rack')->get();
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
        $arneseses = regPar::where('ensaPar', '!=', 0)->orWhere('testPar', '!=', 0)->orWhere('preCalidad', '!=', 0)->orWhere('loomPar', '!=', 0)->orWhere('eng', '!=', 0)->orWhere('specialWire', '!=', 0)->orderBy('pn', 'asc')->get();
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
            $distch = electricalTesting::where('id', $request->input('remove'))->update([
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
}

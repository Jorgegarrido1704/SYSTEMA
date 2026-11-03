<?php

namespace App\Http\Controllers;

use App\Models\precios;
use App\Models\Wo;
use Illuminate\Http\Request;

class getPnDetailsController extends Controller
{
    public function getPnDetails(Request $request)
    {
        $pn = $request->input('pn');

        // Validar número de parte
        if (empty($pn)) {
            return response()->json([
                'error' => 'Part number is required',
            ], 400);
        }

        // Obtener información del número de parte
        $pnDetail = precios::where('pn', $pn)->first();

        if (! $pnDetail) {
            return response()->json([
                'error' => 'Part number not found',
            ], 404);
        }

        $client = $pnDetail->client;
        $desc = $pnDetail->desc;
        $rev = $pnDetail->rev;
        $price = $pnDetail->price;
        $send = $pnDetail->send;

        // Obtener última revisión de Work Orders
        $latestRev = Wo::select('rev')
            ->where('NumPart', $pn)
            ->orderBy('id', 'desc')
            ->first();

        // Determinar color
        $color = 'white';

        if ($latestRev && ! empty($latestRev->rev)) {

            if (
                strpos($latestRev->rev, 'PPAP') !== false ||
                strpos($latestRev->rev, 'PRIM') !== false
            ) {
                $color = 'blue';
            }
        }

        return response()->json([
            'client' => $client,
            'desc' => $desc,
            'rev' => $rev,
            'price' => $price,
            'send' => $send,
            'color' => $color,
        ]);
    }
}

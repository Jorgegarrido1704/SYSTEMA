<?php

namespace App\Http\Controllers;

use App\Models\Wo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class getPnDetailsController extends Controller
{
    public function getPnDetails(Request $request)
    {
        // Assuming you have a 'pn' field in the request
        $pn = $request->input('pn');

        // Query the database to fetch details based on the part number
        $pnDetail = DB::select('SELECT * FROM precios WHERE pn=?', [$pn]);
        foreach ($pnDetail as $detail) {
            $client = $detail->client;
            $desc = $detail->desc;
            $rev = $detail->rev;
            $price = $detail->price;
            $send = $detail->send;
        }
        $latestRev = Wo::select('rev')->where('NumPart', $pn)->orderBy('id', 'desc')->first();
        $color = strpos($latestRev->rev, 'PPAP') !== false ? 'blue' : (strpos($latestRev->rev, 'PRIM') !== false ? 'blue' : 'white');
        $pnDetails = [
            'client' => $client,
            'desc' => $desc,
            'rev' => $rev,
            'price' => $price,
            'send' => $send,
            'color' => $color,
        ];

        // Return the details as JSON response
        return response()->json($pnDetails);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        $date = date("d-m-Y");
        $datos = [];
        $tt1 = $tt2 = $tt3 = $tt4 = $tt5 = $tt6 = $tt7 = $tt8 = $tt9 = $tt10 = $tt11 = $tt12 = $tt13 = $tt14 = 0;
       for ($i = 0; $i < 14; $i++) {
            $datos[] = 0;
        }
        $tiempos = DB::select("SELECT * FROM tiempos WHERE calidad LIKE ?", ["$date%%"]);
        foreach ($tiempos as $tiempo) {
            $info = $tiempo->info;
            $time = $tiempo->calidad;
            $times = substr($time, 0, 10);
            $h = substr($time, 11, 2);
            for ($i = 7; $i <= 20; $i++) {
                $hourStr = str_pad($i, 2, '0', STR_PAD_LEFT);
                $searchReg = "SELECT * FROM regsitrocalidad WHERE info = ? AND fecha LIKE ?";
                $qrypar = DB::select($searchReg, [$info, "$date$hourStr:%%"]);
                $numrowsparcial = count($qrypar);

                $searchParcial = "SELECT * FROM registro WHERE info = ?";
                $qryreg = DB::select($searchParcial, [$info]);

                foreach ($qryreg as $rowreg) {
                    $pn = $rowreg->NumPart;
                    $price = $rowreg->price;
                    $total = $numrowsparcial * $price;

                    // Update corresponding total variable
                    ${"tt$i"} += $total;
                    // Update datos array
                    $datos[$i - 7] = ${"tt$i"};
                }
            }
        }

        // Calculate the total sum
        $datos[14] = array_sum(array_slice($datos, 0, 14));

        // Prepare horarios array
        $horarios = ['7:00','8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','Total'];

        // Pass data to your view or return as JSON if it's an API endpoint
        return view('/', compact('datos', 'horarios', 'date'));
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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


    public function mostrarWO(Request $request)
    {
        $buscarWo = $request->input('buscarWo');
        $datosWo = [];

        $buscar = DB::table('registroparcial')
            ->orwhere('pn', 'like', $buscarWo.'%')
            ->orWhere('pn', 'like', '%'.$buscarWo)
            ->orWhere('pn', 'like', '%'.$buscarWo.'%')
            ->get();

            $tableContent = '';
            foreach ($buscar as $row) {
                $tableContent .= '<tr>';
                $tableContent .= '<td>' . $row->pn . '</td>';
                $tableContent .= '<td>' . $row->wo . '</td>';
                $tableContent .= '<td>' . $row->cortPar . '</td>';
                $tableContent .= '<td>' . $row->libePar . '</td>';
                $tableContent .= '<td>' . $row->ensaPar . '</td>';
                $tableContent .= '<td>' . $row->loomPar . '</td>';
                $tableContent .= '<td>' . $row->testPar . '</td>';
                $tableContent .= '<td>' . $row->embPar . '</td>';
                $tableContent .= '</tr>';
            }

            return response()->json([
                'tableContent' => $tableContent,
            ]);
}

}

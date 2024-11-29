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
        return view('SupAdmin',['value'=>session('user'),'cat'=>session('categoria')]);}

    }


    public function mostrarWO(Request $request)
    {
        $buscarWo = $request->input('buscarWo');
        $datosWo =$datosPass=$pnReg=$regftq=$paretos= [];
        $tableContent=$tableReg = $tableftq='';
        $i=$ok=$nog=0;

        $buscar = DB::table('registroparcial')
            ->orwhere('pn', 'like', $buscarWo.'%')
            ->orWhere('pn', 'like', '%'.$buscarWo)
            ->orWhere('pn', 'like', '%'.$buscarWo.'%')
            ->get();
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
                $pnReg[$i]=$row->pn;
                $i++;
            }
           $pnReg = array_unique($pnReg);

           foreach($pnReg as $pnR){
            $buscarR = DB::table('retiradad')
            ->where('np', '=', $pnR)
            ->get();
            foreach ($buscarR as $rowR) {
                $tableReg .= '<tr>';
                $tableReg .= '<td>' . $rowR->np . '</td>';
                $tableReg .= '<td>' . $rowR->wo . '</td>';
                $tableReg .= '<td>' . $rowR->qty . '</td>';
                $tableReg .= '<td>' . $rowR->fechaout . '</td>';
                $tableReg .= '</tr>';
            }

        $registroftq=DB::table('regsitrocalidad')
        ->where('pn', '=', $pnR)
        ->get();
        foreach ($registroftq as $rowftq) {
           $codigo=$rowftq->codigo;
           if($codigo=='TODO BIEN'){
        $ok++;
        }else{
            $nog++;
        }

           if(in_array($codigo , array_keys($regftq))){
               $regftq[$codigo]++;
           }else{
               $regftq[$codigo]=1;

           }
        }
        foreach($regftq as $key => $value){
            $tableftq .= '<tr>';
            $tableftq .= '<td>' .$key. '</td>';
            $tableftq .= '<td>' . $value . '</td>';
            $tableftq .= '</tr>';
        }
    }
        $paretos[0]=$ok;
        $paretos[1]=$nog;
        $paretos[2]=round($ok/($ok+$nog)*100,2);

            return response()->json([
                'paretos' => $paretos,
                'tableftq' => $tableftq,
                'tableContent' => $tableContent,
                'tableReg' => $tableReg,
            ]);
}

}

<?php

namespace App\Http\Controllers;

use App\Models\regPar;
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
    public function exelCalidad(Request $request){
        $di=$request->input('di');
        $df=$request->input('df');
        $datos= new caliController();
        $datos->excel_calidad($di,$df);

    }
    public function mostrarWO(Request $request)
    {
        $buscarWo = $request->input('buscarWo');
        $datosWo =$datosPass=$pnReg=$regftq=$paretos= [];
        $tableContent=$tableReg = $tableftq=$pullTest='';
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
            if(count($buscarR)>0){
            foreach ($buscarR as $rowR) {
                $tableReg .= '<tr>';
                $tableReg .= '<td>' . $rowR->np . '</td>';
                $tableReg .= '<td>' . $rowR->wo . '</td>';
                $tableReg .= '<td>' . $rowR->qty . '</td>';
                $tableReg .= '<td>' . $rowR->fechaout . '</td>';
                $tableReg .= '</tr>';
            }
        }else{
            $tableReg .= '<tr>';
            $tableReg .= '<td></td>';
            $tableReg .= '<td>' . '0' . '</td>';
            $tableReg .= '<td>' . '0' . '</td>';
            $tableReg .= '<td>' . '0' . '</td>';
            $tableReg .= '</tr>';
        }

        $registroftq=DB::table('regsitrocalidad')
        ->where('pn', '=', $pnR)
        ->get();
        if(count($registroftq)>0){
        foreach ($registroftq as $rowftq) {
           $codigo=$rowftq->codigo;
           if($codigo=='TODO BIEN'){
        $ok++;
        }else{
            $nog++;
        }
    }
           if(in_array($codigo , array_keys($regftq))){
               $regftq[$codigo]++;
           }else{        $regftq[$codigo]=1;   }

        foreach($regftq as $key => $value){
            $tableftq .= '<tr>';
            $tableftq .= '<td>' .$key. '</td>';
            $tableftq .= '<td>' . $value . '</td>';
            $tableftq .= '</tr>';
        }

        $paretos[0]=$ok;
        $paretos[1]=$nog;
        $paretos[2]=round($ok/($ok+$nog)*100,2);

        $buscarRegistroPull=DB::table('registro_pull')
    ->where('Num_part', '=', $pnR)
    ->orderBy('id', 'desc')
    ->get();
    if(count($buscarRegistroPull)>0){
    foreach ($buscarRegistroPull as $rowPull) {

        $pullTest .= '<tr>';
        $pullTest .= '<td>' . $rowPull->fecha . '</td>';
        $pullTest .= '<td>' . $rowPull->Num_part . '</td>';
        $pullTest .= '<td>' . $rowPull->calibre . '</td>';
        $pullTest .= '<td>' . $rowPull->presion . '</td>';
        $pullTest .= '<td>' . $rowPull->forma . '</td>';
        $pullTest .= '<td>' . $rowPull->cont . '</td>';
        $pullTest .= '<td>' . $rowPull->quien . '</td>';
        $pullTest .= '<td>' . $rowPull->val . '</td>';
        $pullTest .= '<td>' . $rowPull->tipo . '</td>';}
    }else{
        $pullTest='';
    }
}else{
        $paretos[0]=0;
        $paretos[1]=0;
        $paretos[2]=0;
        $tableftq .= '<tr>';
        $tableftq .= '<td>' . '0' . '</td>';
        $tableftq .= '<td>' . '0' . '</td>';
        $tableftq .= '</tr>';
        $regftq['no se encontro']=0;
        $pullTest='';

    }
}


            return response()->json([
                'pullTest' => $pullTest,
                'paretos' => $paretos,
                'tableftq' => $tableftq,
                'tableContent' => $tableContent,
                'tableReg' => $tableReg,
            ]);

    }}

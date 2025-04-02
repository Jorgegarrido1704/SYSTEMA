<?php

namespace App\Http\Controllers;

use App\Models\regPar;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class AdminSupControlloer extends Controller
{
    //
    public function index_admin(Request $request){
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
    public function datosOrdenes(Request $request){
        try {
            $buscarWo = $request->input('buscarWo');
            $datosWo =$datosPass=$pnReg=$regftq=$paretos= [];
            $tableContent=$tableReg = $tableftq=$pullTest='';
            $i=$ok=$nog=0;



            $buscar = DB::table('registroparcial')
            ->orWhere('pn', 'like', $buscarWo.'%')
            ->orWhere('wo', 'like','%'.$buscarWo.'%')
            ->orWhere('pn', 'like', '%'.$buscarWo)
            ->get();

$i = 0; // Initialize $i if it's not initialized

foreach ($buscar as $row) {
    // Correct form ID concatenation
    $tableContent .= '<tr><form method="GET" id="form' . $i . '" name="form[]">';
    $tableContent .= '<td>' . $row->pn . '</td>';
    $tableContent .= '<td>' . $row->wo . '</td>';
    $tableContent .= '<td><input type="checkbox" id="check' . $i . '" name="check[]" ></td>';
    $tableContent .= '<td><input type="number" min="0" id="cortPar' . $i . '" name="cortPar[]" value="' . $row->cortPar . '" required ></td>';
    $tableContent .= '<td><input type="number" min="0" id="libePar' . $i . '" name="libePar[]" value="' . $row->libePar . '" required ></td>';
    $tableContent .= '<td><input type="number" min="0" id="ensaPar' . $i . '" name="ensaPar[]" value="' . $row->ensaPar . '" required ></td>';
    $tableContent .= '<td><input type="number" min="0" id="loomPar' . $i . '" name="loomPar[]" value="' . $row->loomPar . '" required ></td>';
    $tableContent .= '<td><input type="number" min="0" id="preCalidad' . $i . '" name="preCalidad[]" value="' . $row->preCalidad . '" required ></td>';
    $tableContent .= '<td><input type="number" min="0" id="testPar' . $i . '" name="testPar[]" value="' . $row->testPar . '" required ></td>';
    $tableContent .= '<td><input type="number" min="0" id="embPar' . $i . '" name="embPar[]" value="' . $row->embPar . '" required ></td>';
    $tableContent .= '<td><input type="number" min="0" id="eng' . $i . '" name="eng[]" value="' . $row->eng . '" required ></td>';
    $tableContent .= '<td><input type="hidden" id="wo' . $i . '" name="wo[]" value="' . $row->wo . '" >
    <input type="button" name="enviar" value="Guardar" onclick="submitForm(' . $i . ')" > </form></td>';
    $tableContent .= '</tr>';
    $pnReg[$i] = $row->pn;
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

    }
    catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }

}

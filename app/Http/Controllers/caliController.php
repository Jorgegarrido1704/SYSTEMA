<?php

namespace App\Http\Controllers;
use App\Models\Maintanance;
use App\Models\material;
use App\Models\Paros;
use App\Models\calidadRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Mail\Mailables;
use Illuminate\Support\Facades\Mail;
use App\Models\timeDead;
use App\Models\regParTime;
use App\Models\listaCalidad;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class caliController extends generalController
{
    public function __invoke(){
        $value = session('user');
        $cat = session('categoria');
        if(empty($value)){
            return redirect('/');
        }else{
                $buscarcalidad=DB::table("calidad")->get();
                $i=0;
                $calidad=[];
                $fallas=[];
                foreach($buscarcalidad as $rowcalidad){
                    $calidad[$i][0]=$rowcalidad->np;
                    $calidad[$i][1]=$rowcalidad->client;
                    $calidad[$i][2]=$rowcalidad->wo;
                    $calidad[$i][3]=$rowcalidad->po;
                    $calidad[$i][4]=$rowcalidad->qty;
                    $calidad[$i][5]=$rowcalidad->parcial;
                    $calidad[$i][6]=$rowcalidad->id;
                    $calidad[$i][7]=$rowcalidad->info;
                    $i++;

                }

                $timesReg = strtotime(date("d-m-Y 00:00"))-86400;
                /*$registros=[];
                $i=0;
                $buscReg=DB::table('regsitrocalidad')->orderBy('id','DESC')->limit(250)->get();
                foreach($buscReg as $rowReg){
                    $registros[$i][0]=$rowReg->fecha;
                        $registros[$i][1]=$rowReg->client;
                        $registros[$i][2]=$rowReg->pn;
                        $registros[$i][3]=$rowReg->resto;
                        $registros[$i][4]=$rowReg->codigo;
                        $registros[$i][5]=$rowReg->prueba;
                        $registros[$i][6]=$rowReg->Responsable;
                        $i++;
                }
                $i=0;
                $buscFallas=DB::table('timedead')->where('area','Calidad')->where('timeFin','=','No Aun')->orderBy('id','DESC')->get();
                foreach($buscFallas as $Fa){
                    $fallas[$i][0]=$Fa->id;
                    $fallas[$i][1]=$Fa->fecha;
                    $fallas[$i][2]=$Fa->cliente;
                    $fallas[$i][3]=$Fa->np;
                    $fallas[$i][4]=$Fa->codigo;
                    $fallas[$i][5]=$Fa->defecto;
                    $fallas[$i][6]=$Fa->respArea;
                    $i++;
                }

                $Generalcontroller=new generalController;
                $generalresult=$Generalcontroller->__invoke();
                $week=$generalresult->getData()['week'];
                $assit=$generalresult->getData()['assit'];
                $paros=$generalresult->getData()['paros'];
                $desviations=$generalresult->getData()['desviations'];
                $materials=$generalresult->getData()['materials'];*/
                    //se quitaron
                //'fallas'=>$fallas,'registros'=>$registros,'week'=>$week,'assit'=>$assit,'paros'=>$paros,'desviations'=>$desviations,'materials'=>$materials
                return view('cali',['cat'=>$cat,'value'=>$value,'calidad'=>$calidad]);
        }

     }
    public function baja(Request $request){
        $calicontroller = new generalController();
        $caliresult = $calicontroller->__invoke();
        $value = $caliresult->getData()['value'];
       /* $week = $caliresult->getData()['week'];
        $assit = $caliresult->getData()['assit'];*/
        $cat=$caliresult->getData()['cat'];
        $id=$request->input('id');
            if($id==''){
                return redirect()->route('calidad');
            }else{
        $buscarInfo=DB::table('calidad')->where('id','=',$id)->get();
        foreach($buscarInfo as $rowInfo){
            $client=$rowInfo->client;
            $pn=$rowInfo->np;
            $wo=$rowInfo->wo;
            $info=$rowInfo->info;
            $qty=$rowInfo->qty;
        }

        return view('cali',['value'=>$value,'id'=>$id,
                    'client'=>$client,
                    'pn'=>$pn,
                    'wo'=>$wo,
                    'qty'=>$qty,
                    'info'=>$info,
                    //'week'=>$week,
                    //'assit'=>$assit,
                    'cat'=>$cat
                ]);
            }

    }
    public function saveData(Request $request){
        $cat=session('categoria');
        if($cat=='cali'){
            function deadTime($cod1,$today,$client,$pn,$info,$value,$loom,$corteLibe,$ensa){
                if(strpos($cod1, ';') ) {
                    $cod = explode(';', $cod1);
                    for ($i = 0; $i < count($cod); $i++) {
                        $regTimes= new timedead;
                $regTimes->fecha=$today;
                $regTimes->cliente=$client;
                $regTimes->np=$pn;
                $regTimes->codigo=$info;
                $regTimes->defecto=$cod[$i];
                $regTimes->timeIni=strtotime($today);
                $regTimes->whoDet=$value;
                if(in_array($cod[$i],$loom)){
                    $regTimes->respArea="Jesus Zamarripa";
                }else if(in_array($cod[$i],$corteLibe)){
                    $regTimes->respArea="Juan Olaes";
                }else if(in_array($cod[$i],$ensa)){
                    $regTimes->respArea="David Villalpando";
                }else{  $regTimes->respArea="";      }
                $regTimes->area="Calidad";
                $regTimes->save();     }
                }  else{
                $regTimes= new timedead;
                $regTimes->fecha=$today;
                $regTimes->cliente=$client;
                $regTimes->np=$pn;
                $regTimes->codigo=$info;
                $regTimes->defecto=$cod1;
                $regTimes->timeIni=strtotime($today);
                $regTimes->whoDet=$value;
                if(in_array($cod1,$loom)){
                    $regTimes->respArea="Jesus Zamarripa";
                }else if(in_array($cod1,$corteLibe)){
                    $regTimes->respArea="Juan Olaes";
                }else if(in_array($cod1,$ensa)){
                    $regTimes->respArea="David Villalpando";
                }else{  $regTimes->respArea="";      }
                $regTimes->area="Calidad";
                $regTimes->save();}
            }




        $corteLibe=['Impresion de cable incorrecta','Cable sobrante','Strip fuera de tolerancia','Terminal mal aplicada',
        'Crimp no centrado',
        'Cable con exceso de strip',
        'Cable con strip insuficiente',
        'Filamentos fuera de la terminal',
        'Filamentos trozados',
        'Aislante-InsulaciÃ³n perforada',
        'Pestanas del cobre agarrando forro',
        'Sello trozado',
        'Terminal con exceso de presiÃ³n',
        'Terminal doblada',
        'Terminal no abraza forro',
        'Terminal perforando forro',
        'Terminal quebrada',
        'Terminal sin presion',
        'Empalme Incorrecto',
        'Diodos invertidos',
        'Tubo termocontractil mal colocado',
        'Exceso de soldadura',
        'Soldadura puenteada',
        'Escasez de soldadura'
                ];
                $loom=['Encintado defectuoso de cables y-o de looming',
                'Looming Corrugado danado',
                'Looming Corrugado mal colocado ',
                'Braid mal colocado y-o danado',
                'Etiquetas invertidas'
                ];
                $ensa=['Cables revueltos en los lotes',
                'Medidas fuera de tolerancias',
                'Componente Danado',
                'Componente Incorrecto',
                'Componente Faltante',
                'Ensamble Incorrecto',
                'Terminal o conector mal asentado',
                'Salidas invertidas',
                'Componentes sin atar al arnes',
                'Cables Invertidos en el conector',
                ' no tiene Continuidad Electrica',
                'Arnes con cortocircuito'
                ];
                $personal=[
                    ['2001','Jesus  Zamarripa Rodriguez','Lider Producción','Ensamble','DVillalpando'],
            ['2002','Rosario Hernandez Lopez','Inspector Calidad','','EVillegas'],
            ['2003','Andrea Pacheco','Supervisor Almacen','','JGUILLEN'],
            ['2004','Fabiola  Alonso','Inspector Calidad','','EVillegas'],
            ['2005','Martha Carpio','Operador C','Liberación','AGonzalez'],
            ['2006','Maria Alejandra Gaona Alvarado','Operador A','Ensamble','SGalvan'],
            ['2007','Adan Bravo Martinez','Operador A','Liberación','AGonzalez'],
            ['2008','Lidia Susana Rico Hernadez','Operador D','Ensamble','JSanchez'],
            ['2009','Ma Estela Gaona Alvarado','Planeador Producción','','MVALADEZ'],
            ['2010','Leonardo Rafael Mireles','Supervisor de embarque','','FGOMEZ'],
            ['2013','Fernando Martin Segovia','Aux Lider','Corte','COlvera'],
            ['2014','Salvador Galvan Davila','Lider Producción','Ensamble','DVillalpando'],
            ['2015','Maria Esther Mandujano ','Aux Lider','Ensamble','JSanchez'],
            ['2016','Jose Manuel Zacarias Jimenez','Operador A','Ensamble','JZamarripa'],
            ['2017','Jennifer Alejandra Gomez','Operador C','Liberación','AGonzalez'],
            ['2018','David Salvador Rodriguez','Operador D','Ensamble','JZamarripa'],
            ['2019','Efrain Vera Villegas','Supervisor de calidad','','EMedina'],
            ['2020','Laura Alejandra Contreras','Operador A','Ensamble','JZamarripa'],
            ['2021','Rosalba Ramirez Oliva','Operador C','Liberación','AGonzalez'],
            ['2022','Maria Berenice Serrano ','Operador C','Liberación','AGonzalez'],
            ['2023','Didier Maldonado Lopez','Aux Almacen B','','APacheco'],
            ['2024','Aury Cecilia Aguilar Castillo','Tec Pruebas','','EMedina'],
            ['2025','Maria Magdalena Villanueva','Operador C','Ensamble','JSanchez'],
            ['2026','Samantha Montserrat Aranda','Operador D','Ensamble','JSanchez'],
            ['2030','Jose Luis Ruiz Valdivia','Tec Pruebas','','EMedina'],
            ['2031','Jessica Lizbeth Sanchez','Lider Producción','Ensamble','DVillalpando'],
            ['2032','Martha Aranda Palacios','Operador A','Ensamble','SGalvan'],
            ['2033','Alma Delia Perez Martin','Operador B','Ensamble','JSanchez'],
            ['2034','Jessica Sarahi Torres P','Operador C','Ensamble','JSanchez'],
            ['2035','Neri Leticia Cervantes ','Operador B','Ensamble','JSanchez'],
            ['2037','Christian De Jesus Olvera','Lider Producción','Corte','JOlaes'],
            ['2038','Beatriz Elena Regalado ','Operador B','Ensamble','JZamarripa'],
            ['2041','Edward Medina Flores','Ing Calidad','','LRAMOS'],
            ['2042','Martha Evelia Trujillo ','Operador C','Ensamble','JZamarripa'],
            ['2043','Mayra Daniela Montes P','Operador C','Liberación','AGonzalez'],
            ['2044','Sanjuana Estela Mosqueda','Operador C','Ensamble','SCastro'],
            ['2046','Ma. De los Angeles   Flores Ortiz','Operador C','Ensamble','JSanchez'],
            ['2047','Maricela Alferes Montes','Intendencia B','','PAGUILAR'],
            ['2049','Jessica Estefania Galvan','Operador C','Ensamble','JSanchez'],
            ['2051','Sergio Vera Castillo','Inspector Calidad','','EVillegas'],
            ['2052','Erick Nuñez Vazquez','Aux Almacén A','','APacheco'],
            ['2054','Cristina Jacquelin Godinez Ortiz','Operador C','Ensamble','JZamarripa'],
            ['2056','Sobeida Amaya Mercado','Operador D','Ensamble','SCastro'],
            ['2057','Daniela Goretti Rocha C','Aux Calidad','','EMedina'],
            ['2058','Maria Barbara Castillo ','Operador C','Ensamble','JSanchez'],
            ['2060','Marisol Anahi Perez M','Aux Almacen B','','APacheco'],
            ['2062','Alejandro Daniel Robledo','Operador C','Corte','COlvera'],
            ['2065','Brenda Cecilia Galvan S','Operador D','Ensamble','SCastro'],
            ['2066','Patricia Castro Gomez','Operador C','Ensamble','SGalvan'],
            ['2067','Mariana Alferes Montes','Intendencia A','','PAGUILAR'],
            ['2068','Noemi Guadalupe Rangel ','Operador D','Liberación','AGonzalez'],
            ['2071','Luis  Segoviano','Tec Mantinimiento D','','JCERVANTES'],
            ['2073','Cinthya Veronica Galvan','Operador D','Ensamble','SGalvan'],
            ['2074','Yahir Alejandro Chacon ','Operador C','Ensamble','JZamarripa'],
            ['2075','Fatima De La Luz Garcia','Operador D','Ensamble','SGalvan'],
            ['2077','Marcos Enrique Delgado ','Operador D','Liberación','AGonzalez'],
            ['2079','Jesus Ernesto Castro R','Inspector Calidad','','EVillegas'],
            ['2080','Francisco Javier Melend','Operador C','Liberación','AGonzalez'],
            ['2081','Claudia Ivett Gonzalez ','Operador D','Liberación','AGonzalez'],
            ['2082','Annel Ivonne Castro E','Operador D','Ensamble','SCastro'],
            ['2085','Maria Guadalupe Valdes ','Operador C','Ensamble','JSanchez'],
            ['2087','Maria Teresa Jimenez R','Operador D','Liberación','AGonzalez'],
            ['2089','Silvia Edith Negrete M','Operador D','Ensamble','SCastro'],
            ['2090','Milagros Jazmin Sanchez','Operador D','Ensamble','JSanchez'],
            ['2091','Jhoana Jocelyn Lopez J','Tec procesos Calidad','','EMedina'],
            ['2098','Fernando Moises Barajas','Operador C','Corte','COlvera'],
            ['2101','Jorge Arturo Garrido M','Ingeniero','','JCERVERA'],
            ['2106','Luis Adrian Rodriguez A','Operador D','Corte','COlvera'],
            ['2108','Carmen Patricia Vera C','Operador D','Liberación','AGonzalez'],
            ['2111','Esteban Marajim Vazquez','Operador D','Corte','COlvera'],
            ['2112','Karla Jacqueline Martin','Operador D','Liberación','AGonzalez'],
            ['2113','Martin Baez Aguilar','Seguridad B','','JCERVANTES'],
            ['2114','Ma  Del Rosario','Operador D','Ensamble','JSanchez'],
            ['2116','Mario Alberto Delgado C','Seguridad B','','JCERVANTES'],
            ['2117','Gerardo Calvillo Martin','Seguridad B','','JCERVANTES'],
            ['2118','Daniela Karen Elizabeth Ojeda Ramirez','Inspector Calidad','','Evillegas'],
            ['2119','Sofia Sanchez Amezquita','Operador D','Ensamble','SCastro'],
            ['2120','Ana Ivette Lira Perez','Operador D','Ensamble','JSanchez'],
            ['2123','Saul Castro Ordaz','Lider Producción','Ensamble','DVillalpando'],
            ['2125','Fatima Yaireth Suarez Flores','Aux Comercio','','RFANDIÑO'],
            ['2127','Jonathan Ismael Falcon ','Tec Mantinimiento D','','AGonzalez'],
            ['2128','Jared Alejandro Moreno ','Tec OP B','','JGUILLEN'],
            ['2130','Indihra Paulina Martine','Aux Comercio','','RFANDIÑO'],
            ['2132','Maricruz Alonso Torres','Operador A','Ensamble','SGalvan'],
            ['2133','Sofia Alonso Torres','Operador D','Liberación','AGonzalez'],
            ['2134','Cecilia Del Rocio Rangel B','Operador C','Ensamble','JZamarripa'],
            ['2136','Cassandra Elizabeth Monjaraz Reyna','Operador C','Ensamble','JSanchez'],
            ['2137','Graciela Lopez Cervera','Operador C','Liberación','AGonzalez'],
            ['2138','Blanca Esthela Carpio R','Operador C','Ensamble','JZamarripa'],
            ['2139','Lizbeth Natali Sanchez ','Operador C','Ensamble','SGalvan'],
            ['2142','Marintia Fernanda Lugo ','Operador D','Liberación','AGonzalez'],
            ['2144','Nancy Noelia Aldana Rios','Ingeniero','','JCERVERA'],
            ['2145','Martin Aléman Gutierrez','Coordinador de sist de calidad','','LRAMOS'],
            ['2146','Javier Santos Cervantes','Supervisor Mantenimiento','','JGUILLEN'],
            ['2147','Jose de Jesus Cervera Lopez','Sup Ingeniería','','JGUILLEN'],
            ['2150','Rocio Fandiño','Coordinadora de immex','','JGUILLEN'],
            ['2152','Francisco  Gomez','Supervisor de embarque','','RFANDIÑO'],
            ['2153','Angel Gonzalez','Lider de producción','Liberación','JOlaes'],
            ['2157','Juan  Olaes','Sup de producción','Corte y Liberación','Jguillén'],
            ['2158','Edwin  Ortega','Contralor financiero','','APotter'],
            ['2159','Jesus Pereida Ordaz','Ingeniero','','JCERVANTES'],
            ['2160','Valeria Fernanda Pichardo','Compras','','JGUILLEN'],
            ['2161','Luis Alberto Ramos Cedeño','Gte Calidad','','GUmhoefer'],
            ['2162','Miriam Vanessa Reyes Araujo','Ctas por pagar','','EORTEGA'],
            ['2164','Jose Carlos Rodriguez G','Ingeniero','','JCERVERA'],
            ['2165','Paola Valeria Silva Vega','Ingeniero','','JCERVERA'],
            ['2166','Juliet Marlenne Torres ','Enfermera','','PAGUILAR'],
            ['2167','Mario Enrique Valadez V','Servicio al cliente','','JGUILLEN'],
            ['2169','David Villalpando Rodriguez','Sup de producción','Ensamble','Jguillén'],
            ['2170','Ana Paola Aguilar Hernandez','Gte RH','','JSchmit'],
            ['2171','Robert Melvin Smith','Dir de negocios','','JElliot'],
            ['2172','Jose Roberto Olivares A','Operador C','Liberación','AGonzalez'],
            ['2174','Maria De Los Angeles Bañuelos','Analista RH','','PAGUILAR'],
            ['2175','Juan Jose Guillen Miranda','Gte Operaciones','Operaciones','JElliot'],
            ['2181','Rodrigo  Ponce A','Practicante','','JCervantes'],
            ['2177','Juan Antonio ','Operador D','Ensamble','SGalvan'],
            ['2178','Juan Francisco ','Operador D','Liberación','AGonzalez'],
            ['2143','Carlos Samuel ','Operador D','Ensamble','JZamarripa'],
            ['2184','Yair ','Operador D','Corte','COlvera'],
            ['2183','Jonathan Ismael ','Operador D','Ensamble','SGalvan'],
            ['2185','Valeria ','Operador D','Ensamble','SGalvan'],
            ['2186','SanJuana ','Operador D','Ensamble','SGalvan'],
            ['2187','Sebastian ','Lider Mantenimiento','','JCervantes'],
            ['2188','Dafne ','Practicante','','VPichardo'],
            ['2180','Brandon ','Practicante','','JCervera'],
            ['2182','Christian Alejandro ','Practicante','','JCervera'],
                ];
                    $val = session('user');
                    $value=str($val);
                    $diff=0;
                    $today=date('d-m-Y H:i');
                    $info=$request->input("infoCal");
                    $pn=$request->input("pn_cali");
                    $client=$request->input("clienteErr");
                    $ok=$request->input('ok');
                    $nok=$request->input('nok');
                    $cod1=$request->input('rest_code1');
                    $cod2=$request->input('rest_code2');
                    $cod3=$request->input('rest_code3');
                    $cod4=$request->input('rest_code4');
                    $cod5=$request->input('rest_code5');
                    $cant1=$request->input('1');
                    $cant2=$request->input('2');
                    $cant3=$request->input('3');
                    $cant4=$request->input('4');
                    $cant5=$request->input('5');
                    $serial=$request->input('serial');
                    $responsable1=$request->input('responsable1');
                    $responsable2=$request->input('responsable2');
                    $responsable3=$request->input('responsable3');
                    $responsable4=$request->input('responsable4');
                    $responsable5=$request->input('responsable5');
                    if(strpos($responsable1,',')){
                        $responsable1=str_replace(',',';',$responsable1);
                    }
                    if(strpos($responsable1,',')){
                        $responsable1=str_replace(',',';',$responsable1);
                    }
                    if(strpos($responsable2,',')){
                        $responsable2=str_replace(',',';',$responsable2);
                    }
                    if(strpos($responsable3,',')){
                        $responsable3=str_replace(',',';',$responsable3);
                    }
                    if(strpos($responsable4,',')){
                        $responsable4=str_replace(',',';',$responsable4);
                    }
                    if(strpos($responsable5,',')){
                        $responsable5=str_replace(',',';',$responsable5);
                    }
                    if(substr($serial,0,2)=='0-0'){
                        $ini='0-0';
                        $serial = str_replace('0-0', '', $serial);
                        $serial = (int)$serial;

                    }else if(substr($serial,0,1)=='0-') {
                    $serial = str_replace('0-', '', $serial);
                    $serial = (int)$serial;
                    $ini='0-';}
                    $busquedainfo=DB::table('calidad')->select('qty','wo')->where('info',$info)->first();

                    $wo=$busquedainfo->wo;

                    $qty_cal=$busquedainfo->qty;
                    $total=$ok+$nok;
                    if($total>100){
                        return redirect('calidad')->with('response', "No update you need to update 100 or less");
                    }

                    $totalCant=$cant1+$cant2+$cant3+$cant4+$cant5;
                    if($total<=$qty_cal and $totalCant==$nok){
                        //insert ok
                        for($i=0;$i<$ok;$i++){

                        $ok_reg= new calidadRegistro;
                        $ok_reg->fecha=$today;
                        $ok_reg->client=$client;
                        $ok_reg->pn=$pn;
                        $ok_reg->info=$info;
                        $ok_reg->resto=1;
                        $ok_reg->codigo="TODO BIEN";
                        if(!empty($serial)){
                            $ok_reg->prueba=$serial;
                            $serial++;
                        }else{
                        $ok_reg->prueba="";}
                        $ok_reg->usuario=$value;
                        $ok_reg->save();}

                        if(!empty($cant1)){
                            foreach($personal as $key=>$var){
                                if($responsable1==$personal[$key][0]){
                                    $responsable1=($personal[$key][1]);
                                    break;     }   }
                                $nok_reg= new calidadRegistro;
                                $nok_reg->fecha=$today;
                                $nok_reg->client=$client;
                                $nok_reg->pn=$pn;
                                $nok_reg->info=$info;
                                $nok_reg->resto=1;
                                $nok_reg->codigo=$cod1;
                                if(!empty($serial)){
                                    $nok_reg->prueba="0-0".$serial;
                                    $serial++;
                                }else{
                                $nok_reg->prueba="";}
                                $nok_reg->usuario=$value;
                                $nok_reg->Responsable=$responsable1;
                                $nok_reg->save();
                                deadTime($cod1,$today,$client,$pn,$info,$value,$loom,$corteLibe,$ensa);
                    }
                        if(!empty($cant2)){
                            foreach($personal as $key=>$var){
                                if($responsable2==$personal[$key][0]){
                                    $responsable2=($personal[$key][1]);
                                    break;     }   }

                                $nok_reg= new calidadRegistro;
                                $nok_reg->fecha=$today;
                                $nok_reg->client=$client;
                                $nok_reg->pn=$pn;
                                $nok_reg->info=$info;
                                $nok_reg->resto=1;
                                $nok_reg->codigo=$cod2;
                                if(!empty($serial)){
                                    $nok_reg->prueba="0-0".$serial;
                                    $serial++;
                                }else{
                                $nok_reg->prueba="";}
                                $nok_reg->usuario=$value;
                                $nok_reg->Responsable=$responsable2;
                                $nok_reg->save();
                               // deadTime($cod2,$today,$client,$pn,$info,$value,$loom,$corteLibe,$ensa);
                        }
                        if(!empty($cant3)){
                            foreach($personal as $key=>$var){
                                if($responsable3==$personal[$key][0]){
                                    $responsable3=($personal[$key][1]);
                                    break;     }   }
                            $nok_reg= new calidadRegistro;
                            $nok_reg->fecha=$today;
                            $nok_reg->client=$client;
                            $nok_reg->pn=$pn;
                            $nok_reg->info=$info;
                            $nok_reg->resto=1;
                            $nok_reg->codigo=$cod3;
                            if(!empty($serial)){
                                $nok_reg->prueba="0-0".$serial;
                                $serial++;
                            }else{
                            $nok_reg->prueba="";}
                            $nok_reg->usuario=$value;
                            $nok_reg->Responsable=$responsable3;
                            $nok_reg->save();
                            //deadTime($cod3,$today,$client,$pn,$info,$value,$loom,$corteLibe,$ensa);
                    }
                    if(!empty($cant4)){
                        foreach($personal as $key=>$var){
                            if($responsable4==$personal[$key][0]){
                                $responsable4=($personal[$key][1]);
                                break;     }   }
                        $nok_reg= new calidadRegistro;
                        $nok_reg->fecha=$today;
                        $nok_reg->client=$client;
                        $nok_reg->pn=$pn;
                        $nok_reg->info=$info;
                        $nok_reg->resto=1;
                        $nok_reg->codigo=$cod4;
                        if(!empty($serial)){
                            $nok_reg->prueba="0-0".$serial;
                            $serial++;
                        }else{
                        $nok_reg->prueba="";}
                        $nok_reg->usuario=$value;
                        $nok_reg->Responsable=$responsable4;
                        $nok_reg->save();
                        //deadTime($cod4,$today,$client,$pn,$info,$value,$loom,$corteLibe,$ensa);
                }
                if(!empty($cant5)){
                    foreach($personal as $key=>$var){
                        if($responsable5==$personal[$key][0]){
                            $responsable5=($personal[$key][1]);
                            break;     }   }
                    $nok_reg= new calidadRegistro;
                    $nok_reg->fecha=$today;
                    $nok_reg->client=$client;
                    $nok_reg->pn=$pn;
                    $nok_reg->info=$info;
                    $nok_reg->resto=1;
                    $nok_reg->codigo=$cod5;
                    if(!empty($serial)){
                        $nok_reg->prueba="0-0".$serial;
                        $serial++;
                    }else{
                    $nok_reg->prueba="";}
                    $nok_reg->usuario=$value;
                    $nok_reg->Responsable=$responsable5;
                    $nok_reg->save();
                    //deadTime($cod5,$today,$client,$pn,$info,$value,$loom,$corteLibe,$ensa);
            }

                        $rest=$qty_cal - ($ok+$nok);
                        $buscarPartial=DB::table('registroparcial')->where('codeBar','=',$info)->get();
                    foreach($buscarPartial as $row){
                        $test=$row->testPar;
                        $emba=$row->embPar;
                    }
                    $upPartial=DB::table('registroparcial')->where('codeBar','=',$info)->update(['testPar'=>$test-$total,'embPar'=>$emba+$total]);
                    $regTimePar= new regParTime;
                    $regTimePar->codeBar=$info;
                    $regTimePar->qtyPar=$total;
                    $regTimePar->area=$value;
                    $regTimePar->fechaReg=$today;
                    $regTimePar->save();


                        if($rest>0){
                        $updacalidad=DB::table('calidad')->where("info",$info)->update(['qty'=>$rest]);
                        $updateToRegistro=DB::table('registro')->where("info",$info)->update(["paro"=>"Parcial prueba electrica"]);
                        return redirect()->route('calidad');
                        }else if($rest<=0){
                            $todays=(date('d-m-Y H:i'));
                            $buscarReg=DB::table('registro')->where("info",$info)->first();
                            $rev=$buscarReg->rev;
                            $np=$buscarReg->NumPart;
                            if(substr($rev,0,4)=='PPAP' || substr($rev,0,4)=='PRIM'){
                                $delteCalidad=DB::table('calidad')->where("info",$info)->delete();
                                $updatetime=DB::table('timesharn')->where('bar',$info)->update(['qlyF'=>$todays]);
                                $tiempoUp=DB::table('tiempos')->where('info',$info)->update(['calidad'=>$todays]);
                                $updateToEmbarque=DB::table('registro')->where("info",$info)->update(["count"=>18,"donde"=>'En espera de ingenieria',"paro"=>""]);
                                            return redirect()->route('calidad');
                        }else{
                            $delteCalidad=DB::table('calidad')->where("info",$info)->delete();
                            $updatetime=DB::table('timesharn')->where('bar',$info)->update(['cutF'=>$todays]);
                            $tiempoUp=DB::table('tiempos')->where('info',$info)->update(['calidad'=>$todays]);
                            $updateToEmbarque=DB::table('registro')->where("info",$info)->update(["count"=>12,"donde"=>'En espera de embarque',"paro"=>""]);
                            return redirect()->route('calidad');
                        }
                        }
                    }else{
                        return redirect()->route('calidad');
                    }

                }else{
                    return redirect()->route('calidad');
                }

    }

    public function buscarcodigo(Request $request)
    {
            $codig1 = $request->input('codigo1');
            $cod1=[];
        $restCodig="";
        if(strpos($codig1, ',') ) {
            $cod1=explode(",",$codig1);
            for($i=0;$i<count($cod1);$i++){
                $rest = DB::table('clavecali')->select('defecto')->where('clave', $cod1[$i])->first();
                if($i<count($cod1)-1){

                    $restCodig = $restCodig.$rest->defecto.';';
                }else{
                    $restCodig = $restCodig.$rest->defecto;
                }


            }
            return response()->json($restCodig);
        }else{
            $buscar = DB::table('clavecali')->select('defecto')->where('clave', $codig1)->first();
            if($buscar->defecto != null){

                $restCodig = $buscar ;
            }
            return response()->json($restCodig);
        }




}
public function codigoCalidad(request $request){
    $codigo=$request->input('code-bar');
    if(strpos($codigo, "'") ) {
        $codigo = str_replace("'", "-", $codigo);
    }
    $resp="";
    $buscar= DB::table('registroparcial')->where('codeBar','=',$codigo)->first();
    if($buscar){
        $resp="PN: ".(string)$buscar->pn." WO: ".(string)$buscar->wo." ";
        if($buscar->cortPar){ $resp.=" Cutting: ".(string)$buscar->cortPar;        }
        if($buscar->libePar){ $resp.=" Terminals: ".(string)$buscar->libePar;    }
        if($buscar->ensaPar){ $resp.=" Assembly: ".(string)$buscar->ensaPar;     }
        if($buscar->preCalidad){$resp.=" PreQuality: ".(string)$buscar->preCalidad;}
        if($buscar->loomPar){  $resp.=" Looming: ".(string)$buscar->loomPar; }
        if($buscar->testPar){ $resp.=" Testing: ".(string)$buscar->testPar;    }
        if($buscar->embPar){ $resp.=" Shipping: ".(string)$buscar->embPar;   }
        if($buscar->eng){ $resp.=" Engineering: ".(string)$buscar->eng;     }
        return redirect('calidad')->with('response', $resp);
    }else{


            return redirect('calidad')->with('response', "Record not found");
    }

    }





    public function fetchDatacali(){
        $i =$backlock =0;
        $fecha = $info = $cliente = $pn = $cantidad =$serial=$issue= [];
        $tested = DB::select('SELECT * FROM regsitrocalidad ORDER BY id DESC');

        foreach ($tested as $registro) {
            $date = $registro->fecha;
            $code = $registro->info;
            $client = $registro->client;
            $part = $registro->pn;
            $cant = $registro->resto;
            $issue=$registro->codigo;
            $serial=$registro->prueba;
            $dates=strtotime($date);

            $fechacontrol = strtotime("01-01-2024 00:00");


            if($dates>$fechacontrol){


                    $fecha[] = $date;
                    $cliente[] = $client;
                    $pn[] = $part;
                    $cantidad[] = $cant;
                    $codigo[]=$issue;
                    $prueba[]=$serial;
                    $i++;
            }

            }
        $tableContent = '';
        for ($j = 0; $j < $i; $j++) {
            $tableContent .= '<tr>';
            $tableContent .= '<td>' . $fecha[$j] . '</td>';
            $tableContent .= '<td>' . $pn[$j] . '</td>';
            $tableContent .= '<td>' . $cliente[$j] . '</td>';
            $tableContent .= '<td>' . $cantidad[$j] . '</td>';
            $tableContent .= '<td>' . $codigo[$j] . '</td>';
            $tableContent .= '<td>' . $prueba[$j] . '</td>';
            $tableContent .= '</tr>';
        }
        $labels=['Planning','Cutting','Terminal'];
        $datos=[12,13,14];

        $saldo=0;


        // Create the updated data array
        $updatedData = [
            'tableContent' => $tableContent,
            'saldo'=> $saldo,
            'backlock'=> $backlock,
            'labels'=>$labels,
            'data'=>$datos

        ];

        // Return the updated data as JSON response
        return response()->json($updatedData,);
}

    public function mantCali(Request $request){

        $value=session('user');
        $equip=$request->input('equipo');
        $NomEq=$request->input('nom_equipo');
        $dano=$request->input('dano');
        $area=$request->input('area');
        $today = date('d-m-Y H:i');
        $maint= new Maintanance;
        $maint->fill([
            'fecha'=>$today,
            'equipo'=>$equip,
            'nombreEquipo'=>$NomEq,
            'dano'=>$dano,
            'quien'=>$value,
            'area'=>$area,
            'atiende'=>'Nadie aun',
            'trabajo'=>'',
            'Tiempo'=>'',
            'inimant'=>'',
            'finhora'=>''
        ]);
        if ($maint->save()) {
            return redirect('/calidad')->with('error', 'Failed to save data.');
        }

}
    public function matCali(Request $request){

            $value=session('user');
            $today=date("d-m-Y");

            for($i=0;$i<5;$i++){
                $cant[$i]=$request->input('cant'.$i);
                $articulo[$i]=$request->input('articulo'.$i);
                $notas[$i]=$request->input('notas_adicionales'.$i);
            }
            $i=0;
            $foliant=DB::select("SELECT folio FROM material ORDER BY id DESC LIMIT 1 ");
            $folio=$foliant[0]->folio;
            $folio+=1;
            while( $i<5){
                if($cant[$i]>0){
                $newarticulo=new material;
                $newarticulo->folio=$folio;
                $newarticulo->fecha=$today;
                $newarticulo->who=$value;
                $newarticulo->description=$articulo[$i];
                $newarticulo->note=$notas[$i];
                $newarticulo->qty=$cant[$i];
                $newarticulo->aprovadaComp="";
                $newarticulo->negada="";
                if(!empty($cant[$i])){
                $newarticulo->save();}
                }
                $i++;
            }

            return redirect('/calidad');

    }

    public function assiscali(Request $request){
            $names = $request->input('name');
            $dlu = $request->input('dlu');
            $dma = $request->input('dma');
            $dmi = $request->input('dmi');
            $dju = $request->input('dju');
            $dvi = $request->input('dvi');
            $dsa = $request->input('dsa');
            $ddo = $request->input('ddo');
            $dba = $request->input('dba');
            $dbp = $request->input('dbp');
            $dex = $request->input('dex');
            $id=$request->input('id');




            for ($i = 0; $i < count($names); $i++) {
                $name = $names[$i];
                $value_dlu = $dlu[$i];
                $value_dma = $dma[$i];
                $value_dmi = $dmi[$i];
                $value_dju = $dju[$i];
                $value_dvi = $dvi[$i];
                $value_dsa = $dsa[$i];
                $value_ddo = $ddo[$i];
                $value_dba = $dba[$i];
                $value_dbp = $dbp[$i];
                $value_dex = $dex[$i];

            $update=DB::table('assistence')->where('id','=',$id[$i])
                                            ->update(['lunes'=>$value_dlu,
                                            'martes'=>$value_dma,
                                            'miercoles'=>$value_dmi,
                                            'jueves'=>$value_dju,
                                            'viernes'=>$value_dvi,
                                            'sabado'=>$value_dsa,
                                            'domingo'=>$value_ddo ,
                                            'bonoAsistencia'=>$value_dba,'bonoPuntualidad'=>$value_dbp,'extras'=>$value_dex]);

            }
            return redirect('/calidad');


    }

    public function timesDead(Request $request){
        $id=$request->input('id');
        $timeNow=strtotime(date('d-m-Y H:i'));
        $buscar=DB::table('timedead')->where('id','=',$id)->first();
        $timeIni=$buscar->timeIni;
        $Totaltime=$timeNow-$timeIni;
        $total=round($Totaltime/60,2);
        $update=DB::table('timedead')->where('id','=',$id)->update(['timeFin'=>$timeNow,'total'=>$total]);
        return redirect('/calidad');
    }
    public function accepted(Request $request){
        $acpt=$request->input('acpt');
        $denied=$request->input('denied');
        $cat=session('categoria');
        $value = session('user');
        if(empty($acpt) && empty($denied)){
            $preorder=DB::table('registroparcial')->where('preCalidad','>',0)->get();

            return view('preorder',['value'=>$value,'cat'=>$cat,'preorder'=>$preorder]);
        }else if(!empty($acpt)){
            $preorder=DB::table('registroparcial')->where('id','=',$acpt)->first();
            $barcode=$preorder->codeBar;
            $pn=$preorder->pn;
            $wo=$preorder->wo;
            $qtycal=$preorder->preCalidad;
            $buscarCalida=DB::table('calidad')->where('info','=',$barcode)->first();
            if($buscarCalida){
                $qty=$buscarCalida->qty+$qtycal;
                $update=DB::table('calidad')->where('info','=',$barcode)->update(['qty'=>$qty]);
                $updateParcia=DB::table('registroparcial')->where('codeBar','=',$barcode)->update(['preCalidad'=>0,'testPar'=>$qty]);
                return redirect('/accepted');
            }else{
                $buscarIfno=DB::table('registro')->where('info','=',$barcode)->first();
                $newCalidad=new listaCalidad;
                $newCalidad->np=$pn;
                $newCalidad->client=$buscarIfno->cliente;
                $newCalidad->wo=$wo;
                $newCalidad->po=$buscarIfno->po;
                $newCalidad->info=$barcode;
                $newCalidad->qty=$qtycal;
                $newCalidad->parcial='SI';
                $newCalidad->save();
                $updateParcia=DB::table('registroparcial')->where('codeBar','=',$barcode)->update(['preCalidad'=>0,'testPar'=>$qtycal]);

                return redirect('/accepted');
            }

        }else if(!empty($denied)){
            $buscarParcial=DB::table('registroparcial')->where('id','=',$denied)->first();
            $preCalidad=$buscarParcial->preCalidad;
            $loomPar=$buscarParcial->loomPar;
            $sum=$loomPar+$preCalidad;
            $updateParcia=DB::table('registroparcial')->where('id','=',$denied)->update(['preCalidad'=>0,'loomPar'=>$sum]);
            $upCount=DB::table('registro')->where ('info','=',$barcode)->update(['count'=>'8','donde'=>'Denid by Quality']);
            return redirect('/accepted');
        }
    }

   /* public function fallasCalidad(Request $request){
        $cat=session('categoria');
        $value = session('user');
        $fallasId=$request->input('fallas');
        if(!empty($fallasId)){

        }else{
            $fallas=DB::table('registroparcial')->where('fallaCalidad','>',0)->first();



            return view('fallas',['value'=>$value,'cat'=>$cat]);
        }
    }*/



    public function excel_calidad(Request $request)
{
    $di = $request->input('di');//26-02-2025 00:00
    $df = $request->input('df');// 26-02-2025 23.59
    $di = substr($di, 0, 10);
    $df = substr($df, 0, 10);


    // Initialize the spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $t = 2; // Row counter for the data

    // Get the minimum and maximum id based on the date range
    $buscarinfo = DB::table('regsitrocalidad')
        ->select(DB::raw('MIN(id) as min'))
        ->where('fecha', 'LIKE', $di.'%') // Compare only the date part
        ->first();

    $buscarinfo2 = DB::table('regsitrocalidad')
        ->select(DB::raw('MAX(id) as max'))
        ->where('fecha', 'LIKE', $df.'%') // Compare only the date part
        ->first();
    if(!empty($buscarinfo)){
        $min = intval($buscarinfo->min);
    }else{
        $min=DB::table('regsitrocalidad')
        ->select('id')
        ->orderby('id', 'asc')
        ->first();
    }
    if(!empty($buscarinfo2)){
        $max = intval($buscarinfo2->max);
    }else{
        $min=DB::table('regsitrocalidad')
        ->select('id')
        ->orderby('id', 'desc')
        ->first();
    }



    $max = intval($buscarinfo2->max);
    $registro=[];

    // Set the headers for the spreadsheet
    $headers = [
        'A1' => 'Fecha',
        'B1' => 'Numero de parte',
        'C1' => 'Codigo',
        'D1' => 'Responsable',
        'E1' => 'Cuenta',
    ];

    // Loop through the headers and add them to the spreadsheet
    foreach ($headers as $cell => $header) {
        $sheet->setCellValue($cell, $header);
    }

    // Get the data within the id range
    $buscarinfo = DB::table('regsitrocalidad')
        ->whereBetween('id', [$min, $max]) // Compare only the id part (between $min, $min)
        ->orderBy('fecha', 'desc')
        ->orderBy('pn', 'desc')
        ->orderBy('codigo', 'desc')
        ->orderBy('Responsable', 'desc')
        ->get();

        foreach ($buscarinfo as $row) {
            if(!isset($registro[$row->fecha][$row->pn][$row->codigo][$row->Responsable])){
                $registro[$row->fecha][$row->pn][$row->codigo][$row->Responsable]=1;
            }else{
                $registro[$row->fecha][$row->pn][$row->codigo][$row->Responsable]++;
            }
            }

    // Loop through the records and add them to the spreadsheet
    foreach ($registro as $fecha => $pn) {
        foreach ($pn as $pn => $codigo) {
            foreach ($codigo as $codigo => $responsable) {
                foreach ($responsable as $responsable => $cuenta) {
                    $sheet->setCellValue('A'.$t, $fecha);
                    $sheet->setCellValue('B'.$t, $pn);
                    $sheet->setCellValue('C'.$t, $codigo);
                    $sheet->setCellValue('D'.$t, $responsable);
                    $sheet->setCellValue('E'.$t, $cuenta);
                    $t++;
                }
            }
        }
    }

    // Generate the Excel file and output it to the browser
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte de calidad del ' . $di . ' al ' . $df . '.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
}


}

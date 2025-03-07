@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="90">
 <script src="{{ asset('/dash/js/calidadReg.js')}}"></script>
<script>
    const modificacionsCali = @json(route('buscarcodigo'));
</script>
                    <!-- Content Row -->
        <div class="row">
                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h4 class="m-0 font-weight-bold text-primary">Ready for test</h4>

                                </div>
                                <!-- Percent section -->
                                <div class="card-body" style="overflow-y: auto; height: 760px;">
                                    @if(empty($id))


                                    <div class="table">
                                        <table style="width: 100%;">
                                            <thead  align="center" style=" color:aliceblue; background-color:rgb(253, 3, 3);">
                                                <th>Número de parte</th>
                                                <th>Cliente</th>
                                                <th>WO</th>

                                                <th>Cantidad</th>

                                                <th>Iniciar test</th>
                                            </thead>
                                            <tbody align="center">
                                                @foreach ($calidad as $cal)
                                                <tr>
                                                    <form action="{{route('baja')}}" method="POST" id="forma">
                                                        @csrf
                                    <td id="np">{{$cal[0]}}</td>
                                    <td id="client">{{$cal[1]}}</td>
                                    <td id="wo">{{$cal[2]}}</td>
                                        <td id="cant">{{$cal[4]}}</td>
                                    <td align="center">
                                            <input type="hidden" name="id" id="id" value="{{$cal[6]}}">
                                            <button type="submit" id="enviar">Calidad</button></td>
                                </form>
                                                    </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                        @else
                                        <div align="center">
                                            <div class="d-flex justify-content-center" align="center">
                                                <h3><span style="margin-right: 30px">Client:  {{$client}}</span> <span style="margin-right: 30px">Part Number: {{$pn}}</span> <span style="margin-right: 30px">Qty: {{$qty}}</span><span style="margin-right: 30px"> Wo: {{$wo}}<span style="margin-right: 30px"> </h3>
                                              </div>

                                                    <br>
                                                    <form action="{{route('saveData')}}" method="POST">
                                                        @csrf
                                        <div> <h4>OK<input type="number" style="width:80px;margin-right:80px;" name="ok" id="ok" value="0"  max="100" onchange="return checkOk()">      NOK<input type="number" style="width: 80px;margin-right:80px" name="nok" id="nok" value="0"  max="5" onchange="return checkOk()"></h4></div>
                                                         <script>
                                                            function checkOk(){
                                                            var checkOk=document.getElementById('ok').value;
                                                            var checkNok=document.getElementById('nok').value;
                                                            var total=parseInt(checkOk)+parseInt(checkNok);
                                                        if(total>{{$qty}}){
                                                            document.getElementById('ok').value=0;
                                                            document.getElementById('nok').value=0;

                                                        }
                                                            }
                                                         </script>
                                      <br> <br> <br>

                                        <div class="d-flex justify-content-center">
                                            <h4>Code #1
                                                <input type="text" style="width:80px;margin-right:10px;" name="codigo1" id="codigo1" onchange="buscarcodigo1()">
                                                <input type="text" style="width:280px;margin-right:80px;" name="rest_code1" id="rest_code1">
                                            <input type="hidden" style="width: 80px;margin-right:80px" name="1" id="1" value="0" >
                                            Responsable  <input type="text" style="width: 80px;margin-right:80px" name="responsable1" id="responsable1" value="0">
                                            High Rework<input type="checkbox" name="check1" id="check1" value="1">
                                            </h4>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <h4>Code #2
                                                <input type="text" style="width:80px;margin-right:10px;" name="codigo2" id="codigo2" onchange="buscarcodigo2()">
                                                <input type="text" style="width:280px;margin-right:80px;" name="rest_code2" id="rest_code2">
                                                <input type="hidden" style="width: 80px;margin-right:80px" name="2" id="2" value="0" >
                                                Responsable  <input type="text" style="width: 80px;margin-right:80px" name="responsable2" id="responsable2" value="0">
                                                High Rework<input type="checkbox" name="check2" id="check2" value="1">
                                            </h4>
                                        </div>

                                        <div>
                                            <h4>Code #3
                                                <input type="text" style="width:80px;margin-right:10px;" name="codigo3" id="codigo3" onchange="buscarcodigo3()">
                                                <input type="text" style="width:280px;margin-right:80px;" name="rest_code3" id="rest_code3">
                                                <input type="hidden" style="width: 80px;margin-right:80px" name="3" id="3" value="0" >
                                                Responsable  <input type="text" style="width: 80px;margin-right:80px" name="responsable3" id="responsable3" value="0">
                                                High Rework<input type="checkbox" name="check3" id="check3" value="1">
                                            </h4>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <h4>Code #4
                                                <input type="text" style="width:80px;margin-right:10px;" name="codigo4" id="codigo4" onchange="buscarcodigo4()">
                                                <input type="text" style="width:280px;margin-right:80px;" name="rest_code4" id="rest_code4">
                                                <input type="hidden" style="width: 80px;margin-right:80px" name="4" id="4" value="0" >
                                                Responsable  <input type="text" style="width: 80px;margin-right:80px" name="responsable4" id="responsable4" value="0">
                                                High Rework<input type="checkbox" name="check4" id="check4" value="1">
                                            </h4>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <h4>Code #5
                                                <input type="text" style="width:80px;margin-right:10px;" name="codigo5" id="codigo5" onchange="buscarcodigo5()">
                                                <input type="text" style="width:280px;margin-right:80px;" name="rest_code5" id="rest_code5">
                                                <input type="hidden" style="width: 80px;margin-right:80px" name="5" id="5"  value="0" >
                                                Responsable  <input type="text" style="width: 80px;margin-right:80px" name="responsable5" id="responsable5" value="0">
                                                High Rework<input type="checkbox" name="check5" id="check5" value="1">
                                            </h4>
                                        </div>


                                         <div><h4>Serial <input type="text" style="width: 180px" name="serial" id="serial"> </h4></div>
                                        <br>
                                        <input type="hidden" name="clienteErr" id="clienteErr" value="{{$client}}">
                                        <input type="hidden" name="infoCal" id="infoCal" value="{{$info}}">
                                        <input type="hidden" name="pn_cali" id="pn_cali" value="{{$pn}}">

                                         <input type="submit" name="enviar" id="enviar" value="Save">
                                        </div>
                                        <script>

                                                            function checkCant(){

                                                            var checkNok=document.getElementById('nok').value;
                                                                checkNok=parseInt(checkNok);
                                                            var check1=document.getElementById('1').value;
                                                            var check2=document.getElementById('2').value;
                                                            var check3=document.getElementById('3').value;
                                                            var check4=document.getElementById('4').value;
                                                            var check5=document.getElementById('5').value;
                                                                var total=parseInt(check1)+parseInt(check2)+parseInt(check3)+parseInt(check4)+parseInt(check5);

                                                        if(total>checkNok){
                                                            document.getElementById('1').value=0;
                                                            document.getElementById('2').value=0;
                                                            document.getElementById('3').value=0;
                                                            document.getElementById('4').value=0;
                                                            document.getElementById('5').value=0;

                                                        }
                                                            }

                                        </script>


                                        @endif

                              </div>
                            </div>
                           </div>

                        <!-- Second Column for WO by Area and Shipping Area -->
                        <div class="col-lg-6 mb-4">
                            <!-- WO by Area -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">where is the order </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Your WO by Area content here -->
                                    <div class="card-body" style="overflow-y: auto; height: 260px;">
                                        <div class="chart-pie pt-4 pb-2">
                                            <form action="{{ route('codigoCalidad') }}" method="POST">
                                                @csrf
                                                <div class="form-group">

                                                    <input type="text" class="form-control" name="code-bar" id="code-bar" placeholder="Enter code here">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                            <br>
                                            <h3 align="center">{{ session('response') }}</h3>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Area -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Shipping Area</h6>
                                </div>
                                                    <div class="card-body" style="overflow-y: auto; height: 360px;">
                                                                <form action="{{ route('excel_calidad')}}" method="GET" >

                                                                    <div class="form-group">
                                                                        <label for="text">De fecha:</label>
                                                                        <input type="date" class="form-control" name="de" id="de" required >
                                                                        <span id="errorMessage" style="color: red; display: none;">Weekends are not allowed!</span>
                                                                        <input type="hidden" name="di" id="di">

                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="text">A fecha:</label>
                                                                        <input type="date" class="form-control" name="a" id="a" required>
                                                                        <span id="errorMessage1" style="color: red; display: none;">Weekends are not allowed!</span>
                                                                        <input type="hidden" name="df" id="df">
                                                                    </div>
                                                                    <input type="submit" class="btn btn-primary"   value="Descargar Excel">
                                                                </form>
                                                                <script>
                                                                    document.getElementById('de').addEventListener('change', function() {
                                                                        var de = document.getElementById('de').value;
                                                                        const errorMessage = document.getElementById('errorMessage');
                                                                        const selectedDate = new Date(de);
                                                                            const dayOfWeek = selectedDate.getDay(); // 0 is Sunday, 6 is Saturday

                                                                            if (dayOfWeek === 6 || dayOfWeek === 5) {
                                                                                errorMessage.style.display = 'inline';
                                                                                alert('Weekends are not allowed!');
                                                                                document.getElementById('de').value='';
                                                                            } else {
                                                                                errorMessage.style.display = 'none';
                                                                        deA= de.slice(0,4);
                                                                        dem=de.slice(5,7);
                                                                        deD=de.slice(8,10);
                                                                        de=deD+"-"+dem+"-"+deA+" 00:00";
                                                                        document.getElementById('di').value=de;
                                                                        console.log('De fecha:', de);}
                                                                        });

                                                                    document.getElementById('a').addEventListener('change', function() {
                                                                        var a = document.getElementById('a').value;
                                                                        const errorMessage1 = document.getElementById('errorMessage1');
                                                                        const selectedDate1 = new Date(a);
                                                                            const dayOfWeek1 = selectedDate1.getDay(); // 0 is Sunday, 6 is Saturday

                                                                            if (dayOfWeek1 === 6 || dayOfWeek1 === 5) {
                                                                                errorMessage1.style.display = 'inline';
                                                                                alert('Weekends are not allowed!');
                                                                                document.getElementById('a').value='';
                                                                            } else {
                                                                                errorMessage1.style.display = 'none';

                                                                        aA= a.slice(0,4);
                                                                        am=a.slice(5,7);
                                                                        aD=a.slice(8,10);
                                                                        a=aD+"-"+am+"-"+aA+" 23:59";
                                                                        document.getElementById('df').value=a;
                                                                           console.log('A fecha:', a);}
                                                                        });
                                                                </script>

                                                    </div>
                                                </div>
                                        </div>
                             </div>
        <div class="row">
            <!--
               <div class="col-lg-6 mb-4">
                            <-- AREAS
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Assistence Request</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id='work'>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Equipo</th>
                                                <th>Trabajo solicitado</th>
                                                <th>Daño</th>
                                                <th>Area</th>
                                                <th>Guardar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <form action="{{ route('maintanance') }}" method="POST" name="registro" id="form">
                                                    @csrf
                                                    <td align="center">
                                                        <select name="equipo" id="equipo" onchange="updateSecondSelect()">
                                                            <option selected="selected"> </option>
                                                            <option value="Mantenimiento">Mantenimiento</option>
                                                            <option value="Ingenieria">Ingenieria</option>
                                                            <option value="Calidad">Calidad</option>
                                                            <option value="Almacen">Almacen</option>
                                                        </select>
                                                    </td>
                                                    <td align="center"><input type="text" name="nom_equipo" id="nom_equipo" required></td>
                                                    <td align="center"><select name="dano" id="dano"></select></td>
                                                    <td>
                                                        <select name="area" id="area" required>
                                                            <option value=""></option>
                                                            <option value="Tablero_Esther">Tablero Esther</option>
                                                            <option value="Tablero_Saul">Tableros Saul</option>
                                                            <option value="Tablero_David">Tableros Jessi</option>
                                                            <option value="Liberacion">Liberacion</option>
                                                            <option value="Corte">Corte</option>
                                                            <option value="Almacen">Alamacen</option>
                                                            <option value="Tableros_Brandon">Tableros Brandon</option>
                                                            <option value="Tableros_Alejandra">Tableros Alejenadra</option>
                                                            <option value="Tableros_Zamarripa">Tableros Zamarripa</option>
                                                            <option value="Loom">Loom</option>
                                                            <option value="Calidad">Calidad</option>
                                                        </select>
                                                    </td>
                                                    <td align="center"><button type="submit" value="save" id="guardar" name="guardar">Guardar</button></td>
                                                </form>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Assistence Proccess</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <table>
                                        <thead>
                                            <th>Fecha</th>
                                            <th>Team</th>
                                            <th>Trabajo</th>
                                            <th>Tipo de reparacion</th>
                                            <th>Status</th>
                                        </thead>
                                        <tbody>
                                            @if(!empty($paros))
                                                @foreach($paros as $paro)
                                                    <tr>
                                                        <td>{{$paro[0]}}</td>
                                                        <td>{{$paro[1]}}</td>
                                                        <td>{{$paro[2]}}</td>
                                                        <td>{{$paro[3]}}</td>
                                                        <td>{{$paro[4]}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Tiempo Muerto</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id='work'>
                                    <div align="center">
                                        <table>
                                            <thead>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Numero de parte</th>
                                                <th>Codigo de barra</th>
                                                <th>Codigo de defecto</th>
                                                <th>Resposable Area</th>
                                                <th>Detener Proceso</th>
                                            </thead>
                                            <tbody>
                                                @if(!empty($fallas))
                                                    @foreach($fallas as $falla)
                                                        <tr>
                                                            <td>{{$falla[1]}}</td>
                                                            <td>{{$falla[2]}}</td>
                                                            <td>{{$falla[3]}}</td>
                                                            <td>{{$falla[4]}}</td>
                                                            <td>{{$falla[5]}}</td>
                                                            <td>{{$falla[6]}}</td>
                                                            <form action="{{route('timesDead')}}" method='GET'>
                                                                <td><input type="hidden" name="id" id="id" value={{$falla[0]}}>
                                                                    <input type="submit" name="enviar" id="enviar" value="Detener"></td>
                                                            </form>
                                                        </tr>
                                                     @endforeach
                                                @endif
                                            </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Material Proccess</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row">

                                            <table>
                                                <thead>
                                                    <th>Folio</th>
                                                    <th>Descripcion</th>
                                                    <th>Notas</th>
                                                    <th>Cantidad</th>
                                                    <th>Status</th>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($materials))
                                              @foreach ( $materials as $material)
                                                    <tr>
                                                        <td>{{$material[0]}}</td>
                                                        <td>{{$material[1]}}</td>
                                                        <td>{{$material[2]}}</td>
                                                        <td>{{$material[3]}}</td>
                                                        <td>{{$material[4]}}</td>

                                                    </tr>
                                              @endforeach
                                              @endif

                                                </tbody>
                                            </table>



                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Assistence WEEK @if(!empty($week)){{$week}}@endif</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <table>
                                        <thead>
                                            <th>Nombre</th>
                                            <th>Lunes</th>
                                            <th>Martes</th>
                                            <th>Miercoles</th>
                                            <th>Jueves</th>
                                            <th>Viernes</th>
                                            <th>Sabado</th>
                                            <th>Domingo</th>
                                            <th>Bono Asistencia</th>
                                            <th>Bono puntualidad</th>
                                            <th>extras</th>
                                        </thead>
                                        <tbody>
                                            <form action="{{ route('ascali')}}" method="POST">
                                                @csrf
                                                @if(!empty($assit))
                                                @foreach($assit as $as)
                                                    <tr>
                                                        <td><input type="hidden" name="name[]" id="name">{{$as[2]}}</td>
                                                        @if(!empty($as[3]))
                                                        <td><input type="text" style="max-width: 40px" name="dlu[]" id="dlu" value="{{$as[3]}}"></td>
                                                        @else
                                                        <td><input type="text" style="max-width: 40px" name="dlu[]" id="dlu" value="N/R"></td>
                                                        @endif
                                                        @if(!empty($as[4]))
                                                        <td><input type="text" style="max-width: 40px" name="dma[]" id="dma" value="{{$as[4]}}"></td>
                                                        @else
                                                        <td><input type="text" style="max-width: 40px" name="dma[]" id="dma" value="N/R"></td>
                                                        @endif
                                                        @if(!empty($as[5]))
                                                        <td><input type="text" style="max-width: 40px" name="dmi[]" id="dmi" value="{{$as[5]}}"></td>
                                                        @else
                                                        <td><input type="text" style="max-width: 40px" name="dmi[]" id="dmi" value="N/R"></td>
                                                        @endif
                                                        @if(!empty($as[6]))
                                                        <td><input type="text" style="max-width: 40px" name="dju[]" id="dju" value="{{$as[6]}}"></td>
                                                        @else
                                                        <td><input type="text" style="max-width: 40px" name="dju[]" id="dju" value="N/R"></td>
                                                        @endif
                                                        @if(!empty($as[7]))
                                                        <td><input type="text" style="max-width: 40px" name="dvi[]" id="dvi" value="{{$as[7]}}"></td>
                                                        @else
                                                        <td><input type="text" style="max-width: 40px" name="dvi[]" id="dvi" value="N/R"></td>
                                                        @endif
                                                        @if(!empty($as[8]))
                                                        <td><input type="text" style="max-width: 40px" name="dsa[]" id="dsa" value="{{$as[8]}}"></td>
                                                        @else
                                                        <td><input type="text" style="max-width: 40px" name="dsa[]" id="dsa" value="N/R"></td>
                                                        @endif
                                                        @if(!empty($as[9]))
                                                        <td><input type="text" style="max-width: 40px" name="ddo[]" id="ddo" value="{{$as[9]}}"></td>
                                                        @else
                                                        <td><input type="text" style="max-width: 40px" name="ddo[]" id="ddo" value="N/R"></td>
                                                        @endif
                                                        @if(!empty($as[10]))
                                                        <td><input type="text" style="max-width: 40px" name="dba[]" id="dba" value="{{$as[10]}}"></td>
                                                        @else
                                                        <td><input type="text" style="max-width: 40px" name="dba[]" id="dba" value="N/R"></td>
                                                        @endif
                                                        @if(!empty($as[11]))
                                                        <td><input type="text" style="max-width: 40px" name="dbp[]" id="dbp" value="{{$as[11]}}"></td>
                                                        @else
                                                        <td><input type="text" style="max-width: 40px" name="dbp[]" id="dbp" value="N/R"></td>
                                                        @endif
                                                        @if(!empty($as[12]))
                                                        <td><input type="number" style="max-width: 40px" name="dex[]" id="dex" value="{{$as[12]}}"></td>
                                                        @else
                                                        <td><input type="numer" style="max-width: 40px" name="dex[]" id="dex" value="0"></td>
                                                        @endif
                                                        <td><input type="hidden" name="id[]" id="id" value="{{$as[13]}}"></td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                                <input type="submit" style="border-radius: 4px; background-color:lightblue;border-bottom:10px" name="sendassit" id="sendassist" value="Save Assistence">
                                            </form>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Registro de incidencias</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                            <form action="{{ route('excel_calidad')}}" method="GET" >

                                                <div class="form-group">
                                                    <label for="text">De fecha:</label>
                                                    <input type="date" class="form-control" name="de" id="de" required >
                                                    <input type="hidden" name="di" id="di">

                                                </div>
                                                <div class="form-group">
                                                    <label for="text">A fecha:</label>
                                                    <input type="date" class="form-control" name="a" id="a" required>
                                                    <input type="hidden" name="df" id="df">
                                                </div>
                                                <input type="submit" class="btn btn-primary"   value="Descargar Excel">
                                            </form>
                                            <script>
                                                document.getElementById('de').addEventListener('change', function() {
                                                    var de = document.getElementById('de').value;
                                                    deA= de.slice(0,4);
                                                    dem=de.slice(5,7);
                                                    deD=de.slice(8,10);
                                                    de=deD+"-"+dem+"-"+deA+" 00:00";
                                                    document.getElementById('di').value=de;
                                                    console.log('De fecha:', de);
                                                    });

                                                document.getElementById('a').addEventListener('change', function() {
                                                    var a = document.getElementById('a').value;
                                                    aA= a.slice(0,4);
                                                    am=a.slice(5,7);
                                                    aD=a.slice(8,10);
                                                    a=aD+"-"+am+"-"+aA+" 23:59";
                                                    document.getElementById('df').value=a;
                                                       console.log('A fecha:', a);
                                                    });
                                            </script>

                                </div>
                            </div>
                        </div> -->
                    </div>



@endsection

@extends('layouts.mainWithoutsidebar')

@section('contenido')
 <!-- Page Heading -->

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
                                                <th>PO</th>
                                                <th>Cantidad</th>
                                                <th>Parcial</th>
                                                <th>Iniciar test</th>
                                            </thead>
                                            <tbody align="center">
                                                @foreach ($calidad as $cal)
                                                <tr>
                                                    <form action="{{route('baja')}}" method="GET" id="forma">
                                    <td id="np">{{$cal[0]}}</td>
                                    <td id="client">{{$cal[1]}}</td>
                                    <td id="wo">{{$cal[2]}}</td>
                                    <td id="po">{{$cal[3]}}</td>
                                        <td id="cant">{{$cal[4]}}</td>
                                        <td id="parcial">{{$cal[5]}}</td>

                                    <td align="center">
                                        <form action="{{route('baja')}}" method="GET" id="forma">
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
                                            <h3><span style="margin-right: 30px">Client:  {{$client}}</span> <span style="margin-right: 30px">Part Number: {{$pn}}</span> <span style="margin-right: 30px">Qty: {{$qty}}</span><span style="margin-right: 30px"> Wo: {{$wo}}<span style="margin-right: 30px"> </h3>
                                                    <br>
                                                    <form action="{{route('saveData')}}" method="GET">
                                        <div> <h4>OK<input type="number" style="width:80px;margin-right:80px;" name="ok" id="ok" value="0" onchange="return checkOk()">      NOK<input type="number" style="width: 80px;margin-right:80px" name="nok" id="nok" value="0" onchange="return checkOk()"></h4></div>
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

<div>
    <h4>Code #1
        <input type="text" style="width:80px;margin-right:10px;" name="codigo1" id="codigo1" onchange="buscarcodigo1()">
        <input type="text" style="width:280px;margin-right:80px;" name="rest_code1" id="rest_code1">
        Cantidad<input type="number" style="width: 80px;margin-right:80px" name="1" id="1" value="0" onchange="return checkCant()">
    </h4>
</div>
<br>
<div>
    <h4>Code #2
        <input type="text" style="width:80px;margin-right:10px;" name="codigo2" id="codigo2" onchange="buscarcodigo2()">
        <input type="text" style="width:280px;margin-right:80px;" name="rest_code2" id="rest_code2">
        Cantidad<input type="number" style="width: 80px;margin-right:80px" name="2" id="2" value="0" onchange="return checkCant()">
    </h4>
</div>
<br>
<div>
    <h4>Code #3
        <input type="text" style="width:80px;margin-right:10px;" name="codigo3" id="codigo3" onchange="buscarcodigo3()">
        <input type="text" style="width:280px;margin-right:80px;" name="rest_code3" id="rest_code3">
        Cantidad<input type="number" style="width: 80px;margin-right:80px" name="3" id="3" value="0" onchange="return checkCant()">
    </h4>
</div>
<br>
<div>
    <h4>Code #4
        <input type="text" style="width:80px;margin-right:10px;" name="codigo4" id="codigo4" onchange="buscarcodigo4()">
        <input type="text" style="width:280px;margin-right:80px;" name="rest_code4" id="rest_code4">
        Cantidad<input type="number" style="width: 80px;margin-right:80px" name="4" id="4" value="0" onchange="return checkCant()">
    </h4>
</div>
<br>
<div>
    <h4>Code #5
        <input type="text" style="width:80px;margin-right:10px;" name="codigo5" id="codigo5" onchange="buscarcodigo5()">
        <input type="text" style="width:280px;margin-right:80px;" name="rest_code5" id="rest_code5">
        Cantidad<input type="number" style="width: 80px;margin-right:80px" name="5" id="5"  value="0" onchange="return checkCant()">
    </h4>
</div>
<br>

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
                                    <h6 class="m-0 font-weight-bold text-primary">Regist your barcode </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Your WO by Area content here -->
                                    <div class="card-body" style="overflow-y: auto; height: 260px;">
                                        <div class="chart-pie pt-4 pb-2">
                                            <form action="{{ route('codigoCalidad') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <h2 class="mb-3">Scan Your Code</h2>
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

                                    <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                        <div class="chart-area" id="chart-area">
                                            <style>
                                                table {     width: 100%;    text-align: center;  }
                                                td {border-bottom: solid 2px lightblue; }
                                                thead{background-color: #FC4747; color:white;  }
                                                a{text-decoration: none; color: whitesmoke;  }
                                                a:hover{ text-decoration: none; color: white; font:bold;}
                                            </style>
                                            <table id="table-sales" class="table-sales">
                                                <thead >
                                                    <th>Fehca</th>
                                                    <th>cliente</th>
                                                    <th>Número de Parte</th>
                                                    <th>Qty</th>
                                                    <th>Codigo de falla</th>
                                                    <th>Serial</th>
                                                </thead>
                                                <tbody>
                                                    @if (!empty($registros))
                                                    @foreach ($registros as $reg)

                                                    <tr>
                                                        <td>{{$reg[0]}}</td>
                                                        <td>{{$reg[1]}}</td>
                                                        <td>{{$reg[2]}}</td>
                                                        <td>{{$reg[3]}}</td>
                                                        <td>{{$reg[4]}}</td>
                                                        <td>{{$reg[5]}}</td>
                                                    </tr>
                                                    @endforeach

                                                    @endif



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
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
                            <!-- AREAS -->
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
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Material Request</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id='work'>
                                    <div align="center">
                                        <form id="formula" action="{{ route('matCali')}}" method="POST">
                                            @csrf
                                            <div style="margin-bottom: 10px;">
                                                <label for="cant1" style="margin-right: 10px;">Cantidad</label>
                                                <input type="number" style="width: 60px; margin-right: 10px;" name="cant1" id="cant1" min="0" required>
                                                <label for="articulo1" style="margin-right: 10px;">Artículo</label>
                                                <input type="text" style="width: 200px; margin-right: 10px;" name="articulo1" id="articulo1" required>
                                                <label for="notas_adicionales1" style="margin-right: 10px;">Notas adicionales</label>
                                                <input type="text" style="width: 200px;" name="notas_adicionales1" id="notas_adicionales1" required>
                                            </div>

                                            <div style="margin-bottom: 10px;">
                                                <label for="cant2" style="margin-right: 10px;">Cantidad</label>
                                                <input type="number" style="width: 60px; margin-right: 10px;" name="cant2" id="cant2" min="0" >
                                                <label for="articulo2" style="margin-right: 10px;">Artículo</label>
                                                <input type="text" style="width: 200px; margin-right: 10px;" name="articulo2" id="articulo2">
                                                <label for="notas_adicionales2" style="margin-right: 10px;">Notas adicionales</label>
                                                <input type="text" style="width: 200px;" name="notas_adicionales2" id="notas_adicionales2" >
                                            </div>

                                            <div style="margin-bottom: 10px;">
                                                <label for="cant3" style="margin-right: 10px;">Cantidad</label>
                                                <input type="number" style="width: 60px; margin-right: 10px;" name="cant3" id="cant3" min="0" >
                                                <label for="articulo3" style="margin-right: 10px;">Artículo</label>
                                                <input type="text" style="width: 200px; margin-right: 10px;" name="articulo3" id="articulo3">
                                                <label for="notas_adicionales3" style="margin-right: 10px;">Notas adicionales</label>
                                                <input type="text" style="width: 200px;" name="notas_adicionales3" id="notas_adicionales3" >
                                            </div>

                                            <div style="margin-bottom: 10px;">
                                                <label for="cant4" style="margin-right: 10px;">Cantidad</label>
                                                <input type="number" style="width: 60px; margin-right: 10px;" name="cant4" id="cant4" min="0" >
                                                <label for="articulo4" style="margin-right: 10px;">Artículo</label>
                                                <input type="text" style="width: 200px; margin-right: 10px;" name="articulo4" id="articulo4">
                                                <label for="notas_adicionales4" style="margin-right: 10px;">Notas adicionales</label>
                                                <input type="text" style="width: 200px;" name="notas_adicionales4" id="notas_adicionales4" >
                                            </div>

                                            <div style="margin-bottom: 10px;">
                                                <label for="cant5" style="margin-right: 10px;">Cantidad</label>
                                                <input type="number" style="width: 60px; margin-right: 10px;" name="cant5" id="cant5" min="0" >
                                                <label for="articulo5" style="margin-right: 10px;">Artículo</label>
                                                <input type="text" style="width: 200px; margin-right: 10px;" name="articulo5" id="articulo5">
                                                <label for="notas_adicionales5" style="margin-right: 10px;">Notas adicionales</label>
                                                <input type="text" style="width: 200px;" name="notas_adicionales5" id="notas_adicionales5" >
                                            </div>
                                            <div ><input type="submit" id="submit" value="Send"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
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
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Assistence WEEK {{$week}}</h5>
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
                                                <input type="submit" style="border-radius: 4px; background-color:lightblue;border-bottom:10px" name="sendassit" id="sendassist" value="Save Assistence">
                                            </form>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>



@endsection

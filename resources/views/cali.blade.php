@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="180">
 <script src="{{ asset('/dashjs/calidadReg.js')}}"></script>

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
                                <div class="card-body" style="overflow-y: auto; height: 500px;">
                                    @if(empty($id))


                                    <div class="table">
                                        <table style="width: 100%;">
                                            <thead  align="center" style=" color:aliceblue; background-color:rgb(253, 3, 3);">
                                                <th>Número de parte</th>
                                                <th>Cliente</th>
                                                <th>WO</th>
                                                <th>Cantidad</th>
                                                <th>Iniciar test</th>
                                                <th>Rechazar</th>
                                            </thead>
                                            <tbody class="table-group-divider">
                                               
                                                @foreach ($calidad as $cal)
                                                <tr>
                                                    <td class="text-center">{{$cal->np}}</td>
                                                    <td class="text-center">{{$cal->client}}</td>
                                                    <td class="text-center">{{$cal->wo}}</td>
                                                    <td class="text-center">{{$cal->qty}}</td>
                                                    <td class="text-center">
                                                        <form action="{{route('baja')}}" method="GET" id="forma">
                                                            <input type="hidden" name="id" id="id" value="{{$cal->id}}">
                                                            <button class="btn btn-primary" type="submit" id="enviar">Empezar</button></td>
                                                        </form>
                                                        <td class="text-center">
                                                        <form action="{{route('calidad.calidad_producto_no_conforme')}}"  method="GET" id="forma">
                                                            <input type="hidden" name="id" id="id" value="{{$cal->wo}}">
                                                            <input type="hidden" name="porque" id="porque" >
                                                            <button class="btn btn-danger" type="submit" id="enviar" >Rechazar</button></td>
                                                        </form>
                                                    </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                        @endif

                                </div>
                                </div>
                           </div>
                            <div class="col-md-6">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h4 class="m-0 font-weight-bold text-primary">Pre-accepted data</h4>
                                    </div>
                                    <div class="card-body" style="overflow-y: auto; height: 500px;">
                                        <table class="table table-bordered" id="preorder">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Part number</th>
                                                    <th scope="col">Work Order</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Acepted</th>
                                                    <th scope="col">Rejected</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($preorder))
                                                @foreach ($preorder as $item)
                                                    <tr>
                                                        <td>{{ $item->pn }}</td>
                                                        <td>{{ $item->wo}}</td>
                                                        <td>{{ $item->preCalidad}}</td>
                                                        <td>
                                                            <form action="{{ route('accepted') }}" method="GET">
                                                                @csrf
                                                                <input type="hidden" name="acpt" value="{{ $item->id }}" id="acpt">
                                                                <button type="submit" class="btn btn-success">Acepted</button>
                                                            </form>
                                                        </td>
                                                        <td> <form action="{{ route('accepted') }}" method="GET">
                                                            @csrf
                                                            <input type="hidden" name="denied" value="{{ $item->id }}" id="denied">
                                                            <button type="submit" class="btn btn-danger">Rejected  </button>
                                                        </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        <!-- Second Column for WO by Area and Shipping Area -->
                        <div class="col-lg-3 mb-4">
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
                        </div>
                           <div class="col-lg-3 mb-4">
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
       

             <div class="col-lg-6 mb-4">
                            <!-- Request Testing -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h4 class="m-0 font-weight-bold text-primary">Request Testing</h4>
                                </div>
                            

                            <div class="card body" style="overflow-y: scroll; height: 360px">
                                <!-- se hizo de manera automatica
                                <form action="{{ route('RequestTesting') }}" method="POST">
                                    @csrf
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="text">WO:</label>
                                                <input type="text" class="form-control" name="workElectrical" id="workElectrical" minlength="6" maxlength="6" required onchange="updateInfoCalidad()">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="text">Part Number:</label>
                                                <input type="text" class="form-control" name="pn" id="pn" required disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="text">Customer:</label>
                                                <input type="text" class="form-control" name="cust" id="cust" required disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="text">Revision:</label>
                                                <input type="text" class="form-control" name="rev" id="rev" required disabled>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="text">QTY</label>
                                                <input type="number" class="form-control" name="qty" id="qty" step="1" required min="1" max="1">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-2 text-center align-items-center justify-content-center">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Request</button>
                                            </div>
                                        </div>
                                    </div>

                                </form> -->
                                Se realizar de manera automatica cuando acceptes las ordenes

                            </div>
                            </div>
             </div>

        </div>

        <script>
            function updateInfoCalidad() {
                var wo = document.getElementById('workElectrical').value;
                var url= @json(route('informationWo'));
                fetch(url, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ workElectrical: wo })
                })
                    .then(response => response.json())
                    .then(data => {

                       console.log(data);
                        document.getElementById('pn').value = data.NumPart;
                        document.getElementById('cust').value = data.cliente;
                        document.getElementById('qty').value = 1;
                        document.getElementById('rev').value = data.rev;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

            }
        </script>
               <!-- <div class="row">

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




@endsection

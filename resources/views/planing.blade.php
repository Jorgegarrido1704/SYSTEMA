@extends('layouts.mainwithoutsidebar')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="120">
 <style>
    table {     width: 100%;    text-align: center;  }
    td {border-bottom: solid 2px lightblue; }
    thead{background-color: #FC4747; color:white;  }
    a{text-decoration: none; color: whitesmoke;  }
    a:hover{ text-decoration: none; color: white; font:bold;}
    .form-container {
        display: flex;
        gap: 20px;
        align-content: center;
        text-align: center;
    }

    .form-container form {
        width: 100%; /* Each form takes 50% of the container width */
    }

    .form-container form div {
        margin-bottom: 15px;
    }

    .form-container form label {
        display: block;
        margin-bottom: 5px;
    }

    .form-container form input {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        text-align: center;
    }

    @media screen and (max-width: 768px) {
        .form-container {
            flex-direction: column; /* Stack forms on smaller screens */
        }

        .form-container form {
            width: 100%; /* Each form takes full width on smaller screens */
        }
    }
</style>
 <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>
                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">
                                        <form action="{{ route('planning') }}" method="GET"> @csrf
                                            <label for="sono">Buscar por Numero de parte </label>
                                            <input type="text" name="sono" id="sono" ></form></h5>
                                </div>

                                <!-- table Body -->
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div class="chart-area" id="chart-area">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Numero de parte</th>
                                                    <th>Revision</th>
                                                    <th>WO</th>
                                                    <th>Sono</th>
                                                    <th>Qty</th>
                                                    <th>Fecha de registro</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($post as $po )
                                                <tr style="background-color: #6ff693">
                                                    <td>{{$po[0]}}</td>
                                                    <td>{{$po[1]}}</td>
                                                    <td>{{$po[6]}}</td>
                                                    <td>{{$po[2]}}</td>
                                                    <td>{{$po[3]}}</td>
                                                    <td>{{$po[4]}}</td>
                                                    <td>{{$po[5]}}</td>
                                                </tr>
                                                @endforeach
                                                @foreach ($des as $d )
                                                <tr style="background-color: #ef9453">
                                                    <td>{{$d[0]}}</td>
                                                    <td>{{$d[1]}}</td>
                                                    <td>Ya se fue</td>
                                                    <td>{{$d[2]}}</td>
                                                    <td>{{$d[3]}}</td>
                                                    <td>{{$d[4]}}</td>
                                                    <td>Ya se fue</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                    <!-- printer code -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Imprime Codigos anterioses</h5>

                                </div>

                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="chart-pie pt-4 pb-2">
                                        <div class="form-container">
                                        <form action="{{route('planning')}}" method="GET">
                                            <div>
                                                <label for="wo">WO For Barcode</label>
                                                <input type="text" name="wo" id="wo"  autofocus >
                                            </div>

                                            <input type="submit" name="enviar" id="enviar" value="Imprimir">
                                        </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-6 mb-4" style="max-width: 33%">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Impresion de consecutivos</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="form-container">
                                    <form action="{{route('planning')}}" method="GET">
                                        <div>
                                            <label for="tren1">Wo For lables</label>
                                            @if (!empty($labels))
                                            <input type="text" name="wola" id="wola" value={{$labels}} required >
                                            @else
                                            <input type="text" name="wola" id="wola" required >
                                            @endif
                                        </div>
                                        <div>
                                            <label for="tren2">Begin label</label>
                                            <input type="number" name="label1" id="label1" value='1' required>
                                        </div>
                                        <div>
                                            <label for="tren1">end label</label>
                                            <input type="number" name="label2" id="label2" required >
                                        </div>
                                        <input type="submit" name="enviar" id="enviar" value="Imprimir">
                                    </form>
                                </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4" style="max-width: 33%">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Registro de Ordenes</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="form-container">
                                        <form class="" action="{{ route('pos') }}" method="GET">
                                            @csrf
                                            <div class="form-group">
                                                <label class="po-label" for="pn">Número de parte</label>
                                                <input type="text" name="pn" id="pn" class="form-control" required onchange="return obtenerInformacion()" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <label class="po-label" for="client">Cliente</label>
                                                <input type="text" id="client" name="client" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="po-label" for="Rev">REV</label>
                                                <input type="text" name="Rev" id="Rev" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="po-label" for="Description">Descripción</label>
                                                <input type="text" id="Description" name="Description" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class="po-label" for="Uprice">Precio unitario</label>
                                                <input type="number" name="Uprice" id="Uprice" step="0.01" min="0" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="po-label" for="Enviar">Enviar a</label>
                                                <input type="text" id="Enviar" name="Enviar" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class="po-label" for="po">PO</label>
                                                <input type="text" id="po" name="po" class="form-control"   minlength="11" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="po-label" for="qty">Cantidad req</label>
                                                <input type="number" name="qty" id="qty" min="1" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="po-label" for="Orday">Día que se ordenó (Formato dd/mm/YY)</label>
                                                <input type="text" id="Orday" name="Orday" class="form-control"  required>
                                            </div>
                                            <div class="form-group">
                                                <label class="po-label" for="Reqday">Día requerido (Formato dd/mm/YY)</label>
                                                <input type="text" name="Reqday" id="Reqday" class="form-control"    required>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label class="po-label" for="WO">WO</label>
                                                <input type="text" name="WO" id="WO" class="form-control" minlength="6" required>
                                            </div>
                                            <input type="submit" name="enviar" id="enviar" value="Crear" class="btn btn-primary">
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Column 2 -->

                        <div class="col-lg-6 mb-4" style="max-width: 33%">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Ordenes Cargadas por Mes</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <canvas id="planning"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-4" style="max-width: 60%">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Registros</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >


                                    </div>
                                </div>
                            </div>
                        </div>
                       <!-- <div class="col-lg-6 mb-4" style="max-width: 33.33%">
                             AREAS
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Table of Works </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >


                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <div class="col-lg-6 mb-4" style="max-width: 40%">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Table of Works </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <script>
                        function obtenerInformacion() {
                            var pn = document.getElementById('pn').value;

                            if (pn && pn.trim() !== '') {
                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', "{{ route('getPnDetails') }}", true);
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                                // Add CSRF token to request headers
                                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

                                xhr.onload = function() {
                                    if (xhr.status >= 200 && xhr.status < 400) {
                                        try {
                                            var respuesta = JSON.parse(xhr.responseText);
                                            console.log(respuesta);
                                            document.getElementById('client').value = respuesta.client || '';
                                            document.getElementById('Rev').value = respuesta.rev || '';
                                            document.getElementById('Description').value = respuesta.desc || '';
                                            document.getElementById('Uprice').value = respuesta.price || '';
                                            document.getElementById('Enviar').value = respuesta.send || '';
                                        } catch (error) {
                                            console.error('Error parsing JSON response:', error);
                                        }
                                    } else {
                                        console.error('Error in XMLHttpRequest. Status:', xhr.status);
                                    }
                                };

                                xhr.onerror = function() {
                                    console.error('Request failed');
                                };

                                xhr.send('pn=' + pn);
                            } else {
                                console.error('Invalid part number');
                                document.getElementById('Rev').value = '';
                                document.getElementById('Description').value = '';
                                document.getElementById('Uprice').value = '';
                                document.getElementById('Enviar').value = '';
                            }
                        }
                    </script>

                    @endsection

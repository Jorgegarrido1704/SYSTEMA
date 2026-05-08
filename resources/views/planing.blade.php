@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="180">

 <script>
var dat = {!! json_encode($datosP) !!};
</script>

 <style>
    body { font-family: Arial, sans-serif;  background-color: red; color: #333; text-align: center; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); font:bold; }
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
    #ordenes {
    background-color: #6ff693;

    }
</style>
 <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>
                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">
                                        <form action="{{ route('planning') }}" method="GET"> @csrf
                                            <label for="sono">{{ __('Search Part Number') }} </label>
                                            <input type="text" name="sono" id="sono" ></form></h5>
                                </div>

                                <!-- table Body -->
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div class="chart-area" id="chart-area">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Part Number') }}</th>
                                                    <th>{{ __('Revision') }}</th>
                                                    <th>{{ __('WO') }}</th>
                                                    <th>{{ __('Sono') }}</th>
                                                    <th>{{ __('Quantity') }}</th>
                                                    <th>{{ __('Registration Date') }}</th>
                                                    <th>{{ __('Status') }}</th>
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
                                                <tr style="background-color: #ebc4a3">
                                                    <td>{{$d[0]}}</td>
                                                    <td>{{$d[1]}}</td>
                                                    <td>{{$d[5]}}</td>
                                                    <td>{{$d[2]}}</td>
                                                    <td>{{$d[3]}}</td>
                                                    <td>{{$d[4]}}</td>
                                                    <td>{{__('Already delivered')}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-2 col-lg-2">
                            <div class="card shadow mb-4">
                                    <!-- printer code -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">{{ __('Print BarCode') }}</h5>

                                </div>

                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="chart-pie pt-4 pb-2">
                                        <div class="form-container">
                                        <form action="{{route('planning')}}" method="GET">
                                            <div>
                                                <label for="wo">{{ __('Insert WO') }}</label>
                                                <input type="text" name="wo" id="wo"  autofocus >
                                            </div>

                                            <input type="submit" name="enviar" id="enviar" value="{{ __('Print') }}">
                                        </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                         <div class=" col-xl-2 col-lg-2 mb-2" >
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">{{ __('Print Lebels') }}</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="form-container">
                                    <form action="{{route('planning')}}" method="GET">
                                        <div>
                                            <label for="tren1">{{ __('Insert WO') }}</label>
                                            @if (!empty($labels))
                                            <input type="text" name="wola" id="wola" value={{$labels}} required >
                                            @else
                                            <input type="text" name="wola" id="wola" required >
                                            @endif
                                        </div>

                                        <input type="submit" name="enviar" id="enviar" value="{{ __('Print') }}">
                                    </form>
                                </div>

                                </div>
                            </div>
                        </div>

                         <div class=" col-xl-2 col-lg-2 mb-2" >
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">{{ __('Liberate Order') }}</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <form action="{{route('codeBarPlan')}}" method="GET">
                                        <div class="form-group">
                                            <label for="wo_scan" class="form-label">{{ __('Scan WO') }}</label>
                                            </div>
                                            <div class="form-group">
                                            <input type="text" name="wo_scan" id="wo_scan" class="form-control" autofocus>
                                            </div>
                                            <div class="form-group">
                                            <button class="btn btn-primary" type="submit"> {{ __('Liberate') }}</button>
                                            </div>

                                    </form>


                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <div class=" col-xl-6 col-lg-6 mb-4" >
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">{{ __('Register Orders') }}</h5>
                                </div>
                                <div class="card-body" id="ChangeOrders" style="overflow-y: auto; height: 360px; background-color: #e0e0e0">
                                    <div class="form-container">
                                        <form class="" action="{{ route('pos') }}" method="GET">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-2 col-xl-2 mb-4">
                                                            <div class="form-group">
                                                                <label class="po-label" for="pn">{{ __('Part Number') }}</label>
                                                                <input type="text" name="pn" id="pn" class="form-control" required onchange="return obtenerInformacion()" autofocus>
                                                            </div>
                                                </div>
                                                <div class="col-lg-3 col-xl-3 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="client">{{ __('Customer') }}</label>
                                                        <input type="text" id="client" name="client" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-xl-1 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="Rev1">{{ __('REV') }}</label>
                                                        <input type="text" name="Rev1" id="Rev1" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="Uprice">{{ __('Price') }}</label>
                                                        <input type="number" name="Uprice" id="Uprice" step="0.01" min="0.01" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="po">PO</label>
                                                        <input type="text" id="po" name="po" class="form-control"   minlength="11" maxlength="15" required>
                                                    </div>
                                                </div>
                                                 <div class="col-lg-2 col-xl-2 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="qty">{{ __('Qty') }}</label>
                                                        <input type="number" name="qty" id="qty" min="1" class="form-control" minlength="10" maxlength="10" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="Description">{{ __('Description') }}</label>
                                                        <input type="text" id="Description" name="Description" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-6 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="Enviar">{{ __('Send To') }}</label>
                                                        <input type="text" id="Enviar" name="Enviar" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-xl-2 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="Orday">{{ __('Order Date') }}</label>
                                                        <input type="date" id="Orday" name="Orday" class="form-control"  minlength="10" maxlength="10"  required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="Reqday">{{ __('Required Date') }}</label>
                                                        <input type="date" name="Reqday" id="Reqday" class="form-control"    required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="WO">{{ __('WO') }}</label>
                                                        <input type="text" name="WO" id="WO" class="form-control" minlength="6" maxlength="6" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-xl-1 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="ppap">{{ __('PPAP') }}</label>
                                                        <input type="checkbox" name="ppap" id="ppap" class="form-control"  onchange="return validarPpapPrim()">
                                                    </div>
                                                </div>
                                                 <div class="col-lg-1 col-xl-1 mb-4">
                                                    <div class="form-group">
                                                        <label class="po-label" for="prim">{{ __('PRIM') }}</label>
                                                        <input type="checkbox" name="prim" id="prim" class="form-control"  onchange="return validarPpapPrim()">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-xl-1 mb-4">
                                                    <div class="form-group">
                                                        <input type="hidden" name="Rev" id="Rev" >
                                                     <button class="btn btn-success" type="submit" >{{ __('Save') }}</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Column 2 -->
                          <div class="col-lg-6  col-xl-6 mb-4" >
                            <!-- Pending Requests Card Example -->
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h5 class="m-0 font-weight-bold text-primary">{{ __('Pending to sign') }}</h5>
                                    </div>
                                    <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                        <div class="row">
                                            <table>
                                                <thead>
                                                    <th>Type</th>
                                                    <th>Client</th>
                                                    <th>part Number</th>
                                                    <th>Rev 1</th>
                                                    <th>Rev 2</th>
                                                    <th>Description Moviement</th>
                                                    <th>Date</th>
                                                    <th>Enginner</th>
                                                    <th>Sign Quality</th>
                                                    <th>Sign Imex</th>
                                                    <th>Sign Testing</th>
                                                    <th>Sign Production</th>
                                                    <th>Sign Purchase</th>
                                                    <th>Sign Planning</th>
                                                </thead>
                                                <tbody>
                                                    @if (!empty($answer))
                                                        @foreach ($answer as $answer)
                                                            <tr>
                                                                <td>{{ $answer[0] }}</td>
                                                                <td>{{ $answer[1] }}</td>
                                                                <td>{{ $answer[2] }}</td>
                                                                <td>{{ $answer[3] }}</td>
                                                                <td>{{ $answer[4] }}</td>
                                                                <td>{{ $answer[5] }}</td>
                                                                <td>{{ $answer[6] }}</td>
                                                                <td>{{ $answer[7] }}</td>
                                                                <td>{{ $answer[8] }}</td>
                                                                <td>{{ $answer[9] }}</td>
                                                                <td>{{ $answer[10] }}</td>
                                                                <td>{{ $answer[11] }}</td>
                                                                <td>{{ $answer[12] }}</td>
                                                                <td>{{ $answer[13] }}</td>
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
                        <div class="col-lg-6 col-xl-6 mb-6">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Registros por mes</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <canvas id="planning"></canvas>


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
                                            respuesta.rev = respuesta.rev.replace('PPAP ', '').replace('PRIM ', '');
                                            document.getElementById('Rev').value = respuesta.rev || '';
                                            document.getElementById('Description').value = respuesta.desc || '';
                                            document.getElementById('Uprice').value = respuesta.price || '';
                                            document.getElementById('Enviar').value = respuesta.send || '';
                                            document.getElementById('ChangeOrders').style.backgroundColor = respuesta.color || '#e0e0e0';
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
                        function validarPpapPrim() {
                            var ppapCheckbox = document.getElementById('ppap');
                            var primCheckbox = document.getElementById('prim');
                            var colorenpagina = document.getElementById('ChangeOrders');


                            if (ppapCheckbox.checked) {
                                primCheckbox.checked = false;
                                colorenpagina.style.backgroundColor = 'green';
                                document.getElementById('Rev').value = 'PPAP '+ document.getElementById('Rev1').value;
                                alert(document.getElementById('Rev').value);

                            }
                            if (primCheckbox.checked) {
                                ppapCheckbox.checked = false;
                                colorenpagina.style.backgroundColor = 'yellow';
                                document.getElementById('Rev').value = 'PRIM '+ document.getElementById('Rev1').value;
                                alert(document.getElementById('Rev').value);
                            }

                        }
                    </script>

                    @endsection

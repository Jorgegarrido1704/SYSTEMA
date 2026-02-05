@extends('layouts.main')

@section('contenido')
    <!-- Page Heading -->
    <meta http-equiv="refresh" content="250">
    <script>
        var paola = @json($paola);
        var paoDesc = @json($paoDesc);
        var alex = @json($alex);
        var alexDesc = @json($alexDesc);
        var paoT = @json($paolaT);
        var alexT = @json($alexT);
        var paoTd = @json($paolaTdesc);
        var url = @json(route('datosWO'));

        //    console.log(paoT + paoTd);
        //   console.log(alex + alexDesc);
        function workOrder() {
            var workOrder = document.getElementById('workIs').value;
            fetch(url, {
                    method: 'POST',
                    body: JSON.stringify({
                        workOrder: workOrder
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == 'ok') {

                        document.getElementById('pnIs').value = data.NumPart;
                        document.getElementById('revIs').value = data.rev;
                    } else {
                        alert('Work Order not found.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching work order info:', error);
                });
        }

        if ()
    </script>
    <style>
        .ppap {
            text-align: center;
            font-weight: bold;
            background-color: rgb(53, 243, 75);
        }

        .prim {
            text-align: center;
            font-weight: bold;
            background-color: rgb(240, 243, 53);
        }

        .table-header {
            text-align: center;
            font-weight: bold;
            background-color: rgb(235, 83, 202);
        }

        table {
            width: 100%;
        }

        td,
        th {
            text-align: center;
        }

        td {
            border-bottom: solid 2px lightblue;
        }

        thead {
            background-color: #bd0606;
            color: white;
        }

        a {
            text-decoration: none;
            color: whitesmoke;
        }

        a:hover {
            text-decoration: none;
            color: white;
            font: bold;
        }

        .soporte {
            text-align: center;
            font-weight: bold;
            background-color: rgb(88, 8, 247);
        }
    </style>
    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
    <div class="row">

        <!-- PPAP In the Floor -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4" id="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">PPAP in the floor</h5>
                </div>

                <!-- tabla de trabajos -->
                <div class="card-body" style="overflow-y: auto; height: 260px;">
                    <div class="chart-area" id="chart-area">
                        <table id="table-harness" class="table-harness">
                            <thead
                                style=" position: sticky; z-index: 1; top: 0; text-align: center; background-color: #bd0606; color: white; ">
                                <tr>
                                    <th class="ppap"></th>
                                    <th class="ppap"></th>
                                    <th class="ppap">PPAP</th>
                                    <th class="prim"> </th>
                                    <th class="prim"> </th>
                                    <th class="prim">PRIM </th>
                                    <th class="prim"> </th>
                                </tr>
                                <tr>
                                    <th>Part Number</th>
                                    <th>Client</th>
                                    <th>REV</th>
                                    <th>WO</th>
                                    <th>Qty</th>
                                    <th>Area</th>
                                    <th>Sign</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inges as $inge)
                                    <tr>
                                        <form action="{{ route('autorizar') }}" method="GET">
                                            <td>{{ $inge->NumPart }}</td>
                                            <td>{{ $inge->cliente }}</td>
                                            <td>{{ $inge->rev }}</td>
                                            <td>{{ $inge->wo }}</td>
                                            <td>{{ $inge->Qty }}</td>
                                            @if ($inge->count == 13)
                                                <td>Assembly</td>
                                            @elseif ($inge->count == 14)
                                                <td>Loom</td>
                                            @elseif ($inge->count == 16)
                                                <td>Terminals</td>
                                            @elseif ($inge->count == 17)
                                                <td>Cutting</td>
                                            @elseif ($inge->count == 18)
                                                <td>Quality</td>
                                            @elseif ($inge->count == 19)
                                                <td>Electrical testing</td>
                                            @endif
                                            <td><input type="hidden" id='iding' name='iding'
                                                    value="{{ $inge->id }}">
                                                <input type="hidden" id='count' name='count'
                                                    value="{{ $inge->count }}">
                                                <input type="hidden" id='info' name='info'
                                                    value="{{ $inge->info }}">
                                                <input type="submit" name="enviar" id="enviar" value='Autorizar'>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

        </div>
        <!-- FULLS SIZE Requested -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4" id="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">FULLS SIZE Requested</h5>
                </div>
                <!-- tabla de trabajos -->
                <div class="card-body" style="overflow-y: auto; height: 260px;">
                    <div class="chart-area" id="chart-area">
                        <table id="table-harness" class="table-harness">
                            <thead
                                style=" position: sticky; z-index: 1; top: 0; text-align: center; background-color: #bd0606; color: white; ">
                                <tr>
                                    <th class="table-header"></th>
                                    <th class="table-header"></th>
                                    <th class="table-header"></th>
                                    <th class="table-header"></th>
                                    <th class="table-header"></th>
                                    <th class="table-header">FULL SIZE </th>
                                    <th class="table-header"> </th>
                                    <th class="table-header"> </th>
                                    <th class="table-header"> </th>
                                    <th class="table-header"> </th>
                                </tr>
                                <tr>
                                    <th>Requested By</th>
                                    <th>Date</th>
                                    <th>Part Number</th>
                                    <th>rev</th>
                                    <th>Client</th>
                                    <th>Quantity</th>
                                    <th>Board</th>
                                    <th>status</th>
                                    <th>Modify</th>
                                    <th>Finish</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fullreq as $inge)
                                    <tr>
                                        <td>{{ $inge->SolicitadoPor }}</td>
                                        <td>{{ $inge->fechaSolicitud }}</td>
                                        <td>{{ $inge->np }}</td>
                                        <td>{{ $inge->rev }}</td>
                                        <td>{{ $inge->cliente }}</td>
                                        <td>{{ $inge->Cuantos }}</td>
                                        <td>{{ $inge->tablero }}</td>
                                        <form action="{{ 'modifull' }}" method="GET">
                                            <td><select name="estatus" id="estatus">
                                                    <option value="{{ $inge->estatus }}">{{ $inge->estatus }}</option>
                                                    <option value="En_proceso">En proceso</option>
                                                    <option value="Pausado">Pausado</option>
                                                </select></td>
                                            <td><input type="hidden" id='mod' name='mod'
                                                    value="{{ $inge->id }}">
                                                <input type="submit" name="enviar" id="enviar" value='Modificar'>
                                            </td>
                                        </form>
                                        <form action="{{ 'modifull' }}" method="GET">
                                            <td><input type="hidden" id='finAct' name='finAct'
                                                    value="{{ $inge->id }}">
                                                <input type="submit" name="enviar" id="enviar" value='Finalizar'>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <!-- Floor Support -->
        <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-4" id="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Floor Support</h5>
                </div>
                <!-- tabla de trabajos -->
                <div class="card-body" style="overflow-y: auto; height: 260px;">
                    <div class="chart-area" id="chart-area">
                        <table>
                            <thead
                                style=" position: sticky; z-index: 1; top: 0; text-align: center; background-color: #bd0606; color: white; ">
                                <tr>
                                    <th class="soporte"></th>
                                    <th class="soporte">Floor Support</th>
                                    <th class="soporte"></th>
                                    <th class="soporte"></th>
                                    <th class="soporte"></th>
                                    <th class="soporte"></th>
                                    <th class="soporte"></th>

                                </tr>
                                <tr>
                                    <th>Part Number</th>
                                    <th>Problem</th>
                                    <th>Validation By</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($problem as $problema)
                                    <tr>
                                        <td>Pn: {{ $problema->pn }}
                                            <br>
                                            WO: {{ $problema->wo }}
                                            <br>
                                            REV: {{ $problema->rev }}
                                        </td>
                                        <td>{{ $problema->descriptionIs }}</td>
                                        <td>{{ $problema->WhoReg }}</td>
                                        <td>{{ $problema->DateIs }}</td>
                                        <td>
                                            <form action="{{ 'problemasFin' }}">
                                                <input type="hidden" name="id_problema" id="id_problema"
                                                    value="{{ $problema->id }}">
                                                <button class="btn btn-success">Finish</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
         <!-- Engineers Activities -->
        <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-4" id="card2">
                <!-- Set Work -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Engineers Activities</h5>

                </div>

                <div class="card-body" style="overflow-y: auto; height: 260px; ">



                    <form action="{{ route('tareas') }}" method="GET" id='form'>
                        <div class="row">
                            <div class="col-md-3 mb-4 mt-4 ">
                                <div class="form-group text-center">
                                    <label for="Inge">
                                        <h4>Engineers</h4>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <select name="Inge" id="Inge" required>
                                        <option value=""></option>
                                        @foreach ($ingenieros_en_piso as $ingesPiso)
                                            <option value="{{ $ingesPiso->user }}">{{ $ingesPiso->user }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-center">
                                    <label for="act">
                                        <h4>Activities to do</h4>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <select name="act" id="act" required>
                                        <option value=""></option>
                                        <option value="Sistemas">Modificacion o creacion de sistemas</option>
                                        <option value="Documentacion ">Documentacion PPAP</option>
                                        <option value="Soporte en piso">Soporte en piso</option>
                                        <option value="Colocacion de full size">Colocacion de full size</option>
                                        <option value="Seguimiento PPAP">Seguimiento PPAP</option>
                                        <option value="Diseno de piezas 3D">Diseño de piezas 3D</option>
                                        <option value="Comida">Comida</option>
                                        <option value="Retroalimentacion y aclaraciones a clientes">Retroalimentacion y
                                            aclaraciones a clientes</option>
                                        <option value="Juntas">Juntas</option>
                                        <option value="pruebas electricas">Pruebas electricas y validacion</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label for="info">Additional Information</label>
                                </div>

                                <div class="form-group">
                                    <textarea name="info" id="info" cols="50" rows="2" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-1 mt-5 md-5">
                                <input type="submit" name="sub" id="sub" value="Save Information">
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>



    <div class="row">
         <!-- Work in processe -->
        <div class="col-lg-5 col-lx-5 mb-4">
            <!-- AREAS -->
            <div class="card shadow mb-4">


                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Works in processe</h5>

                </div>
                <div class="card-body" style="overflow-y: auto; height: 360px;" id='work'>
                    <div class="row">

                        <table>
                            <thead>
                                <th>Enginner</th>
                                <th>Activity</th>
                                <th>Description</th>
                                <th>Timer</th>
                                <th>Stop/continue</th>
                                <th>Finish Activity</th>

                            </thead>

                            <tbody>
                                @if (!empty($enginners))
                                    @foreach ($enginners as $eng)
                                        <tr>
                                            <td>{{ $eng->Id_request }}</td>

                                            <td>{{ $eng->actividades }}</td>
                                            <td>{{ $eng->desciption }}
                                            <td><span id="{{ $eng->id }}">
                                               {{ $eng->times }}

                                            <td>
                                                <form action="{{ route('action') }}" method="GET">
                                                    <input type="hidden" name="id" value="{{ $eng->id }}">
                                                    @if ($eng->fechaEncuesta != 'pausado')
                                                        <button type="submit">Pausar</button>
                                                    @elseif ($eng->fechaEncuesta == 'pausado')
                                                        <button type="submit">Continuar</button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('action') }}" method="GET">
                                                    <input type="hidden" name="id_f" value="{{ $eng->id }}">

                                                    <button type="submit">Finalizar</button>
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
        </div>
        <!--Pendings to Sign -->
        <div class="col-lg-7 col-lx-7 mb-4">
            <!-- AREAS -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Pendings to Sign</h5>
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
        <div class="col-lg-4 col-lx-4 mb-4">
            <!-- AREAS -->
            <div class="card shadow mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">CREATE PPAP & PRIM @if (session('error'))
                            <p style="color: #FC4747"> {{ session('error') }} </p>
                        @endif <a style="hover: none" href="{{ route('excel_ing') }}">excel</a></h5>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#" onclick="ingregistro('cronograma')">Cronograma</a>
                            <a class="dropdown-item" href="#" onclick="ingregistro('ppap')">Registro de ppap</a>

                        </div>
                    </div>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 860px;" id='work'>
                    <div class="row">
                        <style>
                            /* Form container */
                            .containerPPAP {
                                width: 100%;
                                margin: 0 auto;
                                padding: 20px;
                                border-radius: 8px;

                            }

                            /* Label styles */
                            label {
                                display: block;
                                margin-bottom: 5px;
                                font-weight: bold;
                            }

                            /* Input styles */
                            input[type="text"],
                            input[type="date"],
                            textarea,
                            select {
                                width: calc(100% - 20px);
                                /* Subtracting padding */
                                padding: 8px;
                                margin-bottom: 15px;
                                border: 1px solid #ccc;
                                border-radius: 4px;
                                box-sizing: border-box;
                            }

                            /* Select styles */
                            select {
                                width: 100%;
                            }

                            /* Submit button styles */
                            input[type="submit"] {
                                padding: 10px 20px;
                                background-color: #007bff;
                                color: #fff;
                                border: none;
                                border-radius: 4px;
                                cursor: pointer;
                            }

                            input[type="submit"]:hover {
                                background-color: #0056b3;


                            }
                        </style>

                        <div class="containerPPAP" id="containerPPAP">
                            <form action="{{ route('RegPPAP') }}" method="GET">
                                <label for="Tipo">Type of Work</label>
                                <select name="Tipo" id="Tipo" required>
                                    <option value=""></option>
                                    <option value="PPAP">NEW PPAP</option>
                                    <option value="PRIM">NEW PRIM</option>
                                    <option value="Change PPAP">Change PPAP</option>
                                    <option value="Change PRIM">Change PRIM</option>
                                    <option value="NO PPAP">NO PPAP</option>
                                </select>
                                <label for="Client">Client</label>
                                <select name="Client" id="Client" required>
                                    <option value=""></option>
                                    <option value="READING TRUCK">READING TRUCK</option>
                                    <option value="MORGAN OLSON">MORGAN OLSON</option>
                                    <option value="JOHN DEERE">JOHN DEERE</option>
                                    <option value="OP MOBILITY">OP MOBILITY</option>
                                    <option value="BROWN">BROWN</option>
                                    <option value="DUR-A-LIFT">DUR-A-LIFT</option>
                                    <option value="BERSTROMG">BERGSTROM</option>
                                    <option value="BLUE BIRD">BLUE BIRD</option>
                                    <option value="ATLAS">ATLAS</option>
                                    <option value="UTILIMASTER">UTILIMASTER</option>
                                    <option value="CALIFORNIA">CALIFORNIA</option>
                                    <option value="TICO MANUFACTURING">TICO MANUFACTURING</option>
                                    <option value="SPARTAN">SPARTAN</option>
                                    <option value="PHOENIX">PHOENIX</option>
                                    <option value="FOREST RIVER">FOREST RIVER</option>
                                    <option value="SHYFT">SHYFT</option>
                                    <option value="KALMAR">KALMAR</option>
                                    <option value="MODINE">MODINE</option>
                                    <option value="NILFISK">NILFISK</option>
                                    <option value="PLASTIC OMNIUM">PLASTIC OMNIUM</option>
                                    <option value="ZOELLER">ZOELLER</option>
                                    <option value="COLLINS">COLLINS</option>
                                    <option value="Proterra Powered LLC">Proterra Powered LLC.</option>
                                    <option value="PALFINGER">PALFINGER</option>
                                    <option value="FLUENCE">FLUENCE</option>

                                </select>
                                <label for="tipoArnes">Harness Type</label>
                                <select name="tipoArnes" id="tipoArnes" required>
                                    <option value=""></option>
                                    <option value="Cable de bateria">BATTERY CABLE</option>
                                    <option value="Arnes">HARNESS</option>
                                    <option value="Caja">BOX</option>
                                    <option value="Kit de arneses">HARNESS KIT</option>
                                    <option value="panel">PANEL</option>
                                    <option value="componente">COMPONENT</option>
                                </select>
                                <label for="pn">PN</label>
                                <input type="text" name="pn" id="pn" required onchange="updateRev()">
                                <label for="rev1">Actual REV or new REV</label>
                                <input type="text" name="rev1" id="rev1" required>
                                <label for="rev2">New REV</label>
                                <input type="text" name="rev2" id="rev2">
                                <label for="cambios">Modification's Descriptions </label>
                                <textarea name="cambios" id="cambios" cols="60" rows="2"></textarea>
                                <label for="quien">Engineer</label>

                                <select name="quien" id="quien" required>
                                    <option value=""></option>
                                    @foreach ($ingenieros_en_piso as $ingesPiso)
                                        <option value="{{ $ingesPiso->user }}">{{ $ingesPiso->user }}</option>
                                    @endforeach

                                </select>
                                <input type="submit" value="Submit">
                            </form>


                        </div>
                    </div>

                </div>
            </div>
        </div>
        <style>
            /* Add this CSS code to your stylesheet or in a <style> tag in your HTML file */
            #tiempos {
                transition: all 0.3s ease;
                /* Smooth transition effect */
                width: 100%;
                /* Initial width */
                height: auto;
                /* Initial height */
                position: relative;
                /* Ensure normal positioning initially */
            }

            #tiempos:hover {
                width: 100vw;
                /* Make the width 100% of the viewport width */
                height: 100vh;
                /* Make the height 100% of the viewport height */
                position: fixed;
                /* Fix the position to the viewport */
                top: 0;
                /* Align to the top of the viewport */
                left: 0;
                /* Align to the left of the viewport */
                z-index: 9999;
                /* Bring the element to the front */
                overflow: auto;
                /* Ensure overflow is handled */
                background: white;
                /* Optional: Set a background color */
            }

            canvas {
                max-height: 50%;
            }

            a {
                color: #007bff;
            }
        </style>
        <!-- <div class="col-lg-6 mb-4">
                         AREAS
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">Cronograma Diario</h5>
                            </div>
                            <div class="card-body" style="overflow-y: auto; height: 660px;">
                                <canvas id="Paola S" style="width: 100%; height: 100%;"></canvas>
                                <canvas id="Alex V" style="width: 100%; height: 100%;"></canvas>
                            </div>
                        </div>
                    </div>-->

        <!-- Reportes -->
        <!--<div class="row">-->
        <div class="col-lg-6 col-xl-7 mb-5">
            <div>
                <div class="card shadow mb-5">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">Problems on the floor</h5>

                    </div>
                    <div class="card-body" style="height: 335px;">
                        <form class="row g-3" action="{{ route('problemas') }}" method="GET">
                            <div class="col-md-6">
                                <label for="pnIs" class="form-label">Part Number</label>
                                <input type="text" class="form-control" name="pnIs" id="pnIs" required>
                            </div>
                            <div class="col-md-6">
                                <label for="workIs" class="form-label">Work Order</label>
                                <input type="text" class="form-control" name="workIs" id="workIs" minlength="6"
                                    required onchange="workOrder();">
                            </div>
                            <div class="col-md-6">
                                <label for="revIs" class="form-label">Revision</label>
                                <input type="text" class="form-control" name="revIs" id="revIs" minlength="1"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="probIs" class="form-label">Problem</label>
                                <select id="probIs" name="probIs" class="form-select" required>
                                    <option selected>...</option>
                                    <option value = "Prosses Error">Prosses Error</option>
                                    <option value = "Paper work">Paper work</option>
                                    <option value = "Both(Prosses Error and Paper work)">Both(Prosses Error and Paper work)
                                    </option>
                                    <option value = "Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="descIs" class="form-label">Description</label>
                                <textarea class="form-control" name="descIs" id="descIs" rows="3"></textarea>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Send Info</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!-- Cronograma
                        <div class="col-lg-6 mb-4">


                            <div class="card shadow mb-4" id="tiempos">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Cronograma de Trabajo ING</h5>
                                    <button><a href="/ing">Mes actual</a></button><button><a href="/ing?mont='fr'">Siguiente
                                            mes</a></button>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 560px; " id="">
                                    <div class="row">
                                        <div id="table">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Cliente</th>
                                                        <th>No. Parte</th>
                                                        <th>REV</th>
                                                        <th>Fecha Fecha Compromiso Inicial</th>
                                                        <th>Fecha Compromiso con cambios</th>
                                                        @foreach ($dias_mes as $dias)
                        <th>{{ $dias }}</th>
                        @endforeach
                                                                            <th>Nueva Fecha</th>
                                                                            <th>Guardar cambio</th>
                                                                            <th>Finalizar</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        @foreach ($cronoGram as $cron)
                        <tr>
                                                                                <td>{{ $cron[1] }}</td>
                                                                                <td>{{ $cron[2] }}</td>
                                                                                <td>{{ $cron[3] }}</td>
                                                                                <td>{{ $cron[5] }}</td>
                                                                                @if ($cron[5] == $cron[6])
                        <td></td>
                    @else
                        <td> {{ $cron[6] }}</td>
                        @endif
                                                                                @foreach ($dias_mes as $dias)
                        @if ($dias >= $cron[11] && $dias <= $cron[10] && $cron[5] == $cron[6])
                        <td><input type="box" name="check" id="check"
                                                                                                style="background-color:GREEN; width: 20px; height: 20px;">
                                                                                        </td>
                    @elseif ($dias >= $cron[11] && $dias <= $cron[10] && $cron[5] != $cron[6])
                        @if ($dias >= $cron[11] && $dias <= $cron[10] - $cron[12])
                        <td><input type="box" name="check" id="check"
                                                                                                    style="background-color:GREEN; width: 20px; height: 20px;">
                                                                                            </td>
                    @else
                        <td><input type="box" name="check" id="check"
                                                                                                    style="background-color:lightblue; width: 20px; height: 20px;">
                                                                                            </td>
                        @endif
                    @else
                        <td><input type="box" name="check" id="check"
                                                                                                style=" width: 20px; height: 20px;"></td>
                        @endif
                        @endforeach
                                                                                <form action="{{ route('cronoReg') }}" method="GET">
                                                                                    <td>
                                                                                        <input type="date" name="nuevaFecha" id="nuevaFecha">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="hidden" name="id_cambio" id="id_cambio"
                                                                                            value="{{ $cron[0] }}">
                                                                                        <input type="submit" name="enviar" id="enviar"
                                                                                            value='Guardar'>
                                                                                    </td>
                                                                                </form>
                                                                                <td>
                                                                                    <form action="{{ route('cronoReg') }}" method="GET">
                                                                                        <input type="hidden" name="id_fin" id="id_fin"
                                                                                            value="{{ $cron[0] }}">
                                                                                        <input type="submit" name="enviar" id="enviar"
                                                                                            value='Finalizar'>
                                                                                    </form>
                                                                                </td>
                                                                            </tr>
                        @endforeach


                                                                    </tbody>
                                                                </table>
                                                                <canvas id="regGraf"></canvas>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>-->

                            <!--  </div>-->
    </div>

@endsection

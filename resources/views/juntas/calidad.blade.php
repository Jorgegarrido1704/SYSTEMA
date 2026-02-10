@extends('layouts.main')

@section('contenido')
    <!-- Page Heading -->
    <meta http-equiv="refresh" content="300">
    <style>
        table {
            width: 100%;
            text-align: center;
        }

        td {
            border-bottom: solid 2px lightblue;
        }

        thead {
            background-color: #FC4747;
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

        .chart-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-area {
            flex: 1;
            margin: 0 10px;
        }
    </style>

    <script>
        var datos = {!! json_encode($datos) !!};
        var pareto = {!! json_encode($pareto) !!};
        var Qdays = {!! json_encode($Qdays) !!}
        var colorQ = {!! json_encode($colorQ) !!}
        var labelQ = {!! json_encode($labelQ) !!}
        var paretoYear = {!! json_encode($monthAndYearPareto) !!};
        var dias = {!! json_encode($days) !!};
        var empleados = {!! json_encode($empleados) !!};
        var respo = {!! json_encode($respemp) !!};
        var supIssue = {!! json_encode($supIssue) !!};
        var codigoErrores = {!! json_encode($codigoErrores) !!};
        var grupos = {!! json_encode($grupo) !!};
        console.log(grupos);
      //  console.log(supIssue);
    </script>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

    </div>
    <div class="row">

        <!-- Table and Graph -->
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary"> Incidences</h5>

                </div>

                <!-- table Body -->
                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                    <div class="chart-area" id="chart-area">
                        <canvas id="BarCali"></canvas>
                    </div>
                </div>
            </div>
        </div>
         <!-- Top 3 incidences -->
        <div class="col-lg-4 col-lx-4">
            <!-- AREAS -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Top 3 incidence daily</h5>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 360px;">
                    <table>
                        <thead>
                            <th>Client</th>
                            <th>Issue</th>
                            <th>Quantity</th>
                        </thead>
                        <tbody>
                            @if (!empty($top3registrosCalidas))
                                @foreach ($top3registrosCalidas as $datoF)
                                    <tr>
                                        <td>{{ $datoF->client }}<br>{{ $datoF->pn }}</td>
                                        <td>{{ $datoF->codigo }}</td>
                                        <td>{{ $datoF->total_resto }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">No hay datos</td>
                                </tr>

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
             <!-- FTQ Graph -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <!-- Card scaneer -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">FTQ (First Time Quality)
                        @if($totalb + $totalm >0)
                        Tested:{{ $totalb + $totalm }} <span class="text-success">OK: </span> <span class="text-dark">{{ $totalb }}</span>
                        <span class="text-danger">Oportunities:</span> <span class="text-dark">{{ $totalm }}</span>
                        Porcentage:
                        @if( (($totalb/($totalb + $totalm)) * 100) >97 )
                        <span class="text-success">{{ round($totalb / ($totalb + $totalm) * 100,2) }}</span>
                        @else
                        <span class="text-danger">{{ round($totalb / ($totalb + $totalm) * 100,2) }}</span>
                        @endif
                        @endif
                    </h5>

                </div>

                <div class="card-body" style="overflow-y: auto; max-height: 360px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
                        <!-- Primera gráfica: 60% del espacio -->
                        <div class="chart-area" style="flex: 0 0 60%; margin-right: 10%;">
                            <canvas id="pareto"></canvas>
                        </div>
                        <!-- Segunda gráfica: 30% del espacio -->
                        <div class="chart-area" style="flex: 0 0 30%;">
                            <canvas id="barPareto"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
             <!-- Customer Complains -->
        <div class="col-xl-3 col-lg-3">
            <!-- AREAS -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Customer complains  </h5><br>
                     <div class="row">
                            @if($value=='Admin' or $value=='Edward M' or $value=='Goretti Ro' or $value=='Luis R')

                            <div class="col-md-3">
                                <label for="dateIncidence" class="form-label">Incidence Date</label>
                            </div>
                            <div class="col-md-5">
                                <input type="date" class="form-control" id="dateIncidence" name="dateIncidence" required>
                            </div>


                            <div class="col-md-2">
                            <form id="guardasDateQ" action="{{ route('customerComplains') }}"  method="GET"  >
                                <input type="hidden" name="gQ" id="gQ">
                                <button type="submit" class="btn btn-success" onclick="guardarDateQ()">Guardar</button>
                            </form>
                            </div>
                            <div class="col-md-2">
                             <form id="borrarDateQ" action="{{ route('customerComplains') }}" method="GET">
                                <input type="hidden" name="bQ" id="bQ">
                                <button type="submit" class="btn btn-danger" onclick="borrarDateQ()">Borrar</button>
                            </form>
                            </div>

                            @endif
                        </div>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 300px;">

                    <canvas id="Q"></canvas>

                </div>
            </div>
        </div>
              <!-- Reworks responsible yesterday -->
        <div class="col-lg-3 mb-3" style="max-width: 40%">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Reworks Responsible Yesterday </h5>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                    <div class="row">
                        <table>
                            <thead>
                                <th>Responsable</th>
                                <th>Quantity</th>
                            </thead>
                            <tbody>
                                @if (!empty($gultyY))
                                    @foreach ($gultyY as $datoGultyY)
                                        <tr>
                                            <td>{{ $datoGultyY[0] }}</td>
                                            <td>{{ $datoGultyY[1] }}</td>

                                        </tr>
                                    @endforeach
                                @endif
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
         <!-- Top 10 employees monthly -->
        <div class="col-lg-4 col-lx-4">
            <!-- AREAS -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Top 10 employees incidents Monthly</h5>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                    <canvas id="MonthIncidences"></canvas>
                </div>
            </div>
        </div>
        <!-- Table Supervisors -->
        <div class="col-lg-4 col-lx-4 mb-4" >
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">Supervisor Issues in the month </h5>
                        </div>
                        <div class="card-body" style="overflow-y: auto; height: 360px;" >
                            <canvas id="Supervisorissues"></canvas>
                        </div>
                    </div>
        </div>
         <!-- Porcentaje of the bad incidences in the month -->
        <div class="col-lg-4 col-lx-4">
            <!-- AREAS -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Top 5 defects in the month</h5>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                    <canvas id="mostErrors"></canvas>
                </div>
            </div>
        </div>
         <!-- Tested harness Per Famaly in the mothe -->
        <div class="col-lg-12 col-lx-12">
            <!-- AREAS -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Porcentaje of the harness per famalies</h5>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 560px;" >
                    <div class="row">
                        <div class="col-lg-4 col-lx-4">
                             <table class="table table-striped table-bordered">
                                <thead>
                                    <th>Family</th>
                                    <th>Circuits numbers</th>
                                    <th>Quantity</th>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Harness A</td>
                                        <td>MORE THAN 300</td>
                                        <td>{{$grupo['A']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Harness B</td>
                                        <td>BETWEEN 200 AND 300</td>
                                        <td>{{$grupo['B']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Harness C</td>
                                        <td>BETWEEN 100 AND 199</td>
                                        <td>{{$grupo['C']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Harness D</td>
                                        <td>BETWEEN 50 AND 99</td>
                                        <td>{{$grupo['D']}}</td>
                                    </tr>
                                     <tr>
                                        <td>Harness E</td>
                                        <td>BETWEEN 25 AND 49</td>
                                        <td>{{$grupo['E']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Harness F</td>
                                        <td>BETWEEN 10 AND 24</td>
                                        <td>{{$grupo['F']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Harness G</td>
                                        <td>BETWEEN 5 AND 9</td>
                                        <td>{{$grupo['G']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Harness H</td>
                                        <td>LESS THAN 5</td>
                                        <td>{{$grupo['H']}}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-8 col-lx-8">
                             <canvas id="familiesTested"></canvas>
                        </div>
                     </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Graficas malas -->
    <div class="row">
            <!-- FTQ Today -->
        <div class="col-lg-4 mb-3">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">FTQ Now (Good: {{ $hoyb }} Bad:
                        {{ $hoymal }} FTQ: {{ $parhoy }}) </h5>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                    <div class="row">
                        <table>
                            <thead>
                                <th>Client</th>
                                <th>Issue</th>
                                <th>Quantity</th>
                            </thead>
                            <tbody>
                                @if (!empty($datosHoy))
                                    @foreach ($datosHoy as $datoHoy)
                                        <tr>
                                            <td>{{ $datoHoy[0] }}<br>{{ $datoHoy[3] }}</td>
                                            <td>{{ $datoHoy[1] }}</td>
                                            <td>{{ $datoHoy[2] }}</td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
        <!-- Reworks responsible -->
        <div class="col-lg-4 mb-4">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Reworks Responsible Now </h5>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                    <div class="row">
                        <table>
                            <thead>
                                <th>Responsable</th>
                                <th>Quantity</th>
                            </thead>
                            <tbody>
                                @if (!empty($gulty))
                                    @foreach ($gulty as $datoGulty)
                                        <tr>
                                            <td>{{ $datoGulty[0] }}</td>
                                            <td>{{ $datoGulty[1] }}</td>

                                        </tr>
                                    @endforeach
                                @endif
                        </table>

                    </div>
                </div>
            </div>
        </div>

          <!-- whitout incidences  -->
        <div class="col-lg-4 col-lx-4">
            <!-- AREAS -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Employees without incidents in 2025</h5>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                    <table id="table-harness" class="table-harness">
                        <thead>
                            <th>Employees</th>
                        </thead>
                        <tbody >
                            @if(!@empty($personalYear))
                            @foreach ($personalYear as $datoPersonalYear)
                                <tr>
                                    <td>{{ $datoPersonalYear }}</td>
                                </tr>
                            @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="row">

        <div class="col-lg-3 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Quality Data testing control</h5>
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
        <div class="col-lg-3 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">In the quality areas</h5>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                    <div class="card-body" style="overflow-y: auto; height: 360px;">
                        <form action="{{ route('excel_calidad_pendientes')}}" method="GET" >
                            <input type="submit" class="btn btn-primary"   value="Descargar Reporte">
                        </form>
                    </div>
                </div>
            </div>
    </div>


@endsection

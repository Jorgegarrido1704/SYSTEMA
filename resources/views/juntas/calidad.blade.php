@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="120">
 <style>
    table {     width: 100%;    text-align: center;  }
    td {border-bottom: solid 2px lightblue; }
    thead{background-color: #FC4747; color:white;  }
    a{text-decoration: none; color: whitesmoke;  }
    a:hover{ text-decoration: none; color: white; font:bold;}

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
    var Qdays={!! json_encode($Qdays) !!}
var colorQ={!! json_encode($colorQ) !!}
var labelQ={!! json_encode($labelQ)!!}
var paretoYear={!! json_encode($monthAndYearPareto) !!};
var dias={!! json_encode($days) !!};
var empleados= {!! json_encode($empleados) !!};
var respo = {!! json_encode($respemp) !!};


</script>
 <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>
                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-8 col-lg-8">
                            <div class="card shadow mb-4">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
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
                                                @if (!empty($datosF))
                                                @foreach ($datosF as $datoF)
                                                <tr>
                                                    <td>{{$datoF[0]}}<br>{{$datoF[3]}}</td>
                                                    <td>{{$datoF[1]}}</td>
                                                    <td>{{$datoF[2]}}</td>
                                                </tr>
                                                @endforeach
                                                @foreach ($datosS as $datoS)
                                                <tr>
                                                    <td>{{$datoS[0]}}<br>{{$datoS[3]}}</td>
                                                    <td>{{$datoS[1]}}</td>
                                                    <td>{{$datoS[2]}}</td>
                                                </tr>
                                                @endforeach
                                                @foreach ($datosT as $datoT)
                                                <tr>
                                                    <td>{{$datoT[0]}}<br>{{$datoT[3]}}</td>
                                                    <td>{{$datoT[1]}}</td>
                                                    <td>{{$datoT[2]}}</td>
                                                </tr>
                                                @endforeach

                                                @endif
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8 col-lg-8">
                            <div class="card shadow mb-4">
                                    <!-- Card scaneer -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">FTQ (First Time Quality) <span></span> Total tested:{{$totalb+$totalm}}  total Buenas: {{$totalb}} total incidences: {{$totalm}} </h5>

                                </div>

                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
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
                        <div class="col-xl-4 col-lg-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Customer complains</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <canvas id="Q"></canvas>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">


                        <div class="col-lg-4 mb-4" style="max-width: 40%">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">FTQ Now (Good: {{$hoyb}} Bad: {{$hoymal}} FTQ: {{$parhoy}}) </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >
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
                                                        <td>{{$datoHoy[0]}}<br>{{$datoHoy[3]}}</td>
                                                        <td>{{$datoHoy[1]}}</td>
                                                        <td>{{$datoHoy[2]}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @endif

                                                </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4" style="max-width: 40%">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Reworks Responsible Now </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >
                                        <table>
                                            <thead>
                                                <th>Responsable</th>
                                                <th>Quantity</th>
                                            </thead>
                                                <tbody>
                                                    @if (!empty($gulty))
                                                    @foreach ($gulty as $datoGulty)
                                                    <tr>
                                                        <td>{{$datoGulty[0]}}</td>
                                                        <td>{{$datoGulty[1]}}</td>

                                                    </tr>
                                                    @endforeach
                                                    @endif
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4" style="max-width: 40%">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Reworks Responsible Yesterday </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >
                                        <table>
                                            <thead>
                                                <th>Responsable</th>
                                                <th>Quantity</th>
                                            </thead>
                                                <tbody>
                                                    @if (!empty($gultyY))
                                                    @foreach ($gultyY as $datoGultyY)
                                                    <tr>
                                                        <td>{{$datoGultyY[0]}}</td>
                                                        <td>{{$datoGultyY[1]}}</td>

                                                    </tr>
                                                    @endforeach
                                                    @endif
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                      <!-- Graficas malas -->
                      <div class="row">

                        <div class="col-lg-6 col-lx-6">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Top 5 employees incidents Montly</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                   <canvas id="MonthIncidences"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-lx-6">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Employees without incidents in 2025</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                  <table id="table-harness" class="table-harness">
                                    <thead>
                                        <th>Employee</th>
                                    </thead>
                                        <tbody id="tres" >


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    @endsection

@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="60">
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
</script>
 <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>
                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-12 col-lg-12">
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


                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                    <!-- Card scaneer -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Daily pareto</h5>

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
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Quality issue last day</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <canvas id="Q"></canvas>

                                </div>
                            </div>
                        </div>
                        <!-- Column 2 -->

                        <div class="col-lg-6 mb-4">
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
                                                    <td>{{$datoF[0]}}</td>
                                                    <td>{{$datoF[1]}}</td>
                                                    <td>{{$datoF[2]}}</td>
                                                </tr>
                                                @endforeach
                                                @foreach ($datosS as $datoS)
                                                <tr>
                                                    <td>{{$datoS[0]}}</td>
                                                    <td>{{$datoS[1]}}</td>
                                                    <td>{{$datoS[2]}}</td>
                                                </tr>
                                                @endforeach
                                                @foreach ($datosT as $datoT)
                                                <tr>
                                                    <td>{{$datoT[0]}}</td>
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

                    </div>
                    <div class="row">

                       <!-- // total Harness
                        <div class="col-lg-6 mb-4" style="max-width: 60%">
                            <-- AREAS --
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Registros</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >
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
                                                    <th>Date</th>
                                                    <th>client</th>
                                                    <th>Part Number</th>
                                                    <th>qty</th>
                                                    <th>Issue</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($calidadControl as $control)
                                                    <tr>
                                                        <td>{{$control[0]}}</td>
                                                        <td>{{$control[1]}}</td>
                                                        <td>{{$control[2]}}</td>
                                                        <td>{{$control[3]}}</td>
                                                        <td>{{$control[4]}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4" style="max-width: 33.33%">
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

                    @endsection

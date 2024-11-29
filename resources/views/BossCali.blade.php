@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="90">
 <style>
    table {     width: 100%;    text-align: center;  }
    td {border-bottom: solid 2px lightblue; }
    thead{background-color: #FC4747; color:white;  }
    a{text-decoration: none; color: whitesmoke;  }
    a:hover{ text-decoration: none; color: white; font:bold;}
</style>
<script>
    var datos = {!! json_encode($datos) !!};
    var pareto = {!! json_encode($pareto) !!};
    var Qdays={!! json_encode($Qdays) !!};
    var colorQ={!! json_encode($colorQ) !!};
    var labelQ={!! json_encode($labelQ)!!};
</script>
 <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>
                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Incidences</h5>

                                </div>

                                <!-- table Body -->
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div class="chart-area" id="chart-area">
                                        <canvas id="BarCali"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                    <!-- Card scaneer -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary"> FTQ(First Time Quality)</h5>

                                </div>

                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="pareto"></canvas>

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
                                    <h5 class="m-0 font-weight-bold text-primary">Quality issue</h5>
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
                                    <h5 class="m-0 font-weight-bold text-primary">Top 3 incidence</h5>
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
                        <div class="col-lg-6 mb-4" style="max-width: 60%">
                            <!-- AREAS -->
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

                    @endsection

@extends('layouts.main')

@section('contenido')
<meta http-equiv="refresh" content="120">
    <script>
        const fetchDta = @json(route('fetchdata'));
    </script>
<script src="{{ asset('/dash/js/demo/fetchDta.js')}}"></script>
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
                      <!--  <h1 class="h3 mb-0 text-gray-800"></h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Sales Today</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="saldos">{{$saldos}}</span></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Backlock</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="backlock"></span></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Productivity
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">83.55%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 83.55%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                           </div>

                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Hourly Sales</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                           <a class="dropdown-item" href="#" onclick="changeArea('lines')">Graph lines</a>
                                            <a class="dropdown-item" href="#" onclick="changeArea('table')">table</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div class="chart-area" id="chart-area">
                                        <canvas id="myAreaCharts" height=40%></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Pass view WO</h6>
                                  <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                 <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div> -->
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="pies"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-danger" ></i> <a href="#" class="text-danger">Delay.</a>
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-warning"></i> <a href="#" class="text-warning">On Time.</a>
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> <a href="#" class="text-success">Great Time.</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Monthly Percentage by Customer</h6>

                                </div>
                                <!--percent section -->
                                <div class="card-body">


                                    @if($client[0] != 0)
                                    <h4 class="small font-weight-bold"><a href="#" class="text-danger">Bergstrom</a> <span
                                            class="float-right" >{{$client[0]}}%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{$client[0]}}%;"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($client[1] != 0)
                                    <h4 class="small font-weight-bold"><a href="#" class="text-warning">Atlas</a> <span
                                            class="float-right">{{$client[1]}}%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{$client[1]}}%;"
                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($client[2] != 0)
                                    <h4 class="small font-weight-bold"><a href="#" class="text-bar">Blue Bird</a> <span
                                            class="float-right">{{$client[2]}}%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar" role="progressbar" style="width: {{$client[2]}}%;"
                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($client[3] != 0)
                                    <h4 class="small font-weight-bold"><a href="#" class="text-info">Collins</a><span
                                            class="float-right">{{$client[3]}}%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{$client[3]}}%;"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($client[4] != 0)
                                    <h4 class="small font-weight-bold"><a href="#" class="text-success">El Dorado California</a><span
                                            class="float-right">{{$client[4]}}%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$client[4]}}%;"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($client[5] != 0)
                                    <h4 class="small font-weight-bold"><a href="#" class="text-danger">Forest</a> <span
                                            class="float-right">{{$client[5]}}%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{$client[5]}}%;"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($client[6] != 0)
                                    <h4 class="small font-weight-bold"><a href="#" class="text-warning">Kalmar</a> <span
                                            class="float-right">{{$client[6]}}%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{$client[6]}}%;"
                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($client[7] != 0)
                                    <h4 class="small font-weight-bold"><a href="#" class="text-bar">Modine</a><span
                                            class="float-right">{{$client[7]}}%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar" role="progressbar" style="width: {{$client[7]}}%;"
                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($client[8] != 0)
                                    <h4 class="small font-weight-bold"><a href="#" class="text-info">Phoenix Motor Cars</a><span
                                            class="float-right">{{$client[8]}}%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width:{{$client[8]}}%;"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($client[9] != 0)
                                    <h4 class="small font-weight-bold"><a href="#" class="text-success">Spartan</a><span
                                            class="float-right">{{$client[9]}}%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$client[9]}}%;"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($client[10] != 0)
                                    <h4 class="small font-weight-bold"><a href="#" class="text-danger">Tico Manufacturing</a><span
                                        class="float-right">{{$client[10]}}%</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{$client[10]}}%;"
                                        aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                @endif
                                    @if($client[11] != 0)
                                <h4 class="small font-weight-bold"><a href="#" class="text-warning">Utilimaster</a><span
                                        class="float-right">{{$client[11]}}%</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{$client[11]}}%;"
                                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                @endif
                                    @if($client[12] != 0)
                                <h4 class="small font-weight-bold"><a href="#" class="text-bar">Zoeller</a> <span
                                        class="float-right">{{$client[12]}}%</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar" role="progressbar" style="width: {{$client[12]}}%;"
                                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                @endif
                            <!--    <h4 class="small font-weight-bold">Forest River <span
                                        class="float-right">%</span></h4>
                                <div class="progress mb-4">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: }%"
                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>-->

                                </div>
                            </div>

                            <!-- Color System-->

                            <div class="row">

                              <!--  <div class="col-lg-6 mb-4">
                                    <div class="card bg-primary text-white shadow">
                                        <div class="card-body">
                                            Primary
                                            <div class="text-white-50 small">#4e73df</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-success text-white shadow">
                                        <div class="card-body">
                                            Success
                                            <div class="text-white-50 small">#1cc88a</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-info text-white shadow">
                                        <div class="card-body">
                                            Info
                                            <div class="text-white-50 small">#36b9cc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-warning text-white shadow">
                                        <div class="card-body">
                                            Warning
                                            <div class="text-white-50 small">#f6c23e</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-danger text-white shadow">
                                        <div class="card-body">
                                            Danger
                                            <div class="text-white-50 small">#e74a3b</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-secondary text-white shadow">
                                        <div class="card-body">
                                            Secondary
                                            <div class="text-white-50 small">#858796</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-light text-black shadow">
                                        <div class="card-body">
                                            Light
                                            <div class="text-black-50 small">#f8f9fc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-dark text-white shadow">
                                        <div class="card-body">
                                            Dark
                                            <div class="text-white-50 small">#5a5c69</div>
                                        </div>
                                    </div>
                                </div>-->
                            </div>

                        </div>
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"><a href="{{route('litas_reg')}}">Money by Station</a></h6>

                                </div>
                                <!--percent section -->
                                <div class="card-body">


                                    @if($ventasStation[0] != 0)
                                    <h4 class="small font-weight-bold"><a href="{{route('litas_junta','planeacion')}}" class="text-danger">Planeacion</a>
                                        <span class="float-right">{{$ventasStation[0]}}</span>
                                        <span class="float-right">{{$ventasStation[6]*100}}% // $</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{$ventasStation[6]*100}}%;"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($ventasStation[1] != 0)
                                    <h4 class="small font-weight-bold"><a href="{{route('litas_junta','corte')}}" class="text-warning">Corte</a>
                                        <span class="float-right">{{$ventasStation[1]}}</span>
                                        <span class="float-right">{{$ventasStation[7]*100}}% // $</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{$ventasStation[7]*100}}%;"
                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($ventasStation[2] != 0)
                                    <h4 class="small font-weight-bold"><a href="{{route('litas_junta','liberacion')}}" class="text-bar">Liberacion</a>
                                        <span class="float-right">{{$ventasStation[2]}}</span>
                                        <span class="float-right">{{$ventasStation[8]*100}}% // $</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar" role="progressbar" style="width: {{$ventasStation[8]*100}}%;"
                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($ventasStation[3] != 0)
                                    <h4 class="small font-weight-bold"><a href="{{route('litas_junta','ensamble')}}" class="text-info">Ensamble</a>
                                        <span class="float-right">{{$ventasStation[3]}}</span>
                                        <span class="float-right">{{$ventasStation[9]*100}}% // $</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{$ventasStation[9]*100}}%;"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($ventasStation[4] != 0)
                                    <h4 class="small font-weight-bold"><a href="{{route('litas_junta','loom')}}" class="text-success">Loom</a>
                                        <span class="float-right">{{$ventasStation[4]}}</span>
                                        <span class="float-right">{{$ventasStation[10]*100}}% // $</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$ventasStation[10]*100}}%;"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($ventasStation[5] != 0)
                                    <h4 class="small font-weight-bold"><a href="{{route('litas_junta','prueba')}}" class="text-info">Calidad</a>
                                        <span class="float-right"> {{$ventasStation[5]}}</span>
                                        <span class="float-right">{{$ventasStation[11]*100}}% // $</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar  bg-info" role="progressbar" style="width: {{$ventasStation[11]*100}}%;"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif
                                    @if($ventasStation[12] != 0)
                                    <h4 class="small font-weight-bold"><a href="{{route('litas_junta','embarque')}}" class="text-dark">Embarque</a>
                                        <span class="float-right"> {{$ventasStation[12]}}</span>
                                        <span class="float-right">{{$ventasStation[13]*100}}% // $</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar  bg-dark" role="progressbar" style="width: {{$ventasStation[13]*100}}%;"
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    @endif

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
                                    <h6 class="m-0 font-weight-bold text-primary">Tested list</h6>
                                </div>
                                        <div class="card-body" style="overflow-y: auto; height: 400px;">

                                        </div>
                                </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                                <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">WO by Area</h6>
                                </div>
                                        <div class="card-body" style="overflow-y: auto; height: 400px;">
                                            <table class="table-info"  id="PPAP Pendings" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Part number</th>
                                                        <th scope="col">date In</th>
                                                        <th scope="col">date Out</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                    </div>

                    </div>
           

@endsection

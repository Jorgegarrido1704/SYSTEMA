@extends('layouts.main')

@section('contenido')


    <script  >
         //grafica tiempos
        const actividades = {!! json_encode($actividades) !!};
        const actividadesLastMonth = {!! json_encode($actividadesLastMonth) !!};
        const url = '{{ route('registrosajax') }}';
    </script>

    <script>
        //grafica ppaps
       // $jesp=$nanp=$bp=$jcp=$psp=$alv=$asp=$jg
     const datosPpap = {!! json_encode($datosPpap) !!};
     const todas = {!! json_encode($todas) !!};
    </script>

    <script>
                //grafica trabajos
            const buenos = {!! json_encode($porcentaje) !!};
            const bien = {!! json_encode($b) !!};
            const malos= {!! json_encode($m) !!};
            const mothLess12 = {!! json_encode($last12Months) !!};
                const compGoals = {!! json_encode($thisYearGoals) !!};
                const timesByPlaning = {!! json_encode($retasoPorPlan) !!};
                const timesByFirmas = {!! json_encode($registoPorFirmas) !!};
    </script>

    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

    <div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary"> KPI WORK TIMES </h5>
                </div>
                <!-- table Body -->
                <div class="card-body" style="overflow-y: auto; height: 400px;">
                    <canvas id="tiempos"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">KPI NPI </h5>
                </div>
                <!-- table Body -->
                <div class="card-body" style="overflow-y: auto; height: 400px;">
                    <canvas id="procesosIngPpap"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">KPI DOCUMENTATION DEVELOPMENT</h5>
                      <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#" onclick="changeGraph('donaMes')">Graph lines</a>
                            <a class="dropdown-item" href="#" onclick="changeGraph('barraYear')">table</a>
                        </div>
                    </div>
                </div>
                <!-- table Body -->
                 <div class="card-body" style="overflow-y: auto; height: 480px;">
                <div style="display: flex; gap: 20px;">
                    <div id="donaMes">
                        <label for="paretoTime">Record for the last month: {{$porcentaje}} %</label>
                        <canvas id="cakes" width="320" height="200" ></canvas>
                    </div>
                 <div id="barraYear" >
                     <label for="paretoTime"> </label>
                     <label for="registros"></label>
                     <canvas id="cakes2" width="400" height="300" ></canvas>
                 </div>
                    <div id="paretoTime" style="overflow-y: auto; height: 350px; display: none">
                        @if(!empty($registrosmes))
                        <table class="table table-striped table-bordered"  cellspacing="0" width="100%">
                             <thead style=" position: sticky; z-index: 1; top: 0; text-align: center; background-color: black; color: white; ">
                                <tr>
                                    <th>Customer</th>
                                    <th>Part Number</th>
                                    <th>Commitment Date</th>
                                    <th>Completion Date</th>
                                </tr>
                            </thead>
                            <tbody>
                        @foreach ($registrosmes as $registro  )
                            <tr style="text-align: center;color: black;">
                                <td>{{$registro->customer}}</td>
                                <td>{{$registro->pn}}</td>
                                @if($registro->commitmentDate >= $registro->CompletionDate)
                                <td style="background-color: rgba(137, 255, 101, 0.578);">{{$registro->commitmentDate}}</td>
                                @else <td style="background-color: rgba(255, 123, 90, 0.588);">{{$registro->commitmentDate}}</td>
                                @endif
                                <td>{{$registro->CompletionDate}}</td>
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
         <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">KPI PPAP TIMES</h5>

                </div>
                <!-- table Body -->
                 <div class="card-body" style="overflow-y: auto; height: 480px;">
                <canvas id="diferencias" width="320" height="200" ></canvas>
                </div>


             </div>

        </div>
    </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">Open NPI</h5>
                        <span class="text-dark font-weight-bold text-align-top">Total: {{ $totalgeneral??0 }}</span>
                        <span class="text-primary font-weight-bold text-align-top">Open by engineer: {{ $ingependinses??0 }}</span>
                        <span class="text-danger font-weight-bold text-align-top">Pending planing: {{ $porbajara??0 }}</span>
                        <span class="text-dark font-weight-bold text-align-top">Total in progress: {{ $enproceso??0 }}</span>
                        <span class="text-success font-weight-bold text-align-top">Open by PPAP: {{ $totalppap??0 }}</span>
                        <span class="text-warning font-weight-bold text-align-top">Open by PRIM: {{ $totalprim??0 }}</span>

                        <form action="#" id="formNpi">
                            <div class="row">
                                <div class="col-lg-4 mb-4">
                                    <label for="tipoNpi">Type of NPI</label>
                                    <select id="tipoNpi" name="tipoNpi" class="form-control" onchange="tipoNpiChange()">
                                        <option value="" selected disabled>Select one</option>
                                        <option value="white">Pending</option>
                                        <option value="green">PPAP</option>
                                        <option value="yellow">PRIM</option>
                                    </select>
                                </div>

                                <div class="col-lg-4 mb-4">
                                    <label for="filtrar">Filter</label>
                                    <button type="button" id="filtrar" class="btn btn-primary form-control">Apply</button>
                                </div>
                            </div>
                        </form>


                    </div>
                    <!-- table Body -->
                    <div  style="overflow-y: auto; height: 800px;">
                        <table class="table table-striped table-bordered"  cellspacing="0" width="100%">
                            <thead style=" position: sticky; z-index: 1; top: 0; text-align: center; background-color: black; color: white; ">
                                <tr>
                                    <th>Customers</th>
                                    <th>Part Numbers</th>
                                    <th>size</th>
                                    <th>Revision</th>
                                    <th>Reception Date</th>
                                    <th>Commitment Date</th>
                                    <th>Completion Date</th>
                                    <th>Requiriment Date</th>
                                    <th>Po Qty</th>
                                    <th>Responsable</th>
                                    <th>Last Sign Date</th>
                                    <th>Plannig Date</th>
                                    <th>Work Order</th>
                                    <th>Produciton Qty</th>
                                    <th>Cutting</th>
                                    <th>Terminals</th>
                                    <th>Assembly //<br>Special Assembly</th>
                                    <th>Loom</th>
                                    <th>Quality</th>
                                </tr>

                            </thead>

                                <tbody  id="registrosNPI">
                                @if(!empty($registroPPAP))
                                    @foreach ($registroPPAP as $ppaps )

                                        <tr id={{ $ppaps[21] }} style="text-align: center; background-color:rgba({{ $ppaps[14] }}) ; text-align: center; color : black;">

                                            <td>{{$ppaps[0]}} </td>
                                            <td> <a href="{{ route('seguimiento', $ppaps[22]) }}">{{$ppaps[1]}} </a> </td>
                                            <td>{{$ppaps[2]}} </td>
                                            <td>{{$ppaps[3]}} </td>

                                            <td>{{$ppaps[4]}} </td>
                                            <td>{{$ppaps[5]}} </td>
                                            <td style="color: {{ $ppaps[17] }};" >{{ $ppaps[6] }} </td>
                                            <td>{{$ppaps[15]}} </td>
                                            <td>{{$ppaps[18]}} </td>
                                            <td>{{$ppaps[16]}} </td>
                                            <td>{{$ppaps[7]}} </td>
                                            <td>{{$ppaps[8]}} </td>
                                            <td>{{$ppaps[19]}} </td>
                                            <td>{{$ppaps[20]}} </td>
                                            <td>{{$ppaps[9]}} </td>
                                            <td>{{$ppaps[10]}} </td>
                                            <td>{{$ppaps[11]}} </td>
                                            <td>{{$ppaps[12]}} </td>
                                            <td>{{$ppaps[13]}} </td>

                                        </tr>
                                        </a>

                                    @endforeach
                                @endif

                            </tbody>

                        </table>
                    </div>
                    </div>
         </div>
        </div>
    </div>
    </div>
@endsection

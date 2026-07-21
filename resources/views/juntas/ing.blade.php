@extends('layouts.main')

@section('contenido')


    <script>
         //grafica tiempos
        const actividades = {!! json_encode($actividades) !!};
        const actividadesLastMonth = {!! json_encode($actividadesLastMonth) !!};
        const url = '{{ route('registrosajax') }}';
    </script>
    <script src="{{ asset('dash/js/Junta_Ingenieria/chart_documentacion.js') }}"></script>
    <script>
        //grafica ppaps
       // $jesp=$nanp=$bp=$jcp=$psp=$alv=$asp=$jg
       const registrosArrays = {!! json_encode($registrosArray) !!};
       const registrosMensual = {!! json_encode($registrosMensual) !!};
     const datosPpap = {!! json_encode($datosPpap) !!};
     const todas = {!! json_encode($todas) !!};
    </script>

    <script>
                //grafica trabajos
                const timesByPlaning = {!! json_encode($retasoPorPlan) !!};
                const timesByFirmas = {!! json_encode($registoPorFirmas) !!};
    </script>

    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

    <div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary"> KPI {{ __('ENGINEER WORK TIMES') }} </h5>
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
                    <h5 class="m-0 font-weight-bold text-primary">KPI {{ __('NPI') }} </h5>
                </div>
                <!-- table Body -->
                <div class="card-body" style="overflow-y: auto; height: 400px;">
                    <canvas id="procesosIngPpap"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">KPI {{ __('DOCUMENTATION DEVELOPMENT') }}</h5>
                <input type="date" id="fechas_por_mes" name="fechas_por_mes" style="width: 200px;" onchange="cargarGraficas(this.value)" >

                </div>
                <!-- table Body -->
                 <div class="card-body" style="overflow-y: auto; height: 480px;">
                <div style="display: flex; gap: 20px;">
                    <div id="donaMes">
                        <label for="paretoTime">{{ __('Record for the last month') }}: <span id="porcentaje_mes"></span> %</label>
                        <canvas id="cakes" width="320" height="200" ></canvas>
                    </div>
                 <div id="barraYear" >
                     <label for="paretoTime"> </label>
                     <label for="cakes2"></label>
                     <canvas id="cakes2" width="400" height="300" ></canvas>
                 </div>
                    <div id="paretoTime" style="overflow-y: auto; height: 350px;">
                        @if(!empty($registrosmes))
                        <table class="table table-striped table-bordered"  cellspacing="0" width="100%">
                             <thead style=" position: sticky; z-index: 1; top: 0; text-align: center; background-color: black; color: white; ">
                                <tr>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Part Number') }}</th>
                                    <th>{{ __('Commitment Date') }}</th>
                                    <th>{{ __('Completion Date') }}</th>
                                </tr>
                            </thead>
                            <tbody id="tabla_registros en el mes">
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
      <!--   <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">KPI {{ __('PPAP TIMES') }}</h5>

                </div>
                <!- table Body ->
                 <div class="card-body" style="overflow-y: auto; height: 480px;">
                <canvas id="diferencias" width="320" height="200" ></canvas>
                </div>
             </div>
        </div>-->
    </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">{{ __('Open NPI Projects') }}</h5>
                        <span class="text-dark font-weight-bold text-align-top">Total: {{ $totalgeneral??0 }}</span>
                        <span class="text-primary font-weight-bold text-align-top"><a onclick="tipoNpiChange('white')">{{ __('Open by engineer') }}: {{ $ingependinses??0 }}</a></span>
                        <span class="text-danger font-weight-bold text-align-top"><a onclick="tipoNpiChange('pending')">{{ __('Pending by planing') }}: {{ $porbajara??0 }}</a></span>
                        <span class="text-dark font-weight-bold text-align-top">{{ __('Total in progress') }}: {{ $enproceso??0 }}</span>
                        <span class="text-success font-weight-bold text-align-top"><a onclick="tipoNpiChange('green')">{{ __('Open PPAP') }}: {{ $totalppap??0 }}</a></span>
                        <span class="text-warning font-weight-bold text-align-top"><a onclick="tipoNpiChange('yellow')">{{ __('Open PRIM') }}: {{ $totalprim??0 }}</a></span>
                    </div>
                    <!-- table Body -->
                    <div  style="overflow-y: auto; height: 800px;">
                        <table class="table table-striped table-bordered"  cellspacing="0" width="100%">
                            <thead style=" position: sticky; z-index: 1; top: 0; text-align: center; background-color: black; color: white; ">
                                <tr>
                                    <th>{{ __('Customers') }}</th>
                                    <th>{{ __('Part Numbers') }}</th>
                                    <th>{{ __('Size') }}</th>
                                    <th>{{ __('Revision') }}</th>
                                    <th>{{ __('Reception Date') }}</th>
                                    <th>{{ __('Commitment Date') }}</th>
                                    <th>{{ __('Completion Date') }}</th>
                                    <th>{{ __('Requirement Date') }}</th>
                                    <th>{{ __('Po Qty') }}</th>
                                    <th>{{ __('Responsable') }}</th>
                                    <th>{{ __('Last Sign') }}</th>
                                    <th>{{ __('Planning') }}</th>
                                    <th>{{ __('WO') }}</th>
                                    <th>{{ __('Produciton Qty') }}</th>
                                    <th>{{ __('Cut') }}</th>
                                    <th>{{ __('Terminals') }}</th>
                                    <th>{{ __('Assembly') }} //<br>{{ __('Special Assembly') }}</th>
                                    <th>{{ __('Loom') }}</th>
                                    <th>{{ __('Quality') }}</th>
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

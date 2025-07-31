@extends('layouts.main')

@section('contenido')


    <script  >
         //grafica tiempos
        const actividades = {!! json_encode($actividades) !!};
        const actividadesLastMonth = {!! json_encode($actividadesLastMonth) !!};
        const jesus = {!! json_encode($jesus) !!};
        const paos = {!! json_encode($pao) !!};
        const nancy = {!! json_encode($nancy) !!};
        const ale = {!! json_encode($ale) !!};
        const carlos = {!! json_encode($carlos) !!};
        const arturo = {!! json_encode($arturo) !!};
        const jorge = {!! json_encode($jorge) !!};
        const brandon = {!! json_encode($brandon) !!};
    </script>

    <script>
        //grafica ppaps
       // $jesp=$nanp=$bp=$jcp=$psp=$alv=$asp=$jg
        const jesp = {!! json_encode($jesp) !!};
        const nanp = {!! json_encode($nanp) !!};
        const bp = {!! json_encode($bp) !!};
        const jcp = {!! json_encode($jcp) !!};
        const psp = {!! json_encode($psp) !!};
        const alv = {!! json_encode($alv) !!};
        const asp = {!! json_encode($asp) !!};
        const jg = {!! json_encode($jg) !!};
        const todas = {!! json_encode($todas) !!};
    </script>

    <script>
                //grafica trabajos
            const buenos = {!! json_encode($porcentaje) !!};
            const malos = {!! json_encode($porcentajeMalos) !!};
            const mothLess12 = {!! json_encode($last12Months) !!};
                const compGoals = {!! json_encode($thisYearGoals) !!};
            // console.log(compGoals);
    </script>

    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

    <div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary"> Tiempos de trabajo </h5>
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
                    <h5 class="m-0 font-weight-bold text-primary">Registro de Actividades PPAP </h5>
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
                    <h5 class="m-0 font-weight-bold text-primary">Registro De Trabajos documentacion </h5>
                </div>
                <!-- table Body -->
                 <div class="card-body" style="overflow-y: auto; height: 450px;">
                <div style="display: flex; gap: 20px;">
                    <div>
                        <label for="paretoTime">Record for the month: {{$porcentaje}} %</label>
                        <canvas id="cakes" width="400" height="300" ></canvas>
                    </div>
                 <div>
                     <label for="paretoTime"> </label>
                     <label for="registros"></label>
                     <canvas id="cakes2" width="400" height="300" ></canvas>
                 </div>
                    <div>
                        <canvas id="paretoTime" width="400" height="300"></canvas>
                    </div>
                </div>
            </div>

            </div>
        </div>

        <div class="col-xl-12 col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Registro de Actividades Ultimo Mes</h5>
                </div>
                <!-- table Body -->
                <div class="card-body" style="overflow-y: auto; height: 400px;">
                    <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Numero de Parte</th>
                                <th>size</th>
                                <th>Revision</th>
                                <th>Fecha de recibo</th>
                                <th>Fecha compromiso</th>
                                <th>Fecha de entrega</th>
                                <th>Fecha del cliente</th>
                                <th>Responsable</th>
                                <th>Fecha de firmas <br>completadas Ingeinieria</th>
                                <th>Planeacion</th>
                                <th>Corte</th>
                                <th>Liberacion</th>
                                <th>ensamble //<br>cables especiales</th>
                                <th>Loom</th>
                                <th>Calidad</th>

                            </tr>




                        </thead>
                        <tbody>
                            @if(!empty($registroPPAP))
                                @foreach ($registroPPAP as $ppaps )

                                    <tr style="text-align: center; background-color:rgba({{ $ppaps[14] }}) ; text-align: center; color : black;">
                                        <td>{{$ppaps[0]}} </td>
                                        <td>{{$ppaps[1]}} </td>
                                        <td>{{$ppaps[2]}} </td>
                                        <td>{{$ppaps[3]}} </td>
                                        <td>{{$ppaps[4]}} </td>
                                        <td>{{$ppaps[5]}} </td>
                                        <td>{{$ppaps[6]}} </td>
                                        <td>{{$ppaps[15]}} </td>
                                        <td>{{$ppaps[16]}} </td>
                                        <td>{{$ppaps[7]}} </td>
                                        <td>{{$ppaps[8]}} </td>
                                        <td>{{$ppaps[9]}} </td>
                                        <td>{{$ppaps[10]}} </td>
                                        <td>{{$ppaps[11]}} </td>
                                        <td>{{$ppaps[12]}} </td>
                                        <td>{{$ppaps[13]}} </td>

                                    </tr>

                                @endforeach
                            @endif

                        </tbody>


                    </table>
                </div>
            </div>
        </div>
@endsection

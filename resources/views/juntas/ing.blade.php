@extends('layouts.main')

@section('contenido')
    <script>
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
@endsection

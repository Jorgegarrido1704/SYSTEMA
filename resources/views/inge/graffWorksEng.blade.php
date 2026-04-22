@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4 text-center">
    <h1 class="h3 mb-0 text-gray-800 ">{{__('Gantt Work Graph')}}</h1>
</div>

<div id="contenedor-graficas" class="row"></div>


<script>

    const datosRaw = {!! json_encode($datos) !!};
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('dash/js/gandGraph.js')}}"></script>
@endsection

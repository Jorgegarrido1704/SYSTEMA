
 @extends('layouts.main')

@section('contenido')
 <script src="{{ asset('dash/js/oee/graficas.js') }}" defer></script>
 <meta http-equiv="refresh" content="180">
 
<div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>

<div class='row'>
    <div class="col-xl-12 col-lg-12">
        <div class="form-group">
            <label for="fecha" class="col-form-label">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" onchange="cargarGraficas()">
        </div>
    </div>
    <div class="col-xl-6 col-lg-6">
       <h1 class="h3 mb-0 text-gray-800 text-center">OEE: <strong ><span id="oee"></span>%</strong></h1>
       <div class="text-center " id="graficaOee">
       
       </div>
    </div>

<div>
    <input type="hidden" name="cortes" id="cortes" >
    <input type="hidden" name="rendimiento" id="rendimiento" >
    <input type="hidden" name="disponibilidad" id="disponibilidad" >
    <input type="hidden" name="calidad" id="calidad" >
</div>
</div>
@endsection
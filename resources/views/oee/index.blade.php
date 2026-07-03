
 @extends('layouts.main')

@section('contenido')
 <script src="{{ asset('dash/js/oee/graficas.js') }}" defer></script>


<div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>

<div class='row'>
    <div class="col-xl-12 col-lg-12">
        <div class="form-group">
            <label for="fecha" class="col-form-label">Fecha:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" onchange="cargarGraficas()">
        </div>
    </div>
    <div class="col-xl-12 col-lg-12">
       <h1 class="h3 mb-0 text-gray-800 text-center tex">OEE: <strong ><span id="oee"></span>%</strong></h1>
    </div>

    <div class="col-xl-4 col-lg-4">
        <div class="text-center " id="graficaDisponibilidad">  </div>
    </div>
    <div class="col-xl-4 col-lg-4">
        <div class="text-center " id="graficaRendimiento">  </div>
    </div>

    <div class="col-xl-4 col-lg-4">
        <div class="text-center " id="graficaCalidad">  </div>
    </div>

<div>
    <input type="hidden" name="cortes" id="cortes" >
    <input type="hidden" name="rendimiento" id="rendimiento" >
    <input type="hidden" name="disponibilidad" id="disponibilidad" >
    <input type="hidden" name="calidad" id="calidad" >
</div>
</div>
@endsection

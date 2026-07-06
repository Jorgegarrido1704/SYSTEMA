
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
<br>
<div class="row">
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Top 3 Defectos Calidad</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <thead>
                            <tr><th>#</th><th>Defecto</th><th>Cantidad</th></tr>
                        </thead>
                        <tbody id="topDefectosBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Top 3 Motivos Paros</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <thead>
                            <tr><th>#</th><th>Paro</th><th>Minutos</th></tr>
                        </thead>
                        <tbody id="topDefectosBody"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 mb-4" style="display: none;">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detalle de Calidad</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height:300px; overflow-y:auto;">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr><th>Máquina</th><th>Defecto</th><th>Cant.</th><th>Fecha</th></tr>
                            </thead>
                            <tbody id="tablaCalidadBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 mb-4" style="display: none;">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Paros Registrados</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height:300px; overflow-y:auto;">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr><th>Máquina - Motivo</th><th>Minutos</th></tr>
                            </thead>
                            <tbody id="tablaParosBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection

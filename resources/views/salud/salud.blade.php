@extends('layouts.main')

@section('contenido')
<script src="{{ asset('/dash/js/empleados.js')}}"></script>
<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-10">

        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h5 class="m-0 font-weight-bold text-primary">Registro de Visistas </h5>
        </div>

        <!-- table Body -->
        <div class="card-body" >
            <form class="row g-3" action="{{route('visita_enfermeria')}}" method="POST">
                @csrf
                <div class="col-md-2">
                    <label for="fecha" class="form-label text-dark">Fecha</label>
                </div>
                <div class="col-md-2">
                   <input type="text" name="fecha" id="fecha">
                </div>
                <div class="col-md-4 "></div>
                <div class="col-md-4 "><label for="folio" class="form-label text-dark">Folio <span>{{$folio}}</span></label></div>
                <div class="col-md-3 ">
                  <label for="nomEmp" class="form-label">Numero de empleado</label>
                  <input type="number" class="form-control " id="nomEmp" name="nomEmp" required onchange="buscarempleado()">

                </div>
                <div class="col-md-9 ">
                  <label for="nombreEmp" class="form-label">Nombre de empleado</label>
                  <input type="text" class="form-control " id="nombreEmp" name="nombreEmp" required>
                </div>
                <div class="col-md-4">
                  <label for="cargo" class="form-label">Cargo</label>
                  <input type="text" class="form-control " id="cargo" name="cargo" required>
                </div>
                <div class="col-md-4">
                  <label for="area" class="form-label">Area</label>
                  <input type="text" class="form-control " id="area" name="area"  >
                </div>
                <div class="col-md-4">
                  <label for="supervisor" class="form-label">supervisor</label>
                  <input type="text" class="form-control " id="supervisor" name="supervisor" required>
                </div>
                <div class="col-md-4">
                    <label for="motivo" class="form-label">Motivo consulta</label>
                    <textarea name="motivo" id="motivo" cols="50" rows="3"></textarea>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-4">
                    <label for="comentarios" class="form-label">Comentarios</label>
                    <textarea name="comentarios" id="comentarios" cols="50" rows="3"></textarea>
                </div>
                <div class="col-md-12">
                    <label for="recomendaciones" class="form-label">Medicamentos </label>
                    <button type="button" class="btn btn-success" onclick="agregarMedicamento()">Agregar</button>
                </div>
                <div id="medicamentos"></div>
                <div class="col-md-12">  </div>
                <div class="col-12">

                  <button class="btn btn-primary" type="submit">Submit form</button>
                </div>
              </form>


       </div>
    </div>
</div>
@endsection

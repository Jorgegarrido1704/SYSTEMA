@extends('layouts.main')

@section('contenido')
 <div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

 <div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Agregar una accion correctiva</h6>
            </div>

            <div class="card-body">
              <form action="{{ route('accionesCorrectivas.create') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5" >
                        <label for="fechaAccion">Fecha de deteccion</label>
                        <input type="date" class="form-control" id="fechaAccion" name="fechaAccion" required>
                    </div>
                    <div class="col-md-2" >
                        <label for="folioAccion">Folio</label>
                        <input type="text" class="form-control" id="folioAccion" name="folioAccion" value="@if(!empty($accionesActivas->last()->id_acciones_correctivas)) {{$accionesActivas->last()->id_acciones_correctivas + 1}} @else {{'1'}}@endif" readonly>
                    </div>
                    <div class="col-md-5" >
                            <label for="Afecta">Proceso al que afecta</label>
                            <select class="form-control" id="Afecta" name="Afecta" required>
                                <option value="" disabled selected>Seleccione un proceso</option>
                                <option value="Proceso 1">Proceso 1</option>
                                <option value="Proceso 2">Proceso 2</option>
                                <option value="Proceso 3">Proceso 3</option>
                            </select>
                        </div>
                </div>
                <div class="row mt-3">
                        <div class="col-md-6" >
                            <label for="origenAccion">Origen de la accion</label>
                            <textarea class="form-control" id="origenAccion" name="origenAccion" rows="2" required></textarea>
                        </div>
                        <div class="col-md-6" >
                            <label for="resposableAccion">Responsable de la accion</label>
                            <input type="text" class="form-control" name="resposableAccion" id="resposableAccion" required>
                        </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12" >
                        <label for="descripcionAccion">Descripcion de la accion</label>
                        <textarea class="form-control" id="descripcionAccion" name="descripcionAccion" rows="4" required></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6" >
                        <label for="fechaCompromiso">Fecha de compromiso</label>
                        <input type="date" class="form-control" id="fechaCompromiso" name="fechaCompromiso" required>
                    </div>
                    <div class="col-md-6 mt-4 lt-3"  >
                        <button type="submit" class="btn btn-success">Guardar</button>

                    </div>
                </div>
              </form>
            </div>
            </div>

    </div>
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Acciones Correctivas Activas</h6>
            </div>

            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-bordered" id="accionesCorrectivasTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha de Deteccion</th>
                            <th>Proceso Afectado</th>
                            <th>Origen de la Accion</th>
                            <th>Responsable</th>
                            <th>Descripcion</th>
                            <th>Fecha de Compromiso</th>
                            <th>Status</th>
                            <th>Dias Restantes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($accionesActivas->count() > 0)
                            @foreach($accionesActivas as $accion)
                                <tr>
                                    <td>{{ $accion->id_acciones_correctivas }}</td>
                                    <td>{{ $accion->fechaAccion->format('Y-m-d') }}</td>
                                    <td>{{ $accion->Afecta }}</td>
                                    <td>{{ $accion->origenAccion }}</td>
                                    <td>{{ $accion->resposableAccion }}</td>
                                    <td>{{ $accion->descripcionAccion }}</td>
                                    <td>{{ $accion->fechaCompromiso->format('Y-m-d') }}</td>
                                    <td>{{ $accion->status }}</td>
                                    <td>{{ $diasRestantes[$accion->id_acciones_correctivas] ?? 0 }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            </div>
    </div>
 </div>
@endsection

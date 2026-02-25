@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
 <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
        mermaid.initialize({ startOnLoad: true });
    </script>
    <script src="{{ asset('dash/js/accionesCorrectivas.js') }}"></script>

    <div class="row">
        <!-- Detalles de la Accion Correctiva -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detalles de la Accion Correctiva</h6>
                </div>
                <div class="card-body" style="overflow-y: auto; max-height: 460px;">
                    <div class="row">
                        <div class="col-md-3" >
                           <span class="font-weight-bold">Folio:<br> {{ $registroPorquest->folioAccion }}</span>
                        </div>
                         <div class="col-md-3" >
                           <span class="font-weight-bold">Fecha de Detección: <br> {{ $registroPorquest->fechaAccion }}</span>
                        </div>
                         <div class="col-md-3" >
                           <span class="font-weight-bold">Proceso Afectado:<br> {{ $registroPorquest->Afecta }}</span>
                        </div>
                         <div class="col-md-3" >
                           <span class="font-weight-bold">Origen de la Acción: <br>{{ $registroPorquest->origenAccion }}</span>
                        </div>
                        <div class="col-md-4" >
                           <span class="font-weight-bold">Responsable de la Acción: <br>{{ $registroPorquest->resposableAccion }}</span>
                        </div>
                         <div class="col-md-8" >
                           <span class="font-weight-bold">Descripción de la Acción: {{ $registroPorquest->descripcionAccion }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- END Detalles de la Accion Correctiva -->
        <!-- Analisis de causa raiz -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Analisis de causa raiz</h6>
                </div>
                <div class="card-body"  style="overflow-y: auto; max-height: 460px;">
                     @if(!empty($categorias))
                     <div class="row">
                       
                        @foreach ($categorias as  $ctas => $causas)
                         <div class="col-md-6" >
                           <span class="font-weight-bold">Porque {{$ctas + 1}} :<br> {{$causas}}</span>
                        </div>
                        @endforeach
                        <div class="col-md-6" >
                           <span class="font-weight-bold">Es Sistemico:<br> @if($registroPorquest->IsSistemicProblem ==1) Si @else No @endif</span>
                        </div>
                        <div class="col-md-12" >
                           <span class="font-weight-bold">Conclusiones:<br> {{$registroPorquest->conclusiones}}</span>
                        </div>
                     
                     </div>
                    @else
                        <p>Como desea registrar su causa raiz</p>
                        <div class='row'>
                            <div class="col-lg-6 col-md-6 mb-4" max-height="400px">
                               <button type="button" class="btn btn-outline-primary" onclick="mostrarAccionesCorrectivas(1);">5 porques</button>
                               <button type="button" class="btn btn-outline-info" onclick="mostrarAccionesCorrectivas(2);">Ishikawa</button>
                            </div>
                            <br>
                            <div  id="5porque" style="display: none;">
                                <div class=row>
                                    <form action="{{ route('accionesCorrectivas.guardarPorques') }}" method="POST" id="form5porque">
                                        @csrf
                                            <div class="col-12 mb-3">
                                                <label for="porque1">Porque?</label>
                                                <textarea class="form-control" name="porque1" id="porque1"  cols="55" row="3" required></textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label for="porque2">Porque?</label>
                                                <textarea class="form-control" name="porque2" id="porque2"  cols="55" row="3"></textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label for="porque3">porque?</label>
                                                <textarea class="form-control" name="porque3" id="porque3"  cols="55" row="3"></textarea>
                                            </div>
                                            <div class="col-12  mb-3">
                                                <label for="porque4">Porque?</label>
                                                <textarea class="form-control" name="porque4" id="porque4"  cols="55" row="3"></textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label for="porque5">porque?</label>
                                                <textarea class="form-control" name="porque5" id="porque5"  cols="55" row="3"></textarea>
                                            </div>
                                            <div class="col-9 mb-3">
                                                    <label for="conclusion">Conclusiones</label>
                                                    <textarea class="form-control" name="conclusion" id="conclusion"  cols="55" row="4" required></textarea>
                                            </div>
                                                 <div class="col-3 mb-3">
                                                    <label for="sistemic">Es sistemico?</label>
                                                   <select name="sistemic" id="sistemic" required>
                                                       <option value="" selected disabled>...</option>
                                                       <option value="SI">SI</option>
                                                       <option value="NO">NO</option>
                                                   </select>
                                                   <input type="hidden" name="accion_id" value="{{ $registroPorquest->folioAccion?? '' }}">
                                            </div><div class="col-12 mb-3">
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                            <div  id="ishikawa" style="display: none;">
                                <div class="row">
                                    <form action="{{ route('accionesCorrectivas.guardarIshikawa') }}" method="POST">
                                        @csrf
                                        <div class="col-12 mb-3">
                                            <label for="problema1">Problema</label>
                                            <input type="text" name="problema1" id="problema1" required>
                                        </div><div class="col-12 mb-3">
                                            <label for="motivo1">Motivo</label>
                                            <textarea class="form-control" name="motivo1" id="motivo1"  cols="55" row="3" required></textarea>
                                            </div><div class="col-12 mb-3">
                                            <label for="problema2">Problema</label>
                                            <input type="text" name="problema2" id="problema2">
                                        </div><div class="col-12 mb-3">
                                            <label for="motivo2">Motivo</label>
                                            <textarea class="form-control" name="motivo2" id="motivo2"  cols="55" row="3"></textarea>
                                            </div><div class="col-12 mb-3">
                                            <label for="problema3">Problema</label>
                                            <input type="text" name="problema3" id="problema3">
                                        </div><div class="col-12 mb-3">
                                            <label for="motivo3">Motivo</label>
                                            <textarea class="form-control" name="motivo3" id="motivo3"  cols="55" row="3"></textarea>
                                            </div><div class="col-12 mb-3">
                                            <label for="problema4">Problema</label>
                                            <input type="text" name="problema4" id="problema4">
                                        </div><div class="col-12 mb-3">
                                            <label for="motivo4">Motivo</label>
                                            <textarea class="form-control" name="motivo4" id="motivo4"  cols="55" row="3"></textarea>
                                            </div><div class="col-12 mb-3">
                                            <label for="problema5">Problema</label>
                                            <input type="text" name="problema5" id="problema5">
                                        </div><div class="col-12 mb-3">
                                            <label for="motivo5">Motivo</label>
                                            <textarea class="form-control" name="motivo5" id="motivo5"  cols="55" row="3"></textarea>
                                            </div>
                                             <div class="col-9 mb-3">
                                                    <label for="conclusion">Conclusiones</label>
                                                    <textarea class="form-control" name="conclusion" id="conclusion"  cols="55" row="4" required></textarea>
                                            </div>   <div class="col-3 mb-3">
                                                    <label for="sistemic">Es sistemico?</label>
                                                     <select name="sistemic" id="sistemic" required>
                                                        <option value="" selected disabled>...</option>
                                                       <option value="SI">SI</option>
                                                       <option value="NO">NO</option>
                                                   </select>
                                                   <input type="hidden" name="accion_id" value="{{ $accion->folioAccion??'' }}">
                                            </div><div class="col-12 mb-3">
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>

                                    </form>
                                </div>
                            </div>

                        </div>
                            @endif

                </div>
            </div>
        </div>
        <!-- End Analisis de causa raiz -->
        <!-- Plan de accion -->
         <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Plan de accion</h6>
                </div>
                <div class="card-body" style="overflow-y: auto; height: 150px;">
                     <form action="{{ route('accionesCorrectivas.guardarAccion') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label for="accion" class="form-label font-weight-bold"><a>Descripcion de la accion:</a></label>
                                <textarea class="form-control" name="accion" id="accion" cols="45" rows="2" required></textarea>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="reponsableAccion" class="form-label font-weight-bold">Reponsable de la accion</label>
                                <select name="reponsableAccion" id="reponsableAccion" class="form-control"  required>
                                    <option value="" selected disabled>...</option>
                                   @foreach($personal as $p)
                                <option value="{{ $p->employeeLider }}">{{ $p->employeeLider }}</option>
                                @endforeach
                                </select>
                            </div>

                             <div class="col-1 mb-3">
                                <label for="fechaInicioAccion">Fecha de inicio</label>
                                <input type="date" name="fechaInicioAccion" id="fechaInicioAccion" required>
                            </div>
                            <div class="col-1 mb-3">
                                <label for="fechaFinAccion">Fecha de fin</label>
                                <input type="date" name="fechaFinAccion" id="fechaFinAccion" required>
                            </div>


                        <div class="col-2 mb-3">
                            <label for="verificadorAccion">Quien aprobara la accion</label>
                            <input type="text" name="verificadorAccion" id="verificadorAccion" value="Martin Aleman" readonly>

                        </div>
                        <div class="col-1 mb-3" >
                              <input type="hidden" name="id" value="{{$registroPorquest->folioAccion}}" id="id">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                     </form>

                </div>
            </div>
        </div>
        <!-- End Plan de accion -->
          @if(!empty($acciones))
       @foreach ($acciones as $accion )
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Registro de accion Correctiva {{$accion->id}}
                </h6>
            </div>
            <div class="card-body" style="overflow-y: auto; height: 260px;">
                <div class="row">
                    <div class="col-md-4" >
                        <span class="font-weight-bold">Reponsable de la accion:<br> {{$accion->resposableSubAccion}}</span>
                    </div>
                    <div class="col-md-2" >
                        <span class="font-weight-bold">Fecha de inicio:<br> {{$accion->fechaInicioSubAccion}}</span>
                    </div>
                    <div class="col-md-2" >
                        <span class="font-weight-bold">Fecha de inicio:<br> {{$accion->fechaInicioSubAccion}}</span>
                    </div>
                    <div class="col-md-4" >
                        <span class="font-weight-bold">Quien aprobara la accion:<br> {{$accion->auditorSubAccion}}</span>
                    </div>
                    <div class="col-md-12" >
                        <span class="font-weight-bold">Descripcion de la accion:<br> {{$accion->descripcionSubAccion}}</span>
                    </div>
                </div>
               
            </div>
        </div>
    </div>

    {{-- FORMULARIO INDEPENDIENTE POR CADA ID --}}
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Seguimiento y monitoreo de la ejecución</h6>
            </div>
            <div class="card-body" style="overflow-y: auto; height: 260px;">
                <form action="{{ route('accionesCorrectivas.guardarSeguimiento', ['id' => $accion->id, 'folio' => $accion->folioAccion]) }}" method="GET" id="form-{{$accion->id_acciones_correctivas}}" name="form-{{$accion->id_acciones_correctivas}}">

                    <div class="row">
                        <div class="col-4 mb-3">
                            <label for="seguimiento_{{$accion->folioAccion}}" class="form-label font-weight-bold">
                                Descripcion de Seguimiento:
                            </label>
                            <textarea class="form-control" name="seguimiento" id="seguimiento_{{$accion->folioAccion}}" cols="45" rows="2"></textarea>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="ValidadorSeguimiento_{{$accion->folioAccion}}" class="form-label font-weight-bold">
                                Responsable de la validación
                            </label>
                            <input type="text" class="form-control" name="validador" id="ValidadorSeguimiento_{{$accion->folioAccion}}" placeholder="Martin Aleman">
                        </div>
                        <div class="col-1 mb-3">
                            <button type="submit" class="btn btn-primary mt-4">Guardar</button>
                        </div>
                    </div>
                </form>

                </div>
            </div>

    </div>
@endforeach

          @endif
           <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Registros de monitoreos por accion</h6>
                </div>
                <div class="card-body" style="overflow-y: auto; max-height: 460px;">
                    <table class="table table-bordered" id="seguimientosTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Folio de accion</th>
                                <th>Id de sub accion</th>
                                <th>Descripcion del seguimiento</th>
                                <th>Aprobador del seguimiento</th>
                                <th>Fecha del seguimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($seguimientosSubAcciones->count() > 0)
                                @foreach($seguimientosSubAcciones as $seguimiento)
                                    <tr>
                                        <td>{{ $seguimiento->folioAccion }}</td>
                                        <td>{{ $seguimiento->idSubAccion }}</td>
                                        <td>{{ $seguimiento->descripcionSeguimiento }}</td>
                                        <td>{{ $seguimiento->AprobadorSeguimiento }}</td>
                                        <td>{{ $seguimiento->created_at }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">No hay seguimientos registrados para esta acción.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
           </div>

    </div>
@endsection

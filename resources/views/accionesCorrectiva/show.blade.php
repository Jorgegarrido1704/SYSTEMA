@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
 <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
        mermaid.initialize({ startOnLoad: true });
    </script>
    <script src="{{ asset('dash/js/accionesCorrectivas.js') }}"></script>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detalles de la Accion Correctiva</h6>
                </div>
                <div class="card-body">
                    <p><strong>Folio:</strong> {{ $accion->folioAccion }}</p>
                    <p><strong>Fecha de Detección:</strong> {{ $accion->fechaAccion->format('Y-m-d') }}</p>
                    <p><strong>Proceso Afectado:</strong> {{ $accion->Afecta }}</p>
                    <p><strong>Origen de la Acción:</strong> {{ $accion->origenAccion }}</p>
                    <p><strong>Responsable de la Acción:</strong> {{ $accion->resposableAccion }}</p>
                    <p><strong>Descripción de la Acción:</strong> {{ $accion->descripcionAccion }}</p>

                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Analisis de causa raiz</h6>
                </div>
                <div class="card-body">
                     @if(!empty($categorias))
                        @foreach ($categorias as  $ctas => $causas)
                        <p>{{$ctas}} :</p>

                        <p>{{$causas}}</p>


                        @endforeach
                        <p>Concluciones: </p>
                        <p>{{$accion->conclusiones}}</p>
                        <p>Es Sistemico: </p>
                        <p>@if($accion->IsSistemicProblem ==1) Si @else No @endif </p>

                    @else
                        <p>Como desea registrar su causa raiz</p>
                        <div class='row'>
                            <div class="col-lg-6 col-md-6 mb-4">
                               <button type="button" class="btn btn-outline-primary" onclick="mostrarAccionesCorrectivas(1);">5 porques</button>
                               <button type="button" class="btn btn-outline-info" onclick="mostrarAccionesCorrectivas(2);">Ishikawa</button>
                            </div>
                            <br>
                            <div  id="5porque" style="display: none;">
                                <div class=row>
                                    <form action="{{ route('accionesCorrectivas.guardarPorques') }}" method="POST">
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
                                            </div> <div class="col-3 mb-3">
                                                    <label for="sistemic">Es sistemico?</label>
                                                   <input type="checkbox" name="sistemic" id="sistemic" >
                                                   <input type="hidden" name="accion_id" value="{{ $accion->id_acciones_correctivas }}">
                                            </div>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                            <div  id="ishikawa" style="display: none;">
                                <div class="row">
                                    <form action="#" method="POST">
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
                                            </div class="col-3 mb-3">
                                                    <label for="sistemic">Es sistemico?</label>
                                                   <input type="checkbox" name="sistemic" id="sistemic" required>
                                                    <input type="hidden" name="accion_id" value="{{ $accion->id_acciones_correctivas }}">
                                            </div>
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

@endsection

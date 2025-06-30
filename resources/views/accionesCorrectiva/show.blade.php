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
                    <p><strong>Folio:</strong> {{ $accion->id_acciones_correctivas }}</p>
                    <p><strong>Fecha de Detección:</strong> {{ $accion->fechaAccion->format('Y-m-d') }}</p>
                    <p><strong>Proceso Afectado:</strong> {{ $accion->Afecta }}</p>
                    <p><strong>Origen de la Acción:</strong> {{ $accion->origenAccion }}</p>
                    <p><strong>Responsable de la Acción:</strong> {{ $accion->resposableAccion }}</p>
                    <p><strong>Descripción de la Acción:</strong> {{ $accion->descripcionAccion }}</p>
                    <p><strong>Fecha de Compromiso:</strong> {{ $accion->fechaCompromiso->format('Y-m-d') }}</p>
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
                        <pre class="mermaid">
                    {{ $mermaid }}
                        </pre>
                    @else
                        <p>Como desea registrar su causa raiz</p>
                        <div class='row'>
                            <div class="col-lg-6 col-md-6 mb-4">
                               <button type="button" class="btn btn-outline-primary" onclick="mostrarAccionesCorrectivas(1);">5 porques</button>
                               <button type="button" class="btn btn-outline-info" onclick="mostrarAccionesCorrectivas(2);">Ishikawa</button>
                            </div>
                            <div  id="5porque">
                            </div>
                            <div  id="ishikawa">
                            </div>

                        </div>
                            @endif

                </div>
            </div>
    </div>

@endsection

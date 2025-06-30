@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

    <div class="row">
        <div class="col-lg-12 mb-4">
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

@endsection

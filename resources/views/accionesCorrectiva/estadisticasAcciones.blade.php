@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Estadísticas de Acciones Correctivas</h1>
</div>

<div class="row text-center mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-primary text-white font-weight-bold py-2">
                Total Acciones
            </div>
            <div class="card-body d-flex align-items-center justify-content-center py-4">
                <h2 class="display-4 font-weight-bold text-primary mb-0">{{$totalAcciones}}</h2>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-success text-white font-weight-bold py-2">
                Cerradas
            </div>
            <div class="card-body d-flex align-items-center justify-content-center py-4">
                <h2 class="display-4 font-weight-bold text-success mb-0">{{$cerradas}}</h2>
            </div>
        </div>
    </div>



    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header text-white font-weight-bold py-2" style="background-color: #d97724;">
                Abiertas
            </div>
            <div class="card-body d-flex align-items-center justify-content-center py-4">
                <h2 class="display-4 font-weight-bold mb-0" style="color: #d97724;">{{$abiertas}}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row text-center mb-4">
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header text-white font-weight-bold py-2" style="background-color: #721c24;">
                Vencidas
            </div>
            <div class="card-body d-flex align-items-center justify-content-center py-4">
                <h2 class="display-4 font-weight-bold mb-0" style="color: #721c24;">{{$vencidas}}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header text-white font-weight-bold py-2" style="background-color: #1e5631;">
                % Cumplimiento
            </div>
            <div class="card-body d-flex align-items-center justify-content-center py-4">
                <h2 class="display-4 font-weight-bold mb-0" style="color: #1e5631;">{{$porcentajeCumplimiento}}%</h2>
            </div>
        </div>
    </div>
</div>


@endsection

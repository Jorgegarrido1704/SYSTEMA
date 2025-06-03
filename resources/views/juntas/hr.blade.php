@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
<style>
    #fullscreenPreview {
    transition: opacity 5s ease-in-out;
}
#accidente {
   color:rgba(0, 0, 0, 0.95);
   size: 14px;
   font-style: oblique;
   font: bold;
    }
</style>
<script>
    const registros = @json($registrosDeAsistencia);
    const genero = @json($genero);
</script>
<div class="row">
    <!-- Asistencia -->
    <div class="col-lg-4 col-md-4 mb-4">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Today assistence {{ date('Y-m-d') }} Faltan por registro: {{ $faltan }}</h5>
            </div>
            <div class="card-body" style="overflow-y: auto;">
                <canvas id="assistence"></canvas>
            </div>
        </div>
    </div>

    <!-- Diversidad -->
    <div class="col-lg-4 col-md-4 mb-4">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Diversidad</h5>
            </div>
            <div class="card-body" style="overflow-y: auto;">
                <canvas id="diversidad"></canvas>
            </div>
        </div>
    </div>

    <!-- Vacaciones -->
    <div class="col-lg-4 col-md-4 mb-4">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Vacaciones en 2025</h5>
            </div>
            <div class="card-body">
                <canvas id="vacations"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 mb-8">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Rotación</h5>
            </div>
            <div class="card-body " style="overflow-y: auto; ">
                <div class="row" >
                        <div class="col-lg-4 col-md-4 mb-8">
                        <div >
                            <canvas id="rotation0"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-4">
                        <div >
                            <canvas id="rotation1"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-4">
                        <div >
                            <canvas id="rotation2"></canvas>
                        </div>
                    </div>

            </div>
        </div>

    </div>
     <div class="col-lg-6 col-md-6 mb-8">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Faltantes de registros de asistencia</h5>
            </div>
            <div class="card-body " style="overflow-y: auto; ">
               <ul>
                    @foreach ($faltantes as $faltante)
                        <li>
                            <span class="badge badge-danger text-white font-weight-bold fond-size-20">{{ $faltante->lider }}</span>

                        </li>
                    @endforeach
               </ul>

            </div>
        </div>

    </div>
</div>

@endsection

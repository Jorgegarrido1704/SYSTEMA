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
    const tipoTrabajador = @json($tipoTrabajador);
    const promaus = @json($promaus);
</script>
<div class="row">
    <!-- Asistencia -->
    <div class="col-lg-4 col-md-4 mb-4">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Today assistence {{ date('Y-m-d') }} Faltan por registro: {{ $faltan }}</h5>
            </div>
            <div class="card-body" style=" max-height: 450px;">
                <canvas id="assistence" style=" height: 400px;"></canvas>
            </div>
        </div>
    </div>


    <!-- Vacaciones -->
    <div class="col-lg-8 lg-8 mb-4 ">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Vacaciones en 2025</h5>
            </div>
            <div class="card-body" style=" max-height: 450px;" >
                <canvas id="vacations" style=" height: 400px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-8 mb-8">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Rotación</h5>
            </div>

            <div class="card-body "  style="overflow-y: auto; max-height: 450px;">
                <div class="row" >
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="text-center font-weight-bold text-dark">
                            <p >Rotacion</p>
                        </div>
                        <div >
                            <canvas id="rotation0"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="text-center font-weight-bold text-dark">
                            <p >Diversidad</p>
                        </div>
                        <div >
                            <canvas id="rotation1"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-4">
                         <div class="text-center font-weight-bold text-dark">
                            <p >Ausentismo</p>
                        </div>
                        <div >
                            <canvas id="rotation2"></canvas>
                        </div>
                    </div>
                     <div class="col-lg-6 col-md-6 mb-4">
                        <div class="text-center font-weight-bold text-dark">
                            <p >Ratios</p>
                        </div>
                        <div >
                            <canvas id="rotation3"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
     <div class="col-lg-4 col-md-4 mb-8">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Faltantes de registros de asistencia: {{ $diaActual}}</h5>
            </div>

            <div class="card-body " style="overflow-y: auto;  max-height: 450px;">
               <ul>
                    @foreach ($faltantes as $faltante)
                        <li>
                            <span class="badge badge-danger text-white font-weight-bold fond-size-20">{{ $faltante }}</span>

                        </li>
                    @endforeach
               </ul>

            </div>
        </div>
    </div>
</div>

@endsection

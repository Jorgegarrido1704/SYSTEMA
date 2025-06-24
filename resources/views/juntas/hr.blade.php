@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
    <!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
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
    .text-wine {
  color: #722f37; /* ejemplo de color vino */
}
.text-gray {
  color: #473e3f; /* ejemplo de color vino */
}
a:hover {
    text-decoration: none;
}

</style>
<script>
    const registros = @json($registrosDeAsistencia);
    console.log(registros);
    const genero = @json($genero);
    const tipoTrabajador = @json($tipoTrabajador);
    const promaus = @json($promaus);
</script>
<div class="row">
    <!-- Asistencia -->
    <div class="col-lg-5 col-md-5 mb-4">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Today assistence {{ date('Y-m-d') }} Faltan por registro: {{ $faltan }}</h5>
            </div>
            <div class="card-body" style=" max-height: 450px;">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <table class="table table-borderless item-center">
                           <tr>
                            <td class="font-weight-bold text-success font-size-24"><a class ="text-success" href="{{ route('DatosRh', ['id' => 'OK']) }}">Asistencia</a></td>
                            <td class="font-weight-bold font-size-24">{{$registrosDeAsistencia[0]}}</td>
                           </tr>
                           <tr>
                            <td class="font-weight-bold text-danger font-size-24"><a class ="text-danger" href="{{ route('DatosRh', ['id' => 'F']) }}">Faltas</a> </td>
                            <td class="font-weight-bold font-size-24">{{$registrosDeAsistencia[1]}}</td>
                           </tr>
                           <tr>
                            <td class="font-weight-bold text-warning font-size-24"><a class ="text-warning" href="{{ route('DatosRh', ['id' => 'INC']) }}">Incapacidad</a></td>
                            <td class="font-weight-bold font-size-24">{{$registrosDeAsistencia[2]}}</td>
                           </tr>
                           <tr>
                            <td class="font-weight-bold text-primary font-size-24"><a class ="text-primary" href="{{ route('DatosRh', ['id' => 'P']) }}">Permisos</a></td>
                            <td class="font-weight-bold font-size-24">{{$registrosDeAsistencia[3]}}</td>
                           </tr>
                           <tr>
                            <td class="font-weight-bold text-primary font-size-24"><a class ="text-primary" href="{{ route('DatosRh', ['id' => 'V']) }}">Vacaciones</a></td>
                            <td class="font-weight-bold font-size-24">{{$registrosDeAsistencia[4]}}</td>
                           </tr>
                           <tr>
                            <td class="font-weight-bold text-danger font-size-24"><a class ="text-danger" href="{{ route('DatosRh', ['id' => 'R']) }}">Retardos</a></td>
                            <td class="font-weight-bold font-size-24">{{$registrosDeAsistencia[5]}}</td>
                           </tr>
                           <tr>
                            <td class="font-weight-bold text-wine font-size-24"><a class ="text-wine" href="{{ route('DatosRh', ['id' => 'SUS']) }}">Suspension</a></td>
                            <td class="font-weight-bold font-size-24">{{$registrosDeAsistencia[6]}}</td>
                           </tr>
                           <tr>
                            <td class="font-weight-bold text-gray font-size-24"><a class ="text-gray" href="{{ route('DatosRh', ['id' => 'PCT']) }}">Practicantes</a></td>
                            <td class="font-weight-bold font-size-24">{{$registrosDeAsistencia[7]}}</td>
                           </tr>
                        </table>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <canvas id="assistence" style=" height: 400px;"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Vacaciones -->
    <div class="col-lg-7 lg-7 mb-4 ">
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

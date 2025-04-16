@extends('layouts.main')

@section('contenido')
<script>const actividades =  {!! json_encode($actividades) !!};
const actividadesLastMonth =  {!! json_encode($actividadesLastMonth) !!};
const jesus =  {!! json_encode($jesus) !!};
const paos =  {!! json_encode($pao) !!};
const nancy =  {!! json_encode($nancy) !!};
console.log(nancy);
const ale =  {!! json_encode($ale) !!};
const carlos =  {!! json_encode($carlos) !!};
const arturo =  {!! json_encode($arturo) !!};
const jorge =  {!! json_encode($jorge) !!};
const brandon =  {!! json_encode($brandon) !!};

   // console.log(actividades);
</script>
    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

    <div class="row">
        <div class="table-responsive">
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="card shadow mb-4">

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary"> Tiempos de trabajo </h5>

                    </div>

                    <!-- table Body -->
                    <div class="card-body" style="overflow-y: auto; height: 400px;">
                        <canvas id="tiempos"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@extends('layouts.main')

@section('contenido')
<script>const actividades =  {!! json_encode($actividades) !!};
    console.log(actividades);
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



@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
 @if(!empty(session('message')))
 <div class="alert alert-success alert-dismissible fade show" role="alert">
     {{ session('message') }}
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
     </button>
 </div>
 @endif
 <div class="row">
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                    <h6 class="m-0 font-weight-bold text-primary">Request Crimp Tooling Analysis</h6>
                </div>
                <!-- table Body -->
                <div class="card-body"style="overflow-y: auto; height: 350px;">  
                    <div class="row"> 
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="row">   
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Waiting for work</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$promedioespera}}</div>
                                                </div>                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Time of Working avergage</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$timeWorking}}</div>
                                                </div>                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Total Time Setup Avergage</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $totalTimesAVG }}
                                                    </div>
                                                </div>                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Total Setup works</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $totalDeTrabajos }}
                                                    </div>
                                                </div>                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Total time in setup</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{round(($totalTimesAVG*$totalDeTrabajos)/60, 2)}}</div>
                                                </div>                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 mb-4">
                            <table class="table  table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Top 10 most requiring tooling</th>
                                        <th scope="col" class="text-center">Times</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tooling as $tool)
                                    <tr>
                                        <td class="text-center text-success font-weight-bold">{{$tool->nombreEquipo}}</td>
                                        <td class="text-center text-primary font-weight-bold">{{$tool->tiemposVal}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>
<div class = "row">

                        <div class="col-xl-12 col-md-12 mb-4">
                            <input class="form-control form-control-lg" type="date" id="fecha_de_revision" name="fecha_de_revision" onchange="relog_data(this.value)">
                            <table class="table  table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"><strong>Tecnico herramentales</strong></th>
                                        <th scope="col" class="text-center"><strong>Equipo usado</strong></th>
                                        <th scope="col" class="text-center"><strong>Fecha y hora de solucitud</strong></th>
                                        <th scope="col" class="text-center"><strong>Tiempo de respuesta a operador</strong></th>
                                        <th scope="col" class="text-center"><strong>Tiempo de incio</strong></th>
                                        <th scope="col" class="text-center"><strong>Tiempo de fin</strong></th>
                                        <th scope="col" class="text-center"><strong>Tiempo del mantenimineto</strong></th>
                                        <th scope="col" class="text-center"><strong>Tiempo total</strong></th>
                                    </tr>
                                </thead>
                                <tbody id="registro_por_tecnico">        
                                </tbody>
                            </table>
                        </div>
</div>
<script>
    async function relog_data(fecha) {
        const tbody = document.getElementById('registro_por_tecnico');
        const url = new URL(@json(url('/herramentales/tiempos_operador')));

        if (fecha) {
            url.searchParams.set('fecha_de_revision', fecha);
        }

        function mostrarMensaje(mensaje) {
            tbody.replaceChildren();
            const celda = tbody.insertRow().insertCell();
            celda.colSpan = 4;
            celda.className = 'text-center';
            celda.textContent = mensaje;
        }

        mostrarMensaje('Consultando…');

        try {
            function diffMin(inicio, fin) {
                if (!inicio || !fin) return '—';

                // Ambos valores usan el mismo horario y pueden venir con o sin segundos.
                const inicioMs = Date.parse(inicio.replace(' ', 'T') + 'Z');
                const finMs = Date.parse(fin.replace(' ', 'T') + 'Z');

                if (!Number.isFinite(inicioMs) || !Number.isFinite(finMs)) return '—';

                return Math.trunc((finMs - inicioMs) / 60000);
            }
            const respuesta = await fetch(url, {
                headers: { Accept: 'application/json' },
            });

            if (!respuesta.ok) {
                const error = await respuesta.json().catch(() => null);
                throw new Error(
                    error?.errors?.fecha_de_revision?.[0]
                    ?? `Error al consultar los registros (HTTP ${respuesta.status}).`
                );
            }

            const registros = await respuesta.json();

            if (registros.length === 0) {
                mostrarMensaje('No hay registros para la fecha consultada.');
                return;
            }

            tbody.replaceChildren();

            for (const registro of registros) {
                const fila = tbody.insertRow();
               fila.insertCell().textContent = registro.atiende ?? '—';
                fila.insertCell().textContent = registro.nombreEquipo ?? '—';
                fila.insertCell().textContent = registro.fecha ?? '—';
                fila.insertCell().textContent = diffMin(registro.fecha, registro.inimant);
                fila.insertCell().textContent = registro.inimant ?? '—';
                fila.insertCell().textContent = registro.finhora ?? '—';
                fila.insertCell().textContent = diffMin(registro.inimant, registro.finhora);
                fila.insertCell().textContent = diffMin(registro.fecha, registro.finhora);
            }
        } catch (error) {
            mostrarMensaje(error.message);
        }
    }

    relog_data(document.getElementById('fecha_de_revision').value);
</script>



 @endsection
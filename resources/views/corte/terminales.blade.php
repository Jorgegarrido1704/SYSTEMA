@extends('layouts.main')

@section('contenido')
 <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
<div class= "row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">{{ __('Rates') }} </h5>
            </div>
            <div class="card-body">
                <div class="row">
                     <div class="col-xl-2 col-md-2 mb-2">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                                      5760 {{ __('per shift (8 hours)') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-xl-2 col-md-2 mb-2">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                                      720 {{ __('per hour') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 mb-2">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                                        5 {{ __('Seconds per Terminal') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                </div>

            </div>
        </div>
    </div>
</div>
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">{{ __('Last update of terminals information') }} <strong>{{$day}}</strong></h5>
            </div>
            <div class="card-body">
                      <div class="row">
                                 <div class="col-xl-2 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                       {{__('Crimper')}} l3-1</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="l3-1"></span>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                       {{__('Crimper')}} l3-2</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="l3-2"></span>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                       {{__('Crimper')}} l3-3</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="l3-3"></span>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                       {{__('Crimper')}} l3-4</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="l3-4"></span>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                       {{__('Crimper')}} l2-1</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="l2-1"></span>


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                       {{__('Crimper')}} l2-2</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="l2-2"></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                       {{__('Crimper')}} l2-3</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="l2-3"></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                       {{__('Crimper')}} l2-4</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="l2-4"></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">{{ __('Last update of terminals information') }} <strong>{{$day}}</strong></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tabla-terminales" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>{{ __('Time Range') }}</th>
                                <th>{{ __('Crimper') }}</th>
                                <th>{{ __('Terminals Used') }}</th>
                                <th>{{ __('Minutes of Stop') }}</th>
                                <th>{{ __('Reason for Stop') }}</th>
                                <th>{{ __('Observations') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-terminales-body">
                            <!-- Aquí se llenará con JavaScript -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">{{ __('Total') }}</th>
                                <th id="total-conteo">0</th>
                                <th id="total-paro">0 min</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

    </div>


<script>
   function fetchTerminalData() {
    const url = @json(route('corte.appJointTerminales'));

    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log('Datos procesados:', data);

            // Lista de IDs de tus elementos en el HTML (l3-1, l3-2, etc.)
            const maquinas = ['l3-1', 'l3-2', 'l3-3', 'l3-4', 'l2-1', 'l2-2', 'l2-3', 'l2-4'];

            maquinas.forEach(id => {
                const elemento = document.getElementById(id);
                if (elemento) {
                    if (data[id]) {
                       
                        const conteo = data[id].total_terminales || 0;
                        const paro = data[id].total_paro || 0;

                        elemento.textContent = `${conteo} (Paro: ${paro} min)`;
                    } else {
                        elemento.textContent = '0 (Paro: 0 min)';
                    }
                }
            });
        })
        .catch(error => console.error('Error:', error));
}

setInterval(fetchTerminalData, 60000);
fetchTerminalData();
function fetchTerminalDataTabla() {
    const url = @json(route('corte.appJointTerminalesTabla'));
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tabla-terminales-body');
            tbody.innerHTML = ''; // Limpiar tabla antes de cargar

            let sumaTerminales = 0;
            let sumaParo = 0;

            data.forEach(reg => {
                // Sumar totales
                sumaTerminales += parseInt(reg.TerminalsUsed) || 0;
                sumaParo += parseInt(reg.minutesStop) || 0;

                // Crear fila
                const fila = `
                    <tr>
                        <td>${reg.startHour} - ${reg.endHour}</td>
                        <td>${reg.toolingCrimperName}</td>
                        <td>${reg.TerminalsUsed}</td>
                        <td>${reg.minutesStop}</td>
                        <td>${reg.reasonStop || 'Ninguno'}</td>
                        <td>${reg.observations || '-'}</td>
                    </tr>
                `;
                tbody.innerHTML += fila;
            });

            // Actualizar etiquetas de totales en el tfoot
            document.getElementById('total-conteo').textContent = sumaTerminales;
            document.getElementById('total-paro').textContent = sumaParo + ' min';
        })
        .catch(error => console.error('Error al obtener datos:', error));
}

// Ejecutar al cargar
fetchTerminalDataTabla();
// Opcional: Recargar cada 5 minutos
setInterval(fetchTerminalDataTabla, 300000);
</script>

 @endsection

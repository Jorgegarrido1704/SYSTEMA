@extends('layouts.main')

@section('contenido')
 <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
<div class= "row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary">{{ __('Rates') }} </h5>
                <nav class="d-none d-md-block">
                     <input type="date" id="fechasCrimping"  name="fechasCrimping" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" onchange="getData();">
                </nav>
            </div>
            <div class="card-body">
                <div class="row">

                                 <div class="col-xl-2 col-md-2 mb-2">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-black text-uppercase mb-1">
                                                     <strong> 720 </strong> {{ __('Terminals') }} {{ __('per hour / tooling') }}</div>
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
                                                    <div class="text-s font-weight-bold text-black text-uppercase mb-1">
                                                     <strong> 12 </strong> {{ __('Crimper applicators') }}</div>
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
                                                    <div class="text-s font-weight-bold text-black text-uppercase mb-1">
                                                     <strong> <span id="total-conteo"></span> </strong> {{ __('Terminals applied') }}</div>
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
                                                    <div class="text-s font-weight-bold text-black text-uppercase mb-1">
                                                     <strong> <span id="total-paro"></span> </strong> {{ __('Total Stops time') }}</div>
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
                                                    <div class="text-s font-weight-bold text-black text-uppercase mb-1">
                                                     <strong> <span id="Performance"></span> </strong> {{ __('Performance') }}</div>
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
                                                        <span id="L3-1"></span>


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
                                                       {{__('Crimper')}} L3-2</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="L3-2"></span>


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
                                                       {{__('Crimper')}} L3-3</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="L3-3"></span>


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
                                                       {{__('Crimper')}} L2-1</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="L2-1"></span>


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
                                                       {{__('Crimper')}} L2-2</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="L2-2"></span>
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
                                                       {{__('Crimper')}} L1-1</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="L1-1"></span>


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
                                                       {{__('Crimper')}} L1-2</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="L1-2"></span>
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
                                                       {{__('Crimper')}} L1-3</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="L1-3"></span>
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
                                                       {{__('Crimper')}} L1-4</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="L1-4"></span>
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
                                                       {{__('Crimper')}} L1-5</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="L1-5"></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- line 4 -->
                                 <div class="col-xl-2 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                                       {{__('Crimper')}} L4-1</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="L4-1"></span>


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
                                                       {{__('Crimper')}} L4-2</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <span id="L4-2"></span>
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
                                <th>{{ __('Stops Time (min)') }}</th>
                                <th>{{ __('Reason for Stop') }}</th>
                                <th>{{ __('Observations') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-terminales-body">
                            <!-- Aquí se llenará con JavaScript -->
                        </tbody>

                    </table>
                </div>

    </div>


<script>
    function getData() {
        fetchTerminalData();
        fetchTerminalDataTabla();
    }
   function fetchTerminalData() {
    const fecha = document.getElementById("fechasCrimping").value;
    const url = '/corte/appJointTerminales?fecha=' + encodeURIComponent(fecha);
    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log('Datos procesados:', data);
            // Lista de IDs de tus elementos en el HTML (L3-1, L3-2, etc.)
            const maquinas = ['L4-1', 'L4-2', 'L3-1', 'L3-2', 'L3-3', 'L2-1', 'L2-2', 'L1-1', 'L1-2', 'L1-3', 'L1-4', 'L1-5'];

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

function fetchTerminalDataTabla() {
    const fecha = document.getElementById("fechasCrimping").value;
    const url = '/corte/appJointTerminalesTabla?fecha=' + encodeURIComponent(fecha);

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
            // 720 * ((8 )-(sumaParo/60).toFixed(2)) * 16 / (720 * 8  * 16)
            const performance = (sumaTerminales/(720 * ((8  * 12) - sumaParo/60))*100).toFixed(2);
            document.getElementById('Performance').textContent = performance + '%';
        })
        .catch(error => console.error('Error al obtener datos:', error));
}

// Ejecutar al cargar
fetchTerminalDataTabla();
// Opcional: Recargar cada 5 minutos
setInterval(fetchTerminalDataTabla, 600000);
</script>

 @endsection

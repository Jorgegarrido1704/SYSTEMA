@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>
 <div class="row">
                     <div class="col-xl-2 col-md-2 mb-2">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                                  <strong>    450 min</strong> {{ __('per shift (8 hours)') }}</div>
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
                                                    <strong> <span id="workingTime"></span> Min </strong> {{ __('working Time') }}</div>
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
                                                    <div class=" font-weight-bold text-danger text-uppercase mb-1">
                                                     <strong><span id="parosTime"></span> Min </strong> {{ __('Stop Time') }}</div>
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
                                                    <div class=" font-weight-bold text-warning text-uppercase mb-1">
                                                     <strong><span id="cortesCuenta"></span> </strong> {{ __('Quantity of wires') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                </div>


            <div class="row">
                <!-- registro de fechas -->
                <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
                                <div class="form-group  ">
                                    <div class= "row">
                                        <div class="col-md-6">
                                            <h4 class="m-0 font-weight-bold text-primary">{{ __('Date') }} </h4>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" name="fecha" id="fecha" value="{{ date('Y-m-d') }}" onchange="getCorte()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- end registro de fechas -->
                    <!-- Maquina 1 -->
                    
                                    
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-x font-weight-bold text-primary text-uppercase mb-1">
                                            MC-1</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="mc1"></span>%</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-Pallet fa-3x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end Maquina 1 -->
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow mb-4">

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Machine Stops') }}</h6>

                    </div>

                         <!-- table Body -->
                             <div class="card-body" style="">
                                <div class="table-responsive" id="regostroParos">
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
    <script>

      async function getCorte(){
    const fechaInput = document.getElementById('fecha').value;
    // Si el input está vacío, puedes decidir no enviar nada o enviar la fecha de hoy
    if(!fechaInput) return;

    try {
        const response = await fetch('/chart/getDatacorte?fecha=' + fechaInput);

        // Si el servidor responde con error (500, 404, etc) saltará al catch
        if (!response.ok) {
            throw new Error(`Error en el servidor: ${response.status}`);
        }

        const data = await response.json();
        console.log(data);
        registroParos= document.getElementById('regostroParos');
        registroParos.innerHTML = '';
        let total_de_paros=0;
        if(data.registroParos !== null){
            registroParos.innerHTML = ``;
            for (let i = 0; i < data.registroParos.length; i++) {
                const paro = data.registroParos[i];
                 total_de_paros+=paro.time_min;
                
                const fila = document.createElement('tr');
                fila.innerHTML = `
                <tr class="text-center align-middle table-light">
                    <td>${paro.maquina}-</td>
                    <td>-${paro.motive}-</td>
                    <td>-${paro.time_min} min-</td>
                    <td>-${paro.hora}</td>
                    </tr>
                `;
                registroParos.appendChild(fila);
            }
        }
        document.getElementById('mc1').textContent = data.OEE;
        document.getElementById('workingTime').textContent = data.running;

        document.getElementById('parosTime').textContent = (data.tiempo_total_turno-data.running-total_de_paros).toFixed(2);
        document.getElementById('cortesCuenta').textContent = data.cortes;        

    } catch (error) {
        console.error("Hubo un problema al obtener el corte:", error);
    }
}
    getCorte();
    setInterval(getCorte, 30000);
    </script>



 @endsection
/

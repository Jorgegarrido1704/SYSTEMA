@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>
 <div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <ul class="list-group list-group-horizontal justify-content-center">
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M1')">M1</button></li>
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M2')">M2</button></li>
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M3')">M3</button></li>
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M4')">M4</button></li>
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M5')">M5</button></li>
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M6')">M6</button></li>
        </ul>
    </div>
 </div>

    <div class="row">
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
                     <div class="col-xl-2 col-md-2 mb-2">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-s font-weight-bold text-warning text-uppercase mb-1">
                                                  <strong>450 min</strong> {{ __('Per shift/machine') }}</div>
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
                                                  <strong> <span id="disponibilidad"></span> MIN</strong> {{ __('Disponibility (-10% Fatigue)(-downtime)') }}</div>
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
                                                     <strong><span id="parosTime"></span> Min </strong> {{ __('Downtime') }}</div>
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
                                <!-- Maquina 1 -->


                                <div class="col-xl-2 col-md-2 mb-2">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-x font-weight-bold text-primary text-uppercase mb-1">
                                                        <span id="maquina1"></span></div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><strong><span id="mc1"></span>%</strong></div>
                                                </div>
                                                <div class="col-auto" id="mc1Estado">
                                                    <i class="fas fa-Pallet fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end Maquina 1 -->
                </div>


            <div class="row">
                <!-- Paretos -->
                <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card shadow mb-4">

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Pareto Times') }}</h6>

                    </div>

                         <!-- table Body -->
                             <div class="card-body" style="">
                               <canvas id="paretoTiempos Maquina1" width="300" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <!--  END Paretos -->
                    <!-- Hora por hora -->
                <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card shadow mb-4">

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Pareto Times') }}</h6>

                    </div>

                         <!-- table Body -->
                             <div class="card-body" style="">
                               <canvas id="hora_por_hora" width="300" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <!--  END Hora por hora -->

                 </div>

            <div class="row">
                <!-- Paretos -->
                <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow mb-4">

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('Machine Downtime') }}</h6>

                    </div>
                         <!-- table Body -->
                             <div class="card-body" style="">
                                <div class="table-responsive" id="regostroParos">
                            </div>
                        </div>
                    </div>
                 </div>
                 <!--end Paretos -->


            </div>
    <script>
        let maquinaActual = 'M1'; // Valor inicial, puedes cambiarlo según tus necesidades
        function cambiarMaquina(nuevaMaquina) {
        maquinaActual = nuevaMaquina;
        getCorte(maquinaActual);

    }

      async function getCorte(maquina ) {
    const fechaInput = document.getElementById('fecha').value;
    // Si el input está vacío, puedes decidir no enviar nada o enviar la fecha de hoy
    if(!fechaInput) return;

    try {
        const response = await fetch('/chart/getDatacorte?fecha=' + fechaInput + '&maquina=' + maquina);

        // Si el servidor responde con error (500, 404, etc) saltará al catch
        if (!response.ok) {
            throw new Error(`Error en el servidor: ${response.status}`);
        }

        const data = await response.json();
        console.log(data);

        registroParos= document.getElementById('regostroParos');
        registroParos.innerHTML = '';
        let total_de_paros=disponibilidad=0;
        if(data.registroParos !== null){
            registroParos.innerHTML = ``;
            //en una tabla

            for (let i = 0; i < data.registroParos.length; i++) {
                const paro = data.registroParos[i];
                 total_de_paros+=paro.time_min;

                const fila = document.createElement('tr');
                fila.innerHTML = `

                    <td>${paro.maquina}-</td>
                    <td>-${paro.motive}-</td>
                    <td>-${paro.time_min} min-</td>
                    <td>-${paro.hora}</td>

                `;
                registroParos.appendChild(fila);
            }

        }
        disponibilidad=(data.tiempo_total_turno*0.9).toFixed(2)-total_de_paros;

        document.getElementById('mc1').textContent = (data.running/disponibilidad*100).toFixed(2);
        document.getElementById('workingTime').textContent = data.running;
        document.getElementById('maquina1').textContent = maquina;
        document.getElementById('disponibilidad').textContent = disponibilidad;
        document.getElementById('parosTime').textContent = (total_de_paros).toFixed(2);
        document.getElementById('cortesCuenta').textContent = data.cortes;

        if(data.estado !== null){
            document.getElementById('mc1Estado').innerHTML = ``;
            if(data.estado == 'RUN'){
            document.getElementById('mc1Estado').innerHTML = `<i class="fas fa-Pallet  fa-3x text-success"></i>`;
            }else{
            document.getElementById('mc1Estado').innerHTML = `<i class="fas fa-Pallet  fa-3x text-danger"></i>`;
            }
        }
        if(data.tiempo_total_turno !== null){


        const paretoTiemposMaquina1 = document.getElementById('paretoTiempos Maquina1');
        const paretoData = {
            labels: ['Tiempos total disponible', 'Running', 'Paros'],
            datasets: [{
                label: 'Pareto Tiempos',
                data: [data.tiempo_total_turno,data.running,total_de_paros],
                backgroundColor: ['rgba(255, 226, 0, 0.4)','rgba(98, 179, 59, 0.54)','rgba(235, 0, 0, 0.54)'],
                borderColor: ['rgba(255, 226, 0, 1)', 'rgba(98, 179, 59, 1)', 'rgba(235, 0, 0, 1)'],
                borderWidth: 1
            }]
        };

        if (paretoTiemposMaquina1) {
            paretoTiemposMaquina1.innerHTML = '';
            new Chart(paretoTiemposMaquina1, {
                type: 'bar',
                data: paretoData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
   // Gráfica hora por hora
const horaporo = document.getElementById('hora_por_hora'); // Evita espacios en el id


    const horaXhora = new Chart(horaporo, {
        type: 'line',
        data: {
            labels: Object.keys(data.stop), // Ej: ["07:00", "08:00", "09:00", ...]
            datasets: [
                {
                    label: 'Not Working',
                    data: Object.values(data.stop), // Ej: [5, 8, 6, ...]
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.1
                },
                {
                    label: 'Running',
                    data: Object.values(data.run), // Ej: [2, 1, 3, ...]
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.5
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });



    } catch (error) {
        console.error("Hubo un problema al obtener el corte:", error);

    }
}
    getCorte(maquinaActual);
    setInterval(getCorte(maquinaActual), 60000);
    </script>



 @endsection
/

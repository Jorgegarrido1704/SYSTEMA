@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>
 <div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <ul class="list-group list-group-horizontal justify-content-center">
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M1')">MCUT-1</button></li>
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M2')">MCUT-2</button></li>
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M3')">MCUT-3</button></li>
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M4')">MCUT-4</button></li>
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M5')">MCUT-5</button></li>
            <li class="list-group-item"><button type="button" class="btn btn-primary" onclick="cambiarMaquina('M6')">MCUT-6</button></li>
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
                                            <input type="date" name="fecha" id="fecha" value="{{ date('Y-m-d') }}" onchange="getCorte(maquinaActual)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>
                                 <div class="col-xl-1 col-md-1 mb-4">
                                  </div>
                                   <div class="col-xl-1 col-md-1 mb-2">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2" >
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        <strong>{{ __('Targer daily') }} 5277</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-xl-2 col-md-2 mb-2">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2" id="workingTime">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 mb-2">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2" id="parosTime">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 mb-2">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2" id="quality_bads">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 mb-2">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2" id='cortesCuenta'>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Maquina 1 -->


                                <div class="col-xl-1 col-md-1 mb-2">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-x font-weight-bold text-primary text-uppercase mb-1">
                                                       <strong><span>OEE </span> <span id="maquina1"></span> </strong></div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><strong><span id="oee_porcentaje"></span>%</strong></div>
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
                <div class="col-xl-8 col-md-6 mb-4">
                        <div class="card shadow mb-4">

                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                                <h6 class="m-0 font-weight-bold text-primary">{{ __('OEE graphs') }}</h6>

                            </div>

                         <!-- table Body -->
                             <div class="card-body" style="">
                                <div class="row">
                                     <div class="col-xl-4 col-lg-4">
                                            <div class="text-center " id="graficaDisponibilidad">  </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4">
                                            <div class="text-center " id="graficaRendimiento">  </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4">
                                            <div class="text-center " id="graficaCalidad">  </div>
                                        </div>
                                </div>
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

        async function getCorte(maquina) {
            const fechaInput = document.getElementById('fecha').value;
            // Si el input está vacío, puedes decidir no enviar nada o enviar la fecha de hoy
            if (!fechaInput) return;

            try {
                const response = await fetch('/chart/getDatacorte?fecha=' + fechaInput + '&maquina=' + maquina);

                // Si el servidor responde con error (500, 404, etc) saltará al catch
                if (!response.ok) {
                    throw new Error(`Error en el servidor: ${response.status}`);
                }

                const data = await response.json();
                console.log(data);

                const registroParos = document.getElementById('regostroParos');
                registroParos.innerHTML = '';
                let total_de_paros = 0;
                let disponibilidad = 0;

                if (data.registroParos !== null) {
                    registroParos.innerHTML = ``;
                    // en una tabla
                    for (let i = 0; i < data.registroParos.length; i++) {
                        const paro = data.registroParos[i];
                        total_de_paros += paro.time_min;

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

                disponibilidad = (data.tiempo_total_turno * 0.9).toFixed(2) - total_de_paros;

              //  document.getElementById('mc1').textContent = (data.running / disponibilidad * 100).toFixed(2);
                document.getElementById('maquina1').textContent = maquina;

                $total_de_paros = (total_de_paros).toFixed(2);
                    if(total_de_paros > 180){
                      document.getElementById('parosTime').innerHTML =   ` <div class=" font-weight-bold text-danger text-uppercase mb-1">
                                                     <strong>${total_de_paros}<span ></span> Min </strong> {{ __('Downtime') }}</div>`;
                    }else if(total_de_paros > 60 && total_de_paros < 180){

                      document.getElementById('parosTime').innerHTML =   ` <div class=" font-weight-bold text-warning text-uppercase mb-1">
                                                     <strong>${total_de_paros}<span ></span> Min </strong> {{ __('Downtime') }}</div>`;
                    }else{

                      document.getElementById('parosTime').innerHTML =   ` <div class=" font-weight-bold text-success text-uppercase mb-1">
                                                     <strong>${total_de_paros}<span ></span> Min </strong> {{ __('Downtime') }}</div>`;
                    }
                    if(data.cortes !== null && data.cortes > 0 && data.cortes < 400){
                        document.getElementById('cortesCuenta').innerHTML = `  <div class=" font-weight-bold text-danger text-uppercase mb-1">
                                                        <strong><span>${data.cortes}</span> </strong> {{ __('Quantity of wires') }}</div>`;
                        document.getElementById('workingTime').innerHTML = `  <div class="text-s font-weight-bold text-danger text-uppercase mb-1">
                                                    <strong> <span >${data.running}</span> Min </strong> {{ __('working Time') }}</div>`;
                    }else if(data.cortes !== null && data.cortes > 400 && data.cortes < 2000){
                        document.getElementById('cortesCuenta').innerHTML = `  <div class=" font-weight-bold text-warning text-uppercase mb-1">
                                                        <strong><span>${data.cortes}</span> </strong> {{ __('Quantity of wires') }}</div>`;
                                                         document.getElementById('workingTime').innerHTML = `  <div class="text-s font-weight-bold text-warning text-uppercase mb-1">
                                                    <strong> <span >${data.running}</span> Min </strong> {{ __('working Time') }}</div>`;
                        }else if (data.cortes !== null && data.cortes > 2000){
                        document.getElementById('cortesCuenta').innerHTML = `  <div class=" font-weight-bold text-success text-uppercase mb-1">
                                                        <strong><span>${data.cortes}</span> </strong> {{ __('Quantity of wires') }}</div>`;
                                                         document.getElementById('workingTime').innerHTML = `  <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                                    <strong> <span >${data.running}</span> Min </strong> {{ __('working Time') }}</div>`;
                        }else{
                        document.getElementById('cortesCuenta').innerHTML = `  <div class=" font-weight-bold text-danger text-uppercase mb-1">
                                                        <strong><span>0</span> </strong> {{ __('Quantity of wires') }}</div>`;
                                                         document.getElementById('workingTime').innerHTML = `  <div class="text-s font-weight-bold text-danger text-uppercase mb-1">
                                                    <strong> <span >${data.running}</span> Min </strong> {{ __('working Time') }}</div>`;
                     }




                if (data.estado !== null) {
                    document.getElementById('mc1Estado').innerHTML = ``;
                    if (data.estado == 'RUN') {
                        document.getElementById('mc1Estado').innerHTML = `<i class="fas fa-Pallet  fa-3x text-success"></i>`;
                    } else {
                        document.getElementById('mc1Estado').innerHTML = `<i class="fas fa-Pallet  fa-3x text-danger"></i>`;
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

            try {
                let fecha = document.getElementById("fecha").value;
                let url_cortes = "/eoo/appJointtiemposCompletos?fecha=" + fecha + '&maquina=' + maquina;

                fetch(url_cortes)
                    .then((response) => response.json())
                    .then((data) => {
                        const graficaOee = document.getElementById("graficaDisponibilidad");
                        const graficaRendimiento = document.getElementById("graficaRendimiento");
                        const graficaCalidad = document.getElementById("graficaCalidad");
                        console.log("Datos recibidos de todas las máquinas:", data);

                        // remove all child nodes
                        while (graficaOee.firstChild) {
                            graficaOee.removeChild(graficaOee.firstChild);
                        }
                        while (graficaRendimiento.firstChild) {
                            graficaRendimiento.removeChild(graficaRendimiento.firstChild);
                        }
                        while (graficaCalidad.firstChild) {
                            graficaCalidad.removeChild(graficaCalidad.firstChild);
                        }

                        // create new canvas
                        const newCanvas = document.createElement("canvas");
                        newCanvas.id = "oeeChart";
                        newCanvas.style.width = "200px";
                        newCanvas.style.height = "200px";
                        graficaOee.appendChild(newCanvas);

                        const newCanvasRendimiento = document.createElement("canvas");
                        newCanvasRendimiento.id = "rendimientoChart";
                        newCanvasRendimiento.style.width = "200px";
                        newCanvasRendimiento.style.height = "200px";
                        graficaRendimiento.appendChild(newCanvasRendimiento);

                        const newCanvasCalidad = document.createElement("canvas");
                        newCanvasCalidad.id = "calidadChart";
                        newCanvasCalidad.style.width = "200px";
                        newCanvasCalidad.style.height = "200px";
                        graficaCalidad.appendChild(newCanvasCalidad);

                        let canvas = document.getElementById("oeeChart");
                        let canvasRendimiento = document.getElementById("rendimientoChart");
                        let canvasCalidad = document.getElementById("calidadChart");
                        let total_fallas_calidas = document.getElementById("quality_bads");
                        let FallasCalidad = data.totalFallasCalidad ?? 0;
                        if (FallasCalidad > 100) {
                           total_fallas_calidas.innerHTML = `<div class=" font-weight-bold text-danger text-uppercase mb-1">
                                                     <strong>${FallasCalidad}<span ></span> Pzs </strong> {{ __('Quality issue') }}</div>`;
                        } else if(FallasCalidad > 0 && FallasCalidad <= 100){
                            total_fallas_calidas.innerHTML = `<div class=" font-weight-bold text-warning text-uppercase mb-1">
                                                     <strong>${FallasCalidad}<span ></span> Pzs </strong> {{ __('Quality issue') }}</div>`;
                        }else{
                            total_fallas_calidas.innerHTML = `<div class=" font-weight-bold text-success text-uppercase mb-1">
                                                     <strong>${FallasCalidad}<span ></span> Pzs </strong> {{ __('Quality issue') }}</div>`;
                        }

                        let oee_porcentaje = document.getElementById("oee_porcentaje");
                        oee_porcentaje.textContent = data.oee??0;


                        if (canvas) {
                            let ctx = canvas.getContext("2d");

                            new Chart(ctx, {
                                type: "doughnut",
                                data: {
                                    labels: [
                                        "Disponibilidad: " + data.disponibilidad.toFixed(2) + "%",
                                        "Paros: " + (100 - data.disponibilidad).toFixed(2) + "%",
                                    ],
                                    datasets: [
                                        {
                                            label: "Disponibilidad %",
                                            data: [data.disponibilidad, 100 - data.disponibilidad],
                                            backgroundColor: ["#1cc889a7", "#e7493b8b"],
                                            hoverBackgroundColor: ["#17a673", "#be2617"],
                                            borderWidth: 1,
                                        },
                                    ],
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: "top",
                                        },
                                    },
                                },
                            });

                            let ctx2 = canvasCalidad.getContext("2d");

                            new Chart(ctx2, {
                                type: "doughnut",
                                data: {
                                    labels: [
                                        "Acceptable: " + data.porcentajeCalidad.toFixed(2) + "%",
                                        "No aceptable: " + (100 - data.porcentajeCalidad).toFixed(2) + "%",
                                    ],
                                    datasets: [
                                        {
                                            label: "Calidad %",
                                            data: [data.porcentajeCalidad, 100 - data.porcentajeCalidad],
                                            backgroundColor: ["#1cc889a7", "#e7493b8b"],
                                            hoverBackgroundColor: ["#17a673", "#be2617"],
                                            borderWidth: 1,
                                        },
                                    ],
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: "top",
                                        },
                                    },
                                },
                            });

                            let ctx1 = canvasRendimiento.getContext("2d");

                            new Chart(ctx1, {
                                type: "doughnut",
                                data: {
                                    labels: [
                                        "Rendimiento: " + data.productividad.toFixed(2) + "%",
                                        "Pérdidas: " + (100 - data.productividad).toFixed(2) + "%",
                                    ],
                                    datasets: [
                                        {
                                            label: "Rendimiento %",
                                            data: [data.productividad, 100 - data.productividad],
                                            backgroundColor: ["#1cc889a7", "#e7493b8b"],
                                            hoverBackgroundColor: ["#17a673", "#be2617"],
                                            borderWidth: 1,
                                        },
                                    ],
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: "top",
                                        },
                                    },
                                },
                            });
                        }
                    })
                    .catch((error) => {
                        console.error("Error al obtener los cortes:", error);
                    });
            } catch (e) {
                console.log(e);
            }
        }

        getCorte(maquinaActual);
        setInterval(() => getCorte(maquinaActual), 60000*3);
    </script>

 @endsection

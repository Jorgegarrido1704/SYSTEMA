const assist = document.getElementById("assistence");

const registroInicidencia = Object.values(registros);
const generos = Object.values(genero);


const tipoTrabajadors = Object.values(tipoTrabajador);

const promau = promaus || 0; // Default to 0 if promaus is not defined

try{//lista de incidencias
    const rhAssistence = new Chart(assist, {
        type: "bar",
        data: {
            labels: [
                "Asistencia",
                "Faltas",
                "Incapacidad",
                "Permisos",
                "Vacaciones",
                "Retardos",
                "Suspensión",
                "Practicantes",
                "Asimilados",
                "Servicios Comprados",
                "Horario Especial",
                "Nocturno",

            ],
            datasets: [
                {
                    label: "Incidences ",
                    backgroundColor: [
                        "rgba(76, 175, 80, 0.5)",
                        "rgba(255, 47, 47, 0.75)",
                        "rgba(237, 142, 0, 0.5)",
                        "rgba(253, 207, 71, 0.84)",
                        "rgba(3, 50, 204, 0.5)",
                        "rgba(245, 13, 129, 0.35)",
                        "rgba(100, 9, 9, 0.81)",
                        "rgba(103, 95, 95, 0.35)",
                        "rgba(102, 33, 146, 0.5)",
                        "rgba(239, 3, 164, 0.5)",
                        "rgba(3, 239, 145, 0.5)",
                        "rgba(104, 110, 108, 0.5)",


                    ],
                    borderColor: [
                        "rgba(76, 175, 80, 1)",
                        "rgba(255, 47, 47, 1)",
                        "rgba(237, 142, 0, 1)",
                        "rgba(253, 207, 71, 1)",
                        "rgba(3, 50, 204, 1)",
                        "rgba(245, 13, 129, 1)",
                        "rgb(67, 18, 18)",
                        "rgba(103, 95, 95, 1)",
                        "rgba(102, 33, 146, 1)",
                        "rgba(239, 3, 164, 1)",
                        "rgba(3, 239, 145, 1)",
                        "rgba(104, 110, 108, 1)",
                    ],
                    borderWidth: 1,
                    borderSkipped: false,

                    data: registroInicidencia,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {

            },
            plugins: {
                datalabels: {
                    anchor: "end",
                    align: "top",
                    formatter: function (value) {
                        return value;
                    },
                    color: "#000",
                    font: {
                        weight: "bold",
                    },
                },

                legend: {
                    position: "top",
                },
                title: {
                    display: true,
                    text: "Asistencia",
                },
            },
            xAxes: [
                {
                    gridLines: {
                        display: false,
                    },
                },
            ],

            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    min: 0,
                    max: 250,
                    ticks: {
                        stepSize: 5,
                    },
                    title: {
                        display: true,
                        text: "Diversidad (0–25)",
                    },
                    grid: {
                        display: false,
                    },
                },
            },
        },
    });
}catch(e){
    console.log(e)
}//end lista de incidencias
try{//rotacion
    const rota0 = new Chart(document.getElementById("rotation0"), {
        type: "doughnut",
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "top",
                },
                title: {
                    display: true,
                    text: "Rotación de personal",
                },
            },
        },
        data: {
            labels: ["Max rotacion: " + 3 + "%", "Rotacion: " +registroInicidencia[12] + "%"],
            datasets: [
                {
                    label: "Rotación de personal",
                    data: [3, registroInicidencia[12]],
                    backgroundColor: [
                        "rgba(2, 164, 75, 0.25)",
                        "rgba(205, 2, 2, 0.25)",
                    ],
                    borderColor: ["rgb(3, 204, 43)", "rgb(168, 0, 0)"],
                    borderWidth: 1,
                },
            ],
        },
        plugins: [
            {
                beforeDraw: (chart) => {
                    const ctx = chart.ctx;
                    ctx.save();
                    ctx.font = "bold 19px Arial";
                    ctx.fillStyle = "black";
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";
                    const total = chart.data.datasets[0].data.reduce(
                        (a, b) => a + b,
                        0
                    );
                    const centerX =
                        chart.chartArea.left +
                        (chart.chartArea.right - chart.chartArea.left) / 2;
                    const centerY =
                        chart.chartArea.top +
                        (chart.chartArea.bottom - chart.chartArea.top) / 2;
                    ctx.fillText(
                        `${( registroInicidencia[12])}%`,
                        centerX,
                        centerY
                    );
                },
            },
        ],
    });
}catch(e){
    console.log(e)
}
            //diversidad
        try{
                const rota1 = new Chart(document.getElementById("rotation1"), {
                    type: "doughnut",
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: "top",
                            },
                            title: {
                                display: true,
                                text: "Rotación de personal",
                            },
                        },
                    },
                    data: {
                        labels: ["Mujeres: " + generos[1]['total'],"Hombres: " + generos[0]['total']],
                        datasets: [
                            {
                                label: "Rotación de personal",
                                data: [generos[1]['total'],generos[0]['total']],
                                backgroundColor: [
                                    "rgba(249, 41, 176, 0.21)",
                                    "rgba(3, 50, 204, 0.21)",
                                ],
                                borderColor: ["rgba(249, 41, 176, 1)", "rgba(3, 50, 204, 1)"],
                                borderWidth: 1,
                            },
                        ],
                    },
                    plugins: [
                        {
                            beforeDraw: (chart) => {
                                const ctx = chart.ctx;
                                ctx.save();
                                ctx.font = "bold 20px Arial";
                                ctx.fillStyle = "black";
                                ctx.textAlign = "center";
                                ctx.textBaseline = "middle";
                                const total = chart.data.datasets[0].data.reduce(
                                    (a, b) => a + b,
                                    0
                                );
                                const centerX =
                                    chart.chartArea.left +
                                    (chart.chartArea.right - chart.chartArea.left) / 2;
                                const centerY =
                                    chart.chartArea.top +
                                    (chart.chartArea.bottom - chart.chartArea.top) / 2;
                                ctx.fillText(
                                    `${( generos[0]['total'] + generos[1]['total'])}`,
                                    centerX,
                                    centerY
                                );
                            },
                        },
                    ],
                });
            }catch(e){
                console.log(e)
            }
            //end diversidad
//ausentismo
const rota2 = new Chart(document.getElementById("rotation2"), {
    type: "doughnut",
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: "buttom",
            },
            title: {
                display: true,
                text: "Ausentismo de personal",
            },
        },
    },
    data: {
        labels: ["Max ausentismo: " + 3 + "%", "Ausentismo: " + promau + "%"],
        datasets: [
            {
                label: "Ausentismo de personal",
                data: [3, promau],
                backgroundColor: [
                    "rgba(2, 164, 75, 0.35)",
                    "rgba(205, 2, 2, 0.35)",
                ],
                borderColor: ["rgb(3, 204, 43)", "rgb(168, 0, 0)"],
                borderWidth: 1,
            },
        ],
    },
    plugins: [
        {
            beforeDraw: (chart) => {
                const ctx = chart.ctx;
                ctx.save();
                ctx.font = "bold 19px Arial";
                ctx.fillStyle = "black";
                ctx.textAlign = "center";
                ctx.textBaseline = "middle";
                const total = chart.data.datasets[0].data.reduce(
                    (a, b) => a + b,
                    0
                );
                const centerX =
                    chart.chartArea.left +
                    (chart.chartArea.right - chart.chartArea.left) / 2;
                const centerY =
                    chart.chartArea.top +
                    (chart.chartArea.bottom - chart.chartArea.top) / 2;
                ctx.fillText(
                    `${( promau)}%`,
                    centerX,
                    centerY
                );
            },
        },
    ],
});
//ratios

let directos = 0;
let indirectos = 0;
Object.values(tipoTrabajadors).forEach(value => {
  if (value.typeWorker === 'Directo') {
    directos += value.total;
  } else {
    indirectos += value.total;
  }
});

// Evitar división por cero
let promedio = indirectos > 0 ? (directos / indirectos)  : 0;

// Redondear a 2 decimales
promedio = promedio.toFixed(2);


const rota3 = new Chart(document.getElementById("rotation3"), {
    type: "doughnut",
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: "buttom",
            },
            title: {
                display: true,
                text: "Ausentismo de personal",
            },
        },
    },
    data: {
        labels: [

            ...Object.values(tipoTrabajadors).map((value) => {
                return value.typeWorker+": "+value.total;
            }),




        ],
        datasets: [
            {
                label: "Ratios de personal",
                data:[
                 ...Object.values(tipoTrabajadors).map((value) => {

                    return value.total;
                }),],
                backgroundColor: [
                    "rgba(2, 164, 75, 0.21)",
                    "rgba(255, 0, 0, 0.21)",
                    "rgba(56, 8, 119, 0.21)",
                    "rgba(255, 32, 248, 0.21)",
                    "rgba(237, 165, 11, 0.21)",
                ],
                borderColor: ["rgb(3, 204, 43)", "rgb(168, 0, 0)", "rgb(56, 8, 119)","rgb(255, 32, 248)","rgb(237, 165, 11)"],
                borderWidth: 1,
            },
        ],
    },

    plugins: [
        {
            beforeDraw: (chart) => {
                const ctx = chart.ctx;
                ctx.save();
                ctx.font = "bold 18px Arial";
                ctx.fillStyle = "black";
                ctx.textAlign = "center";
                ctx.textBaseline = "middle";
                const total = chart.data.datasets[0].data.reduce(
                    (a, b) => a + b,
                    0
                );
                const centerX =
                    chart.chartArea.left +
                    (chart.chartArea.right - chart.chartArea.left) / 2;
                const centerY =
                    chart.chartArea.top +
                    (chart.chartArea.bottom - chart.chartArea.top) / 2;
                ctx.fillText(

                    `${promedio}`,
                    centerX,
                    centerY
                );
            },
        },
    ],
});
try {//vacaciones
    const registroVacaciones = Object.values(vacaciones);
      //cambiar nuemero de mes por nombre del mes
        registroVacaciones.forEach((vac) => {
            const mesNum = parseInt(vac.mesVac, 10);
            const meses = [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
            ];
            vac.mesVac = meses[mesNum - 1] || vac.mesVac; // Si el número no es válido, deja el valor original
        });

    const vacations = new Chart(document.getElementById("vacations"), {


        type: "bar",
        data: {
            labels: registroVacaciones.map((vac) => vac.mesVac),
            datasets: [
                {
                    label: "Vacaciones por mes",
                    backgroundColor: "rgba(3, 50, 204, 0.5)",
                    data: registroVacaciones.map((vac) => vac.cantidad),
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    anchor: "end",
                    align: "top",
                    formatter: function (value) {
                        return value;
                    },
                    color: "#000",
                    font: {
                        weight: "bold",
                    },
                },
                legend: {
                    position: "bottom",
                },
                title: {
                    display: true,
                    text: "Vacaciones de personal",
                },
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10,
                    },
                },
            },
        },
    });
} catch (e) {
    console.log(e);
}

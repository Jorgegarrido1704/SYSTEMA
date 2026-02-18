const assist = document.getElementById("assistence");

const registroInicidencia = Object.values(registros);

const generos = Object.values(genero);
const tipoTrabajadors = Object.values(tipoTrabajador);
const registroVacaciones = Object.values(vacaciones);
const promau = promaus || 0; // Default to 0 if promaus is not defined

//console.log(promau);

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
            "Horario Especial"

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
//rotacion
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
        labels: ["Max rotacion: " + 3 + "%", "Rotacion: " +registroInicidencia[10] + "%"],
        datasets: [
            {
                label: "Rotación de personal",
                data: [3, registroInicidencia[10]],
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
                    `${( registroInicidencia[10])}%`,
                    centerX,
                    centerY
                );
            },
        },
    ],
});
//diversidad
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
        labels: ["Mujeres: " + generos[0], "Hombres: " + generos[1]],
        datasets: [
            {
                label: "Rotación de personal",
                data: generos,
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
                    `${( generos[0] + generos[1])}`,
                    centerX,
                    centerY
                );
            },
        },
    ],
});
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
            "Directos:" + tipoTrabajadors[0],
            "Indirectos:" + tipoTrabajadors[1],
            "Externos:" + tipoTrabajadors[2],
        ],
        datasets: [
            {
                label: "Ratios de personal",
                data: tipoTrabajadors,
                backgroundColor: [
                    "rgba(2, 164, 75, 0.21)",
                    "rgba(255, 0, 0, 0.21)",
                    "rgba(85, 87, 96, 0.21)",
                ],
                borderColor: ["rgb(3, 204, 43)", "rgb(168, 0, 0)", "rgb(85, 87, 96)"],
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
                    `${(tipoTrabajadors[0] / (tipoTrabajadors[1]+tipoTrabajadors[2])).toFixed(2)}%`,
                    centerX,
                    centerY
                );
            },
        },
    ],
});
//vacaciones
const vacations = new Chart(document.getElementById("vacations"), {
    type: "bar",
    data: {
        labels: [
            "Ene",
            "Feb",
            "Mar",
            "Abr",
            "May",
            "Jun",
            "Jul",
            "Ago",
            "Sep",
            "Oct",
            "Nov",
            "Dic",
        ],
        datasets: [
            {
                label: "Vacaciones por mes",
                backgroundColor: "rgba(3, 50, 204, 0.5)",
                data: registroVacaciones,
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
                    stepSize: 20,
                },
            },
        },
    },
});

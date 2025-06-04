

const assist = document.getElementById("assistence");
const registroInicidencia = Object.values(registros);
const generos = Object.values(genero);
const tipoTrabajadors = Object.values(tipoTrabajador);
const registroVacaciones = [10, 20, 15, 25, 30, 20, 15, 10, 5,20, 30, 80,90];

const rhAssistence = new Chart(assist, {
    type: "bar",
    data: {
        labels: ["Asistencia", "Faltas","Incapacidad", "Permisos", "Vacaciones","Retardos"],
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
                ],
                borderColor: [
                    "rgba(76, 175, 80, 1)",
                    "rgba(255, 47, 47, 1)",
                    "rgba(237, 142, 0, 1)",
                    "rgba(253, 207, 71, 1)",
                    "rgba(3, 50, 204, 1)",
                    "rgba(245, 13, 129, 1)",
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
        scales: {
            y: {
                min: 0,
                max: 250,
                ticks: {
                    stepSize: 5
                },
                title: {
                    display: true,
                    text: 'Diversidad (0–25)'
                }
            }
        }
    }
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
        labels: ["Max rotacion: "+3+"%", "Rotacion: "+0.5+"%"],
        datasets: [
            {
                label: "Rotación de personal",
                data: [3,0.5],
                backgroundColor: [
                    "rgba(2, 164, 75, 0.25)",
                    "rgba(205, 2, 2, 0.25)",

                ],
                borderColor: [
                    "rgb(3, 204, 43)",
                    "rgb(168, 0, 0)",

                ],
                borderWidth: 1,
            },
        ],
    },

});
//diersidad
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
        labels: ["Mujeres: "+generos[0], "Hombres: "+generos[1]],
        datasets: [
            {
                label: "Rotación de personal",
                data: generos,
                backgroundColor: [
                    "rgba(249, 41, 176, 0.21)",
                    "rgba(3, 50, 204, 0.21)",
                ],
                borderColor: [
                    "rgba(249, 41, 176, 1)",
                    "rgba(3, 50, 204, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },


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
        labels: ["Max ausentismo: "+3+"%", "Ausentismo: "+0.15+"%"],
        datasets: [
            {
                label: "Ausentismo de personal",
                data: [3,0.15,],
               backgroundColor: [
                    "rgba(2, 164, 75, 0.35)",
                    "rgba(205, 2, 2, 0.35)",

                ],
                borderColor: [
                    "rgb(3, 204, 43)",
                    "rgb(168, 0, 0)",
                ],
                borderWidth: 1,
            },

        ],
    },

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
        labels: ["Directos:"+tipoTrabajadors[0], "Indirectos:"+tipoTrabajadors[1]],
        datasets: [
            {
                label: "Ratios de personal",
                data: tipoTrabajadors,
               backgroundColor: [
                    "rgba(2, 164, 75, 0.21)",
                    "rgba(255, 0, 0, 0.21)",

                ],
                borderColor: [
                    "rgb(3, 204, 43)",
                    "rgb(168, 0, 0)",
                ],
                borderWidth: 1,
            },

        ],
    },

    plugins: [{
        beforeDraw: (chart) => {
            const ctx = chart.ctx;
            ctx.save();
            ctx.font = "bold 18px Arial";
            ctx.fillStyle = "black";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
            const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
            const centerX = chart.chartArea.left + (chart.chartArea.right - chart.chartArea.left) / 2;
            const centerY = chart.chartArea.top + (chart.chartArea.bottom - chart.chartArea.top) / 2;
            ctx.fillText(`${(tipoTrabajadors[0]/tipoTrabajadors[1]).toFixed(2)}%`, centerX, centerY);
        }
    }],

});
//vacaciones
const vacations = new Chart(document.getElementById("vacations"), {
     type: "bar",
    data: {
        labels: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        datasets: [
            {
                label: "Vacaciones por mes",
                backgroundColor:  "rgba(3, 50, 204, 0.5)",
                data: registroVacaciones,
            },
        ],
    },
    options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: function(value) {
                        return value ;
                    },
                    color: '#000',
                    font: {
                        weight: 'bold'
                    }
                },
                legend: {
                    position: "bottom",
                },
                title: {
                    display: true,
                    text: "Vacaciones de personal"
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 20
                    }
                }
            }
        },
    });

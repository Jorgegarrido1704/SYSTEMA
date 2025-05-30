const assist = document.getElementById("assistence");
const registroInicidencia = Object.values(registros);
var generos = Object.values(genero);
generos.push(0); // Adding a zero for the 'Other' category if needed

console.log(generos);

const rhAssistence = new Chart(assist, {
    type: "bar",
    data: {
        labels: ["Asistencia", "Faltas","IncapacidAd", "Permisos", "Vacaciones"],
        datasets: [
            {
                label: "Incidences ",
                backgroundColor: [
                    "rgba(76, 175, 80, 0.5)",
                    "rgba(255, 47, 47, 0.75)",
                    "rgba(237, 142, 0, 0.5)",
                    "rgba(253, 207, 71, 0.84)",
                    "rgba(3, 50, 204, 0.5)",
                ],
                borderColor: [
                    "rgba(76, 175, 80, 1)",
                    "rgba(255, 47, 47, 1)",
                    "rgba(237, 142, 0, 1)",
                    "rgba(253, 207, 71, 1)",
                    "rgba(3, 50, 204, 1)",
                ],
                borderWidth: 1,
                borderSkipped: false,

                data: registroInicidencia,
            },
        ],
    },
    options: {
        values: true,
        responsive: true,
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

const diver = new Chart(document.getElementById("diversidad"), {
    type: "bar",
    data: {
        labels: ["Mujeres", "Hombres"],
        datasets: [
            {
                label: "Diversidad de género",
                backgroundColor: ["rgba(249, 41, 176, 0.5)", "rgba(3, 50, 204, 0.5)"],
                data: generos,
            },
        ],
    },
    options: {
        values: true,
        responsive: true,
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

const rota0 = new Chart(document.getElementById("rotation0"), {
    type: "doughnut",
    options: {
        values: true,
        responsive: true,
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
        labels: ["Hombres", "Mujeres"],
        datasets: [
            {
                label: "Rotación de personal",
                data: [20,30,35],
                backgroundColor: [
                    "rgba(3, 50, 204, 0.5)",
                    "rgba(249, 41, 176, 0.5)",
                    "rgba(255, 47, 47, 0.5)",
                ],
                borderColor: [
                    "rgba(3, 50, 204, 1)",
                    "rgba(249, 41, 176, 1)",
                    "rgba(255, 47, 47, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },

});
const rota1 = new Chart(document.getElementById("rotation1"), {
    type: "doughnut",
    options: {
        responsive: true,
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
        labels: ["Hombres", "Mujeres"],
        datasets: [
            {
                label: "Rotación de personal",
                data: [20,30,35],
                backgroundColor: [
                    "rgba(3, 50, 204, 0.5)",
                    "rgba(249, 41, 176, 0.5)",
                    "rgba(255, 47, 47, 0.5)",
                ],
                borderColor: [
                    "rgba(3, 50, 204, 1)",
                    "rgba(249, 41, 176, 1)",
                    "rgba(255, 47, 47, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },

});
const rota2 = new Chart(document.getElementById("rotation2"), {
    type: "doughnut",
    options: {
        responsive: true,
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
        labels: ["Hombres", "Mujeres"],
        datasets: [
            {
                label: "Rotación de personal",
                data: [20,30,35],
                backgroundColor: [
                    "rgba(3, 50, 204, 0.5)",
                    "rgba(249, 41, 176, 0.5)",
                    "rgba(255, 47, 47, 0.5)",
                ],
                borderColor: [
                    "rgba(3, 50, 204, 1)",
                    "rgba(249, 41, 176, 1)",
                    "rgba(255, 47, 47, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },

});
const rota3 = new Chart(document.getElementById("rotation3"), {
    type: "doughnut",
    options: {
        responsive: true,
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
        labels: ["Hombres", "Mujeres"],
        datasets: [
            {
                label: "Rotación de personal",
                data: [3,30,0.0],
                backgroundColor: [
                    "rgba(3, 50, 204, 0.5)",
                    "rgba(249, 41, 176, 0.5)",
                    "rgba(255, 47, 47, 0.5)",
                ],
                borderColor: [
                    "rgba(3, 50, 204, 1)",
                    "rgba(249, 41, 176, 1)",
                    "rgba(255, 47, 47, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },

});

const vacations = new Chart(document.getElementById("vacations"), {
     type: "bar",
    data: {
        labels: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        datasets: [
            {
                label: "Vacaciones por mes",
                backgroundColor:  "rgba(3, 50, 204, 0.5)",
                data: [10, 20, 15, 25, 30, 20, 15, 10, 5,20, 30, 80,90],
            },
        ],
    },
    options: {
        values: true,
        responsive: true,
        plugins: {
            legend: {
                position: "top",
            },
            title: {
                display: true,
                text: "Vacaciones por mes",
            },
        },
        scales: {
            y: {
                min: 0,
                max: 250,
                ticks: {
                    stepSize: 5
                },
                title: {
                    display: true,
                    text: 'Vacaciones por mes'
                }
            }
        }
    }
});

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

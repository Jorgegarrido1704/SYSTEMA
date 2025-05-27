const assist = document.getElementById("assistence");
const registroInicidencia = Object.values(registros);
var generos = Object.values(genero);
generos.push(0); // Adding a zero for the 'Other' category if needed

console.log(generos);

const rhAssistence = new Chart(assist, {
    type: "bar",
    data: {
        labels: ["Asistencia", "Faltas", "Permisos", "Vacaciones"],
        datasets: [
            {
                label: "Incidences ",
                backgroundColor: "rgb(243, 19, 1)",
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

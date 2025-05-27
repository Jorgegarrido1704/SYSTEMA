const assist = document.getElementById('assistence');


                const rhAssistence = new Chart(assist, {
                    type: "bar",
                    data: {
                        labels: ["Asistencia", "Faltas", "Permisos", "Vacaciones"],
                        datasets: [
                            {
                                label: "Incidences ",
                                backgroundColor: "rgb(243, 19, 1)",
                                data: [12, 19, 3, 5],
                            },
                        ],
                    },

                });

window.onload = function () {
    let define_fecha = document.getElementById("fecha").value;
    if (define_fecha == "") {
        define_fecha = new Date().toISOString().substring(0, 10);
    }
    document.getElementById("fecha").value = define_fecha;
    cortes();
    calidad();
};
function cortes() {
    try {
        let fecha = document.getElementById("fecha").value;
        let url_cortes = "/eoo/appJointtiemposCompletos?fecha=" + fecha;

        fetch(url_cortes)
            .then((response) => response.json())
            .then((data) => {
                //  console.log("Datos recibidos de todas las máquinas:", data);
                //   document.getElementById('cortes').value = data.totalCortes;
                document.getElementById("oee").innerHTML = data.oee;

                const graficaOee = document.getElementById(
                    "graficaDisponibilidad",
                );
                const graficaRendimiento =
                    document.getElementById("graficaRendimiento");
                const graficaCalidad =
                    document.getElementById("graficaCalidad");
                //remove all child nodes
                while (graficaOee.firstChild) {
                    graficaOee.removeChild(graficaOee.firstChild);
                }
                while (graficaRendimiento.firstChild) {
                    graficaRendimiento.removeChild(
                        graficaRendimiento.firstChild,
                    );
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
                let canvasRendimiento =
                    document.getElementById("rendimientoChart");
                let canvasCalidad = document.getElementById("calidadChart");
                let define_fecha = document.getElementById("fecha").value;
                let disponibilidad =
                    document.getElementById("disponibilidad").value;

                let rendimiento = document.getElementById("rendimiento").value;
                let calidad = document.getElementById("calidad").value;
                //alert(disponibilidad + " " + rendimiento + " " + calidad);
                //default hoy

                if (canvas) {
                    let ctx = canvas.getContext("2d");

                    new Chart(ctx, {
                        type: "doughnut",
                        data: {
                            labels: [
                                "Disponibilidad: " +
                                    data.disponibilidad.toFixed(2) +
                                    "%",
                                "Paros: " +
                                    (100 - data.disponibilidad).toFixed(2) +
                                    "%",
                            ],
                            datasets: [
                                {
                                    label: "Disponibilidad %",
                                    data: [
                                        data.disponibilidad,
                                        100 - data.disponibilidad,
                                    ],
                                    backgroundColor: [
                                        "#1cc889a7", // Verde
                                        "#e7493b8b", // Rojo
                                    ],
                                    hoverBackgroundColor: [
                                        "#17a673",
                                        "#be2617",
                                    ],
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
                                "Acceptable: " +
                                    data.porcentajeCalidad.toFixed(2) +
                                    "%",
                                "No aceptable: " +
                                    (100 - data.porcentajeCalidad).toFixed(2) +
                                    "%",
                            ],
                            datasets: [
                                {
                                    label: "Calidad %",
                                    data: [
                                        data.porcentajeCalidad,
                                        100 - data.porcentajeCalidad,
                                    ],
                                    backgroundColor: [
                                        "#1cc889a7", // Verde
                                        "#e7493b8b", // Rojo
                                    ],
                                    hoverBackgroundColor: [
                                        "#17a673",
                                        "#be2617",
                                    ],
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
                                "Rendimiento: " +
                                    data.productividad.toFixed(2) +
                                    "%",
                                "Pérdidas: " +
                                    (100 - data.productividad).toFixed(2) +
                                    "%",
                            ],
                            datasets: [
                                {
                                    label: "Rendimiento %",
                                    data: [
                                        data.productividad,
                                        100 - data.productividad,
                                    ],
                                    backgroundColor: [
                                        "#1cc889a7", // Verde
                                        "#e7493b8b", // Rojo
                                    ],
                                    hoverBackgroundColor: [
                                        "#17a673",
                                        "#be2617",
                                    ],
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
function calidad() {
    let fecha = document.getElementById("fecha").value;

    fetch("/eoo/appJointtiemposCalidad?fecha=" + fecha)
        .then((response) => response.json())
        .then((data) => {
            pintarTablaCalidad(data.detalle);
            pintarTopDefectos(data.topDefectos);
           // alert(fecha);
            console.log("Datos de calidad:", data);
        })
        .catch((error) => console.error("Error al obtener calidad:", error));

    fetch("/eoo/appJointtiemposParos?fecha=" + fecha)

        .then((response) => response.json())
        .then((data) => {pintarTablaParos(data)
        })

        .catch((error) => console.error("Error al obtener paros:", error));
}

function pintarTablaCalidad(detallePorMaquina) {
    const tbody = document.getElementById("tablaCalidadBody");
    tbody.innerHTML = "";

    Object.keys(detallePorMaquina).forEach((maquina) => {
        detallePorMaquina[maquina].forEach((registro) => {
            tbody.innerHTML += `
                <tr>
                    <td>${maquina}</td>
                    <td>${registro.tipo_defecto ?? "-"}</td>
                    <td>${registro.qty_errores}</td>
                    <td>${registro.fecha}</td>
                </tr>`;
        });
    });
}

function pintarTopDefectos(topDefectos) {
    const tbody = document.getElementById("topDefectosBody");
    tbody.innerHTML = "";

    const medallas = ["🥇", "🥈", "🥉"];

    topDefectos.forEach((defecto, i) => {
        tbody.innerHTML += `
            <tr>
                <td>${medallas[i] ?? ""} ${i + 1}</td>
                <td>${defecto.defecto ?? "Sin especificar"}</td>
                <td><strong>${defecto.total}</strong></td>
            </tr>`;
    });
}

function pintarTablaParos(paros) {
    const tbody = document.getElementById("tablaParosBody");
    tbody.innerHTML = "";

    paros.forEach((p) => {
        const esLargo = p.tiempo_total > 15; // umbral ajustable
        tbody.innerHTML += `
            <tr class="${esLargo ? "table-danger" : ""}">
                <td>${p.maquina} - ${p.motivo}</td>
                <td>${p.tiempo_total} min</td>
            </tr>`;
    });
}

function cargarGraficas() {
    cortes();
    calidad();
}

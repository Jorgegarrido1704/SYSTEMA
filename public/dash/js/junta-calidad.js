var datos ;
var pareto ;
var Qdays;
var colorQ;
var labelQ;
var totalp=[];
var paretoKeys = Object.keys(pareto);
var paretoValues = Object.values(pareto);
var totalParetos =paretoKeys.length;
for (var i = 0; i < totalParetos; i++) {
totalp[i]=97;
}
var keys = Object.keys(datos);
var values = Object.values(datos);
var color=color1 = [];

for (var i = 0; i < keys.length; i++) {
var red = Math.floor(Math.random() * 256);
var blue = Math.floor(Math.random() * 256);
var green = Math.floor(Math.random() * 256);
color.push("rgb(" + red + "," + blue + "," + green + ")");
}
for (var i = 0; i < keys.length; i++) {
var red1 = Math.floor(Math.random() * 256);
var blue1 = Math.floor(Math.random() * 256);
var green1 = Math.floor(Math.random() * 256);
color1.push("rgb(" + red + "," + blue + "," + green + ")");
}

var ctx1 = document.getElementById("BarCali");
var Calibar = new Chart(ctx1, {
type: 'bar',
data: {
    labels: keys,
    datasets: [{
        data:values,
        backgroundColor: color,
        hoverBackgroundColor:color1,
        hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
},
options: {

    maintainAspectRatio: false,
    tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
    },
    legend: {
        display: false
    },
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                min: 0,
                stepSize: 1,
            },
            gridLines: {
                color: '#e3e3e3',
                drawBorder: false,
            },
        }],
        xAxes: [{
            gridLines: {
                display: false,
            },
        }]
    }
},
});


var ctx2 = document.getElementById("pareto");
var calidadPareto = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: paretoKeys,
        datasets: [
            {
                label: 'FTQ',
                data: paretoValues,
                backgroundColor: ['#1cc88a', 'red'],
                hoverBackgroundColor: ['#1cc89a', '#ff1a1a'],
                borderColor: '#1cc88a',
                fill: false, // Evita rellenar el área debajo de la línea
                borderWidth: 4
            },
            {
                label: 'Goal',
                data: totalp,
                borderColor: '#FFCC00',
                borderDash: [5, 5],
                pointRadius: 0,
                fill: false,
                borderWidth: 2
            }
        ]
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    min: 90,
                    max: 100,
                    stepSize: 1,
                },
                gridLines: {
                    color: '#e3e3e3',
                    drawBorder: false,
                },
            }],
            xAxes: [{
                gridLines: {
                    display: false,
                },
            }]
        }
    }
});

//Bar pareto
console.log(pareto);
var ctx2 = document.getElementById("barPareto");
var calidadPareto = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['Month','Year'],
        datasets: [
            {
                label: 'FTQ',
                data: [98,99],
                backgroundColor: ['#1cc88a', 'red'],
                hoverBackgroundColor: ['#1cc89a', 'red'],
                borderColor: '#1cc88a',
                fill: false, // Evita rellenar el área debajo de la línea
                borderWidth: 1
            },]
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        responsive: true,
        plugins: {
            legend: {
                display: true, // Mostrar leyendas
                labels: {
                    usePointStyle: true, // Cambiar íconos de las etiquetas a cuadrados
                    pointStyle: 'rect', // Configura los íconos a rectángulos
                    generateLabels: function(chart) {
                        const datasets = chart.data.datasets[0];
                        return chart.data.labels.map((label, index) => ({
                            text: label,
                            fillStyle: datasets.backgroundColor[index], // Color del cuadro
                            strokeStyle: datasets.backgroundColor[index], // Color del borde
                            hidden: false
                        }));
                    }
                }
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    min: 90, // Limitar mínimo
                    max: 100, // Limitar máximo
                    stepSize: 1, // Intervalos de 5 en 5
                },
                gridLines: {
                    color: '#e3e3e3',
                    drawBorder: false,
                },
            }],
            xAxes: [{
                gridLines: {
                    display: false,
                },
            }]
        }
    }
});

// Set default font family and color
Chart.defaults.global.defaultFontFamily = 'Nunito';
//Q as Quality

var ctxQ = document.getElementById("Q");
var myPieChart = new Chart(ctxQ, {
type: 'doughnut',
data: {
labels: labelQ,
datasets: [{
  data: Qdays,
  backgroundColor: colorQ,
  hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
  hoverBorderColor: "rgba(234, 236, 244, 1)",
}],
},
options: {
maintainAspectRatio: false,
tooltips: {
  backgroundColor: "rgb(255,255,255)",
  bodyFontColor: "#858796",
  borderColor: '#dddfeb',
  borderWidth: 1,
  xPadding: 15,
  yPadding: 15,
  displayColors: false,
  caretPadding: 10,
},
legend: {
  display: false
},
cutoutPercentage: 80,
},
});

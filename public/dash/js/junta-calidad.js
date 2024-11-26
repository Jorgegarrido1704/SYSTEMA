var datos ;
var pareto ;
var Qdays;
var colorQ;
var labelQ;

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
},
});

console.log(pareto);
var ctx2 = document.getElementById("pareto");
var calidadPareto = new Chart(ctx2, {
type: 'bar',
data: {
    labels: ['Good', 'Bad'],
    datasets: [{
        data: [pareto[0],pareto[1]],
        backgroundColor: [ '#1cc88a','red'],
        hoverBackgroundColor: ['#1cc89a', '#ff1a1a'],
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
},
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

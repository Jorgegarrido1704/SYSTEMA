
var canvas = document.getElementById('planning');
var ctx = canvas.getContext('2d');



var data = {
    labels:['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'],
    datasets: [{
        label: 'PO registradas',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        hoverBackgroundColor: 'rgba(75, 192, 192, 0.4)',
        data: [datos[0], datos[1], datos[2], datos[3], datos[4], datos[5], datos[6], datos[7], datos[8], datos[9], datos[10], datos[11]]
    }]
};

var options = {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
};

var chart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
});


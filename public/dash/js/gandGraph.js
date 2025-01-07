var paola;
var paoDesc;
var alex;
var alexDesc;
var gann = document.getElementById('Paola S').getContext('2d');
var myChart = new Chart(gann, {
    type: 'bar',
    data: {
        labels: paoDesc, // Labels for the Y-axis (tasks)
        datasets: [
            {
                label: 'Paola S',
                data: paola, // Data for the X-axis
                borderColor: ['rgba(154, 4, 117, 0.2)'],
                backgroundColor: ['rgba(252, 124, 152, 0.2)'],
            },
        ],
    },
    options: {
        indexAxis: 'y', // Horizontal bar chart
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    stepSize: 30, // Step every 30 minutes
                },
            },
        },
    },
});
var gann1 = document.getElementById('Alex V').getContext('2d');
var myChart1 = new Chart(gann1, {
    type: 'bar',
    data: {
        labels: alexDesc, // Labels for the Y-axis (tasks)
        datasets: [
            {
                label: 'Alex V',
                data: alex, // Data for the X-axis
                borderColor: ['rgba(38, 142, 4, 0.2)'],
                backgroundColor: ['rgba(43, 148, 22, 0.2)'],
            },
        ],
    },
    options: {
        indexAxis: 'y', // Horizontal bar chart
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    stepSize: 30, // Step every 30 minutes

                },
            },
        },
    },
});

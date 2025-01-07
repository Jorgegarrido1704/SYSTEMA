var paola;
var paoDesc;
var alex;
var alexDesc;
var paoT;
var alexT;
var gann = document.getElementById('Paola S').getContext('2d');
var myChart = new Chart(gann, {
    type: 'bar',
    data: {
        labels: paoDesc,// Labels for the Y-axis (tasks)
        datasets: [
            {
                label: 'Paola S',
                data: paola,
                backgroundColor: 'rgba(147, 147, 147, 0.4)',

            },

            {
                label: 'Paola S Actual',
                data: paoT,
                backgroundColor: 'rgba(255, 11, 157, 0.81)',

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
                backgroundColor: 'rgba(147, 147, 147, 0.4)',
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

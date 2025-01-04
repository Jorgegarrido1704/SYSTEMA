var paola;
var paoDesc;
var gann = document.getElementById('myChart1').getContext('2d');
var myChart = new Chart(gann, {
    type: 'bar',
    data: {
        labels: paoDesc, // Labels for the Y-axis (tasks)
        datasets: [
            {
                label: 'Paola S',
                data: paola, // Data for the X-axis
                borderColor: ['rgba(255, 99, 132, 0.2)'],
                backgroundColor: ['rgba(255, 99, 132, 0.2)'],
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
                    callback: function (value) {
                        // Convert numeric value to time format
                        let startHour = 7; // Starting hour
                        let startMinute = 30; // Starting minute
                        let totalMinutes = startHour * 60 + startMinute + value; // Add the value to the base time
                        let hours = Math.floor(totalMinutes / 60);
                        let minutes = totalMinutes % 60;
                        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
                    },
                },
            },
        },
    },
});

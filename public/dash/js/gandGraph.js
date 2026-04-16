// Función para convertir minutos acumulados a formato HH:mm
const formatTime = (minutes) => {
    const startTime = 7.5 * 60; // 07:30 en minutos
    const totalMinutes = startTime + minutes;
    const hrs = Math.floor(totalMinutes / 60) % 24;
    const mins = totalMinutes % 60;
    return `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}`;
};

var paola = [[0, 30], [30, 120], [120, 180], [180, 240], [240, 300], [300, 360], [360, 420], [420, 480], [480, 540], [540, 600]];
var paoT = [[0, 30], [30, 100], [100, 150], [150, 220], [22g0, 300], [300, 360], [360, 420], [420, 480], [480, 540], [540, 600]];
var paoDesc = ["FullSize 1001488939 REV 3","FullSize 1001488939 REV 2","FullSize 1001488939 REV 1","FullSize 1001488939 REV 0","FullSize 1001488939 REV 0","FullSize 1001488939 REV 0","FullSize 1001488939 REV 0","FullSize 1001488939 REV 0","FullSize 1001488939 REV 0","FullSize 1001488939 REV 0"];

var gann = document.getElementById('Paola S').getContext('2d');
var myChart = new Chart(gann, {
    type: 'bar',
    data: {
        labels: paoDesc,
        datasets: [
            {
                label: 'Paola S Plan',
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
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                beginAtZero: true,
                min: 0,
                max: 600,
                ticks: {
                    stepSize: 60, // Una marca cada hora
                    callback: function(value) {
                        return formatTime(value); // Convierte el número en "08:30", etc.
                    }
                },
            },
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + formatTime(context.parsed.x);
                    }
                }
            }
        }
    },
});

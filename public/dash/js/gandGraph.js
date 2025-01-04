// Assuming your data is in the format:
// [
//     { time: '07:30', value: 10 },
//     { time: '07:35', value: 12 },
//     { time: '07:40', value: 15 },
//     // ... more data points
// ]

function processDataForChart(data) {
    const labels = [];
    const values = [];

    // Group data into half-hour intervals
    const groupedData = {};
    data.forEach(point => {
        const hour = parseInt(point.time.split(':')[0]);
        const minute = parseInt(point.time.split(':')[1]);
        const halfHour = minute >= 30 ? `${hour}:${30}` : `${hour}:00`;

        if (!groupedData[halfHour]) {
            groupedData[halfHour] = [];
        }
        groupedData[halfHour].push(point.value);
    });

    // Calculate average for each half-hour interval
    for (const [halfHour, values] of Object.entries(groupedData)) {
        labels.push(halfHour);
        values.push(values.reduce((a, b) => a + b, 0) / values.length);
    }

    return { labels, values };
}

// Example usage:
const myData = [
    // ... your data here
];

const { labels, values } = processDataForChart(myData);

var gann = document.getElementById('myChart1').getContext('2d');
var myChart = new Chart(gann, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Dataset 1',
            data: values,
            borderColor: ['rgba(255, 99, 132, 1)'],
            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
            }
        }
    }
});

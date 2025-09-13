

const tasks = datas.map(t => ({
    name: t.name,
    start:(t.start),
    end: (t.end),
    color: t.color
}));

console.log(tasks);
const ctx = document.getElementById('ganttChart').getContext('2d');
// Convertir fechas a días desde la primera fecha para Chart.js
const startDate = new Date(Math.min(...tasks.map(t => new Date(t.start))));
const labels = tasks.map(t => t.name);
const data = tasks.map(t => {
    const start = (new Date(t.start) - startDate) / (1000*60*60*24);
    const end = (new Date(t.end) - startDate) / (1000*60*60*24);
    return {
        x: [start, end],
        y: t.name,
        backgroundColor: t.color
    };
});

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Tareas',
            data: data,
            barPercentage: 0.5,
            categoryPercentage: 0.8
        }]
    },
    options: {
        indexAxis: 'y', // para barras horizontales
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Días desde inicio'
                },
                min: 1
            },
            y: {
                title: {
                    display: true,
                    text: 'Tareas'
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

const tasks = datas.map(t => ({
    name: t.name,
    start: t.start,
    end: t.end,     
    color: t.color
}));

const maxDays = parseInt(maxD);
console.log(tasks);

const ctx = document.getElementById('ganttChart').getContext('2d');

const labels = tasks.map(t => t.name);
const data = tasks.map(t => ({
    x: [t.start, t.end], // usamos los números directamente
    y: t.name,
    backgroundColor: t.color
}));

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Gantt Engineering Tasks',
            data: data,
            barPercentage: 0.5,
            categoryPercentage: 0.8
        }]
    },
    options: {
        indexAxis: 'y', // barras horizontales
        scales: {
            x: {
                title: { display: true, text: 'Develop Days' },
                min: 1,
                max: maxDays
            },
            y: {
                title: { display: true, text: 'Tareas' }
            }
        },
        plugins: { legend: { display: false } }
    }
});

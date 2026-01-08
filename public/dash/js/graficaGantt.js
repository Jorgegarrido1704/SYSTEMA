
const datas = datass;
const maxD = maxDs;
const orgDatas = orgDatass;

const tasks = datas.map(t => ({
    name: t.name,
    start: t.start,
    end: t.end,
    color: t.color
}));

const tasks2 = orgDatas.map(t => ({
    name: t.name,
    start: t.start,
    end: t.end,

}));

const maxDays = parseInt(maxD);
//console.log(tasks);

const ctx = document.getElementById('ganttChart').getContext('2d');

const labels = tasks.map(t => t.name);
const data = tasks.map(t => ({
    x: [t.start, t.end], // usamos los números directamente
    y: t.name,

}));
const orgData =  tasks2.map(t => ({
    x: [t.start, t.end], // usamos los números directamente
    y: t.name,

}));

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Gantt Engineering Tasks',
            data: data,
            barPercentage: 0.5,
            categoryPercentage: 0.8,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',

        },
        {
            label: 'Duration in Days',
            data: orgData,
            barPercentage: 0.5,
            borderColor: 'rgba(192, 106, 75, 1)',
            backgroundColor: 'rgba(219, 33, 33, 0.3)',}
   ]

    },
    options: {
        indexAxis: 'y', // barras horizontales
        scales: {
            x: {
                title: { display: true, text: 'Develop Days' },
                min: 1,
                max: maxDays,
                step:0.1
            },
            y: {
                title: { display: true, text: 'Tareas' }
            }
        },
        plugins: { legend: { display: false } }
    }
});

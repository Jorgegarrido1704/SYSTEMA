const tasks = datas.map(t => ({
    name: t.name,
    start: new Date(t.start),
    end: new Date(t.end),
    color: t.color
}));

const ctx = document.getElementById('ganttChart').getContext('2d');
const startDate = new Date(Math.min(...tasks.map(t => t.start)));

// Contar cuántas tareas hay por día
const dayCounts = {};
tasks.forEach(t => {
    const day = Math.floor((t.start - startDate) / (1000*60*60*24));
    dayCounts[day] = (dayCounts[day] || 0) + 1;
});

// Crear datos con desplazamiento si hay más de 2 tareas en el mismo día
const data = tasks.map((t, index) => {
    const startDay = Math.floor((t.start - startDate) / (1000*60*60*24));
    const endDay = Math.floor((t.end - startDate) / (1000*60*60*24));

    // Desplazamiento vertical: si hay más de 2 tareas en el mismo día
    const tasksOnSameDay = tasks.filter(task => {
        const d = Math.floor((task.start - startDate) / (1000*60*60*24));
        return d === startDay;
    });

    let offset = 0;
    const pos = tasksOnSameDay.findIndex(task => task.name === t.name);
    if(pos >= 2){ // A partir de la tercera
        offset = pos - 1; // desplaza 1, 2, 3 ... según posición
    }

    return {
        x: [startDay, endDay],
        y: t.name + " ".repeat(offset), // simple forma de desplazar visualmente
        backgroundColor: t.color
    };
});

const labels = tasks.map(t => t.name);

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
        indexAxis: 'y', // barras horizontales
        scales: {
            x: {
                title: { display: true, text: 'Días desde inicio' },
                min: 1
            },
            y: {
                title: { display: true, text: 'Tareas' }
            }
        },
        plugins: { legend: { display: false } }
    }
});

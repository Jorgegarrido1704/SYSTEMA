window.formatTime = function(minutes) {
    const startTime = 7.5 * 60; // 07:30 en minutos
    const totalMinutes = startTime + parseInt(minutes);
    const hrs = Math.floor(totalMinutes / 60) % 24;
    const mins = totalMinutes % 60;
    return `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}`;
};

const agruparDatos = (data, filterToday = false) => {
    // Get today's date in YYYY-MM-DD format to match your dateDay field
    const today = new Date().toISOString().split('T')[0];

    return data.reduce((acc, curr) => {
        // If checkbox is checked, skip items that aren't today
        if (filterToday && curr.dateDay !== today) {
            return acc;
        }

        const key = `${curr.id_eng} - ${curr.dateDay}`;
        if (!acc[key]) acc[key] = [];
        acc[key].push(curr);
        return acc;
    }, {});
};

const inicializarGraficas = () => {
    if (typeof datosRaw === 'undefined') {
        console.error("Error: 'datosRaw' no está definido.");
        return;
    }

    const checkbox = document.getElementById('filterByToday');
    const isChecked = checkbox ? checkbox.checked : false;

    const grupos = agruparDatos(datosRaw, isChecked);
    const contenedor = document.getElementById('contenedor-graficas');
    contenedor.innerHTML = '';

    Object.keys(grupos).forEach((titulo, index) => {
        const col = document.createElement('div');
        col.className = 'col-md-12 mb-5';
        const canvasId = `chart-${index}`;

        col.innerHTML = `
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">${titulo}</h6>
                </div>
                <div class="card-body" style="height: 500px;">
                    <canvas id="${canvasId}"></canvas>
                </div>
            </div>
        `;
        contenedor.appendChild(col);

        const items = grupos[titulo].sort((a, b) => parseInt(a.iniTime) - parseInt(b.iniTime));
        const labels = items.map((item, i) => `${item.actDesc} (${i+1})`);
        const dataIntervals = items.map(item => [parseInt(item.iniTime), parseInt(item.endTime)]);

        const ctx = document.getElementById(canvasId).getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Horario',
                    data: dataIntervals,
                    backgroundColor: 'rgba(255, 11, 157, 0.8)',
                    borderColor: 'rgba(255, 11, 157, 1)',
                    borderWidth: 1
                }]
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
                            stepSize: 60,
                            callback: function(value) {
                                return formatTime(value);
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
    });
};

// Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    inicializarGraficas();

    // Listen for checkbox changes to re-render
    const checkbox = document.getElementById('filterByToday');
    if (checkbox) {
        checkbox.addEventListener('change', inicializarGraficas);
    }
});

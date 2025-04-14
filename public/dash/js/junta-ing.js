const tiemposIng = document.getElementById("tiempos");
const labelsAct=Object.keys(actividades);
const dataAct=Object.values(actividades);

const timeIng = new Chart(tiemposIng, {
  type: 'bar',
  data: {
    labels: labelsAct,
    datasets: [{
      label: 'Mes Actual',
      data: dataAct,
      backgroundColor: ['#4e73df', '#1cc88a'],
      hoverBackgroundColor: ['#2e59d9', '#17a673'],
      borderColor: '#4e73df',
      borderWidth: 1,
      borderSkipped: false
    },
    {
      label: 'Mes Anterior',
      data: [1000, 1000, 1000, 100, 1000, 1000],
      backgroundColor: ['#4e73df', '#1cc88a'],
      hoverBackgroundColor: ['#2e59d9', '#17a673'],
      borderColor: '#4e73df',
      borderWidth: 1,
      borderSkipped: false
    }]

  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      x: {
        title: {
          display: true,
          text: 'Nombre'
        }
      },
      y: {
        beginAtZero: true,
        title: {
          display: true,
          text: 'Horas'
        }
      }
    },
    plugins: {
      legend: {
        display: true,
        position: 'top'
      },
      tooltip: {
        enabled: true
      }
    }
  }
});

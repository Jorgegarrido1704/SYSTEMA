try {
const tiemposIng = document.getElementById("tiempos");
const labelsAct=Object.keys(actividades);
const dataAct=Object.values(actividades);
const jes =Object.values(jesus);
const pao =Object.values(paos);
const nancys =Object.values(nancy);
const ales =Object.values(ale);
const carloss =Object.values(carlos);
const arturos =Object.values(arturo);
const jorges =Object.values(jorge);
const brandos =Object.values(brandon);

const lastActData=Object.values(actividadesLastMonth);
const timeIng = new Chart(tiemposIng, {
  type: 'bar',
  data: {
    labels: labelsAct,
    datasets: [{
      label: 'Mes Actual',
      data: dataAct,
      backgroundColor: '#fff861',
      hoverBackgroundColor: '#fff861',
      borderColor: '#fff861',
      borderWidth: 1,
      borderSkipped: false,
      hidden: true,

    },
    {
    label: 'Mes Anterior',
    data: lastActData,
    backgroundColor: '#ff5e54',
    hoverBackgroundColor: '#ff5e54',
    borderColor: '#4e73df',
    borderWidth: 1,
    borderSkipped: false,
    hidden: true,

  },
        {
            label: 'Jesus C',
            data: jes,
            borderColor: '#64d1fa',
            borderWidth: 3,
            borderSkipped: false,
            stack: 'combined',
            type: 'line',
          },
          {
            label: 'Paola S',
            data: pao,
            borderColor: '#cf64fa',
            borderWidth: 3,
            borderSkipped: false,
            stack: 'combined',
            type: 'line',
          },
          {
            label: 'Nancy A',
            data: nancys,
            borderColor: '#ff3399',
            borderWidth: 3,
            borderSkipped: false,
            stack: 'combined',
            type: 'line',
          },
          {
            label: 'Alejandro V',
            data: ales,
            borderColor: '#c2f005',
            borderWidth: 3,
            borderSkipped: false,
            stack: 'combined',
            type: 'line',
          },
          {
            label: 'Carlos R',
            data: carloss,
            borderColor: '#1e9207',
            borderWidth: 3,
            borderSkipped: false,
            stack: 'combined',
            type: 'line',
          },
          {
            label: 'Arturo S',
            data: arturos,
            borderColor: '#ccfa10',
            borderWidth: 3,
            borderSkipped: false,
            stack: 'combined',
            type: 'line',
          },
          {
            label: 'Jorge G',
            data: jorges,
            borderColor: '#fb5e05',
            borderWidth: 3,
            borderSkipped: false,
            stack: 'combined',
            type: 'line',
          },
          {
            label: 'Brando S',
            data: brandos,
            borderColor: '#c4ee18',
            borderWidth: 3,
            borderSkipped: false,
            stack: 'combined',
            type: 'line',
          },

    ]

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
}

catch (error) {

}
try {

    const ppap = document.getElementById("procesosIngPpap");
    const jespL=Object.keys(jesp);
    const jespV = Object.values(jesp);
    const jgV= Object.values(jg);
    const aspV= Object.values(asp);
    const alvV = Object.values(alv);
    const pspV = Object.values(psp);
    const nanpV = Object.values(nanp);
    const bpV = Object.values(bp);
    const jcpV = Object.values(jcp);


    const ppapIng = new Chart(ppap, {
      type: 'bar',
      data: {
        labels: jespL,
        datasets: [{
          label: 'Jesus C',
          data: jespV,
          backgroundColor:
            'rgba(255, 99, 132, 0.2)',
          borderColor:
            'rgba(255, 99, 132, 1)',
          borderWidth: 1,
          borderSkipped: false,
          stack: 'combined',
      },
      {
        label: 'Jorge G',
        data: jgV,
        backgroundColor:
          'rgba(54, 162, 235, 0.2)',

        borderColor:
          'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        borderSkipped: false,
        stack: 'combined',
      },
      {
        label: 'Arturo S',
        data: aspV,
        backgroundColor:
          'rgba(255, 206, 86, 0.2)',
        borderColor:
            'rgba(255, 206, 86, 1)',

        borderWidth: 1,
        borderSkipped: false,
        stack: 'combined',
      },

    ]

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

}
catch (error) {
}

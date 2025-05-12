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
    console.error(error);

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
    const toda = Object.values(todas);


    const ppapIng = new Chart(ppap, {
      type: 'bar',
      data: {
        labels: jespL,
        datasets: [{
          label: 'Jesus C',
          data: jespV,
          backgroundColor:
            'rgba(62, 177, 249, 0.2)',
          borderColor:
            'rgb(62,177,249)',
          borderWidth: 1,
          borderSkipped: false,
          stack: 'combined',
      },
      {
        label: 'Jorge G',
        data: jgV,
        backgroundColor:
          'rgba(246, 160, 31, 0.2)',

        borderColor:
          'rgb(246,160,31)',
        borderWidth: 1,
        borderSkipped: false,
        stack: 'combined',
      },
      {
        label: 'Arturo S',
        data: aspV,
        backgroundColor:
        'rgba(164, 240, 143, 0.2)',
        borderColor:
          'rgb(164, 240, 142)',
        borderWidth: 1,
        borderSkipped: false,
        stack: 'combined',
      },
      {
        label: 'Alejandro V',
        data: alvV,
        backgroundColor:
        'rgba(164, 240, 143, 0.2)',
        borderColor:
          'rgb(164, 240, 141)',
        borderWidth: 1,
        borderSkipped: false,
        stack: 'combined',

      },{
        label: 'Paola S',
        data: pspV,
        backgroundColor:
          'rgba(123, 8, 79, 0.2)',
        borderColor:
          'rgb(123, 8, 79)',
        borderWidth: 1,
        borderSkipped: false,
        stack: 'combined',
      },
      {
        label: 'Nancy A',
        data: nanpV,
        backgroundColor:
          'rgba(251, 139, 208, 0.2)',
        borderColor:
          'rgb(251,139,208)',
        borderWidth: 1,
        borderSkipped: false,
        stack: 'combined',
      },
      {
        label: 'Brando S',
        data: bpV,
        backgroundColor:
          'rgba(164, 240, 143, 0.2)',
        borderColor:
          'rgb(164, 240, 143)',
        borderWidth: 1,
        borderSkipped: false,
        stack: 'combined',
      },
      {
        label: 'Carlos R',
        data: jcpV,
        backgroundColor:
          'rgba(3, 102, 18, 0.2)',
        borderColor:
          'rgb(3,102, 18)',
        borderWidth: 1,
        borderSkipped: false,
        stack: 'combined',
      },
      {
        label: 'Todas',
        data: toda,
        backgroundColor:
          'rgba(255, 48, 48, 0.2)',
        borderColor:
          'rgb(182, 0, 0)',
        borderWidth: 1,
        borderSkipped: false,
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
    console.error(error);
}
try {

    const cake = document.getElementById("cakes");
    const buen=(buenos);
    const mal=(malos);

    const cakeIng = new Chart(cake, {
      type: 'doughnut',
      data: {
        labels: ['on Time', 'Delayed'],
        datasets: [{
          label: 'Cakes',
          data: [buen, mal],
            backgroundColor: [
                'rgba(14, 249, 18, 0.2)',
                'rgba(198, 73, 32, 0.2)',
            ],
            borderColor: [
                'rgb(62, 249, 71)',
                'rgb(251, 79, 79)',
            ],
            borderWidth: 1,
            borderSkipped: false,
            stack: 'combined',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
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
    console.error(error);
}
try {
    goals = [];
    const labelsreg=Object.keys(mothLess12);
    const datareg=Object.values(mothLess12);
    for (let i = 0; i < labelsreg.length; i++) {
        goals[i] = parseInt(95);
    }
    const comp=Object.values(compGoals);
    const cake2 = document.getElementById("cakes2");
  const data = {
  labels:labelsreg,
  datasets: [{
    type: 'bar',
    label: 'Last Year',
    data: datareg,
    borderColor: 'rgb(255, 162, 238)',
    backgroundColor: 'rgba(226, 60, 223, 0.2)',
    borderWidth: 1,
  },{
    type: 'bar',
    label: 'This Year',
    data: comp,
    backgroundColor: 'rgba(226, 250, 160, 0.2)',
    borderColor: 'rgb(220, 240, 65)',
    borderWidth: 1,
  }, {
    type: 'line',
    label: 'GOAL',
    data: goals,
    fill: false,
    borderColor: 'rgb(21, 249, 108)'
  }]
};
const config = {
  type: 'bar',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
};
const cakeIng2 = new Chart(cake2, config);


}
catch (error) {
    console.error(error);
}

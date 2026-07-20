function cargarGraficas(mes){

    alert(mes);
    
}



try {

    const cake = document.getElementById("cakes");
    const buen=(bien);
    const mal=(malos);

const cakeIng = new Chart(cake, {
      type: 'doughnut',
      data: {
        labels: ['on Time: '.concat(buen) , 'Delayed: '.concat(mal)],
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


}catch (error) {
//console.error(error);
}
try {
    goals = [];
    const labelsreg=Object.keys(compGoals);
    const datareg=Object.values(compGoals);
    for (let i = 0; i < labelsreg.length; i++) {
        goals[i] = parseInt(95);
    }
    const comp=Object.values(mothLess12);
    const cake2 = document.getElementById("cakes2");
  const data = {
  labels: ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'],
  datasets: [{
    type: 'bar',
    label: 'This Year',
    data: datareg,
    borderColor: 'rgb(255, 162, 238)',
    backgroundColor: 'rgba(226, 60, 223, 0.2)',
    borderWidth: 1,
  },{
    type: 'bar',
    label: 'Last Year',
    data: comp,
    backgroundColor: 'rgba(12, 36, 254, 0.2)',
    borderColor: 'rgb(33, 58, 251)',
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


}catch (error) {
  //  console.error(error);
}

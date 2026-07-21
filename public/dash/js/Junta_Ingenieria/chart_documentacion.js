
now = new Date();
t = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();

function cargarGraficas(mes){
     goals = [];
     registrosArrays.forEach((element) => {
        prom=(parseInt(element.buenos)/(parseInt(element.buenos)+parseInt(element.malos))*100).toFixed(2);
        goals[element.anio+'-'+element.mes] = prom;

    });
    
    try {
   
        
            const cake2 = document.getElementById("cakes2");
        const data = {
        labels: Object.keys(goals),
        datasets: [{
            type: 'bar',
            label: 'This Year',
            data: Object.values(goals),
            borderColor: 'rgb(255, 162, 238)',
            backgroundColor: 'rgba(226, 60, 223, 0.2)',
            borderWidth: 1,
        },{
            type: 'bar',
            label: 'Last Year',
            data: Object.values(goals),
            backgroundColor: 'rgba(12, 36, 254, 0.2)',
            borderColor: 'rgb(33, 58, 251)',
            borderWidth: 1,
        }, {
            type: 'line',
            label: 'GOAL',
            data: Array(Object.keys(goals).length).fill(95),
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
    console.error(error);
}
try {

    const cake = document.getElementById("cakes");
    var buenos=0;
    var malos=0;
    var labels='';
    registrosMensual.forEach((element) => {
        buenos+=parseInt(element.buenos);
        malos+=parseInt(element.malos);
        labels += element.anio+'-'+element.mes;
    });
  document.getElementById('porcentaje_mes').innerHTML=(buenos/(buenos+malos)*100).toFixed(2);
   
const cakeIng = new Chart(cake, {
      type: 'doughnut',
      data: {
        labels: ['on Time: '.concat(buenos) , 'Delayed: '.concat(malos)],
        datasets: [{
          label: 'On Time vs Delayed'+labels,
          data: [buenos, malos],
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
 console.error(error);
}

}






onload = function(){

    cargarGraficas(t);
}
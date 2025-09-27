


try {
  const tiemposIng = document.getElementById("tiempos");

// Sacar acciones y personas
const actions = Object.keys(Object.values(actividades)[0]);
const ingenieros = Object.keys(actividades);

// Generar un dataset por cada persona
const datoste = ingenieros.map(name => ({
  label: name,
  data: actions.map(action => datosPpap[name][action]),
  backgroundColor: getRandomColor(name),
  borderWidth: 1

}));

// Función para colores aleatorios/fijos
function getRandomColor(nombre) {
  let color;
  if (nombre === 'Paola S') {
    color = '#7b06b6ff';
  } else if (nombre === 'Carlos R') {
    color = '#005404ff';
  } else if (nombre === 'Nancy A') {
    color = '#f3a1dfff';
  } else if (nombre === 'Arturo S') {
    color = '#0073c0ff';
  } else if (nombre === 'Jorge G') {
    color = '#ec7921ff';
  } else if (nombre === 'Jesus_C') {
    color = '#83c8f6ff';
  } else if (nombre === 'Eliot D') {
    color = '#a64577ff';
  } else {
    color = '#ffab91';
  }
  return color;
}

const tiemposing = new Chart(tiemposIng, {
  type: 'bar',
  data: {
    labels: actions,  // <<--- Aquí cambié actividades por actions
    datasets: datoste
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      x: {
        title: {
          display: true,
          text: 'Actividades'
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
    //console.error(error);

}
try {

    const ppap = document.getElementById("procesosIngPpap");
  const areas = Object.keys(Object.values(datosPpap)[0]);
const personas = Object.keys(datosPpap);

// Generar un dataset por cada persona
const datasets = personas.map(nombre => ({
  label: nombre,
  data: areas.map(area => datosPpap[nombre][area]),
  backgroundColor: getRandomColor(nombre),
  borderWidth: 1,
  stack: 'combined'
}));

// Función para colores aleatorios
function getRandomColor(nombre) {
   if( nombre == 'Paola S'){
    color = '#7b06b6ff'; // color fijo para estos nombres
   }
    else if(nombre == 'Carlos R'){
     color = '#005404ff'; }
      else if(nombre == 'Nancy A'){
     color = '#f3a1dfff'; }
      else if(nombre == 'Arturo S'){
     color = '#0073c0ff'; }
      else if(nombre == 'Jorge G'){
     color = '#ec7921ff'; }
      else if(nombre == 'Jesus_C'){
     color = '#83c8f6ff'; }
      else if(nombre == 'Eliot D'){
     color = '#a64577ff'; }

     else {
     color = '#ffab91'; }
    return color;
}
const ppapIng = new Chart(ppap, {
  type: 'bar',
  data: {
    labels: areas,
    datasets: datasets

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
   // console.error(error);
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


}
catch (error) {
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


}
catch (error) {
  //  console.error(error);
}
try{
    function changeGraph(graph){
       if(graph=='donaMes'){
           document.getElementById("donaMes").style.display = "block";
           document.getElementById("barraYear").style.display = "none";
           document.getElementById("paretoTime").style.display = "block";
       }else{
           document.getElementById("donaMes").style.display = "none";
           document.getElementById("barraYear").style.display = "block";
           document.getElementById("paretoTime").style.display = "none";

       }

    }

    }catch (error) {
        //console.error(error);
    }


try{
    function tipoNpiChange() {
    const tipoNpi = document.getElementById('registrosNPI');
    const selectTipoNpi = document.getElementById('tipoNpi').value;
    alert('Selected: ' + selectTipoNpi);
    tipoNpi.innerHTML = '';

    $.ajax({
        method: 'GET',
        url: url, // define this
        data: { tipoNpi: selectTipoNpi },
        dataType: 'json',
        success: function(response) {
            let rows = '';
            response.forEach(item => {
                rows += `
                    <tr>
                        <td>${item[0] || item.col1}</td>
                        <td>${item[1] || item.col2}</td>
                        <td>${item[2] || item.col3}</td>
                        <td>${item[3] || item.col4}</td>
                        <td>${item[4] || item.col5}</td>
                        <td>${item[5] || item.col6}</td>
                        <td>${item[6] || item.col7}</td>
                        <td>${item[7] || item.col8}</td>
                        <td>${item[8] || item.col9}</td>
                        <td>${item[9] || item.col10}</td>
                        <td>${item[10] || item.col11}</td>
                        <td>${item[11] || item.col12}</td>
                        <td>${item[12] || item.col13}</td>
                        <td>${item[13] || item.col14}</td>
                        <td>${item[15] || item.col16}</td>
                        <td>${item[16] || item.col17}</td>
                        <td>${item[18] || item.col19}</td>
                        <td>${item[19] || item.col20}</td>
                        <td>${item[20] || item.col21}</td>

                    </tr>`;
            });
            tipoNpi.innerHTML = rows;
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

}catch( error) {
   // console.error(error);
}

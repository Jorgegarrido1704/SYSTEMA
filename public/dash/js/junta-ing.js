


try {
 const tiemposIng = document.getElementById("tiempos");

// Tomar todas las acciones posibles de todos
const actions = [
  ...new Set(Object.values(actividades).flatMap(obj => Object.keys(obj)))
];

// Generar datasets
const datoste = Object.keys(actividades).map(name => ({
  label: name,
  data: actions.map(action => actividades[name][action] ?? 0),
  backgroundColor: getRandomColor(name),
  borderWidth: 1
}));

function getRandomColor(nombre) {
  let color;
   if (nombre === 'Paola S') color = 'rgba(123, 6, 182, 0.4)';      // #7b06b6
  else if (nombre === 'Carlos R') color = 'rgba(0, 84, 4, 0.4)';    // #005404
  else if (nombre === 'Nancy A') color = 'rgba(243, 161, 223, 0.4)';// #f3a1df
  else if (nombre === 'Arturo S') color = 'rgba(0, 115, 192, 0.4)'; // #0073c0
  else if (nombre === 'Jorge G') color = 'rgba(236, 121, 33, 0.4)'; // #ec7921
  else if (nombre === 'Jesus_C') color = 'rgba(131, 200, 246, 0.4)';// #83c8f6
  else if (nombre === 'Eliot D') color = 'rgba(166, 69, 119, 0.4)'; // #a64577
  else color = 'rgba(255, 171, 145, 0.4)';
  return color;
}

const tiemposing = new Chart(tiemposIng, {
  type: 'line',
  data: {
    labels: actions,
    datasets: datoste
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      x: {
        title: { display: true, text: 'Actividades' }
      },
      y: {
        beginAtZero: true,
        title: { display: true, text: 'Horas' }
      }
    },
    plugins: {
      legend: { display: true, position: 'top' },
      tooltip: { enabled: true }
    }
  }
});

}catch (error) {
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
 if (nombre === 'Paola S') color = 'rgba(123, 6, 182, 0.4)';      // #7b06b6
  else if (nombre === 'Carlos R') color = 'rgba(0, 84, 4, 0.4)';    // #005404
  else if (nombre === 'Nancy A') color = 'rgba(243, 161, 223, 0.4)';// #f3a1df
  else if (nombre === 'Arturo S') color = 'rgba(0, 115, 192, 0.4)'; // #0073c0
  else if (nombre === 'Jorge G') color = 'rgba(236, 121, 33, 0.4)'; // #ec7921
  else if (nombre === 'Jesus_C') color = 'rgba(131, 200, 246, 0.4)';// #83c8f6
  else if (nombre === 'Eliot D') color = 'rgba(166, 69, 119, 0.4)'; // #a64577
  else color = 'rgba(255, 171, 145, 0.4)';
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

}catch (error) {
   // console.error(error);
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
    function tipoNpiChange(datos) {
    const tipoNpi = document.getElementById('registrosNPI');
    const selectTipoNpi = datos;
   // alert('Selected: ' + selectTipoNpi);
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
                    <tr   id=${item[21] || item.col21} style="text-align: center; background-color:rgba(${item[14] || item.col14}) ; text-align: center; color : black;">
                        <td>${item[0] || item.col1}</td>
                        <td>${item[1] || item.col2}</td>
                        <td>${item[2] || item.col3}</td>
                        <td>${item[3] || item.col4}</td>
                        <td>${item[4] || item.col5}</td>
                        <td>${item[5] || item.col6}</td>
                           <td>${item[6] || item.col7}</td>
                        <td>${item[7] || item.col8}</td>
                        <td>${item[18] || item.col9}</td>
                        <td>${item[15] || item.col10}</td>
                        <td>${item[16] || item.col11}</td>
                        <td>${item[8] || item.col12}</td>
                        <td>${item[19] || item.col13}</td>
                        <td>${item[20] || item.col14}</td>
                        <td style="text-align: center; background-color:rgba(${item[22] || item.col22});">${item[9] || item.col15}</td>
                        <td style="text-align: center; background-color:rgba(${item[22] || item.col22});">${item[10] || item.col16}</td>
                        <td style="text-align: center; background-color:rgba(${item[22] || item.col22});">${item[11] || item.col17}</td>
                        <td style="text-align: center; background-color:rgba(${item[22] || item.col22});">${item[12] || item.col18}</td>
                        <td style="text-align: center; background-color:rgba(${item[22] || item.col22});">${item[13] || item.col19}</td>


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
try{
    console.log(timesByPlaning);
    const labelsTimeByPlaning = Object.keys(timesByPlaning);
    const dataTimeByPlaning = Object.values(timesByPlaning);
    const dataTimeByFirmas = Object.values(timesByFirmas);

    const graficaRetasoPlaning = document.getElementById("diferencias");
    const diferenciaPlaning = new Chart(graficaRetasoPlaning, {
        type: 'bar',
        data: {
            labels: labelsTimeByPlaning,
            datasets: [{
                label: 'Days from Completion to Up Order Date',
                data: dataTimeByPlaning,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Days from Completion to Signature Date',
                data: dataTimeByFirmas,
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            },
            {type: 'line',
             label: 'Average Delay',
             data: Array(labelsTimeByPlaning.length).fill("3"),
             borderColor: 'rgba(54, 162, 235, 1)',
             borderWidth: 2,
             fill: false,
             tension: 0.1
            }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Days'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Part Number'
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

}catch(error){
   // console.error(error);
}

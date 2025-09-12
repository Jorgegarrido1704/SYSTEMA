var datos ;
var pareto ;
var Qdays;
var colorQ;
var labelQ;
var pyl=Object.keys(paretoYear);
var pyv=Object.values(paretoYear);
var employees =Object.keys(empleados);
var empvalues =Object.values(empleados);
const personal=[
['2001','Jesus  Zamarripa Rodriguez','Lider Producción','Ensamble','DVillalpando'],
['2002','Rosario Hernandez Lopez','Inspector Calidad','','EVillegas'],
['2003','Andrea Pacheco','Supervisor Almacen','','JGUILLEN'],
['2004','Fabiola  Alonso','Inspector Calidad','','EVillegas'],
['2005','Martha Carpio','Operador C','Liberación','AGonzalez'],
['2006','Maria Alejandra Gaona Alvarado','Operador A','Ensamble','SGalvan'],
['2007','Adan Bravo Martinez','Operador A','Liberación','AGonzalez'],
['2008','Lidia Susana Rico Hernadez','Operador D','Ensamble','JSanchez'],
['2009','Ma Estela Gaona Alvarado','Planeador Producción','','MVALADEZ'],
['2010','Leonardo Rafael Mireles','Supervisor de embarque','','FGOMEZ'],
['2013','Fernando Martin Segovia','Aux Lider','Corte','COlvera'],
['2014','Salvador Galvan Davila','Lider Producción','Ensamble','DVillalpando'],
['2015','Maria Esther Mandujano ','Aux Lider','Ensamble','JSanchez'],
['2016','Jose Manuel Zacarias Jimenez','Operador A','Ensamble','JZamarripa'],
['2017','Jennifer Alejandra Gomez','Operador C','Liberación','AGonzalez'],
['2018','David Salvador Rodriguez','Operador D','Ensamble','JZamarripa'],
['2019','Efrain Vera Villegas','Supervisor de calidad','','EMedina'],
['2020','Laura Alejandra Contreras','Operador A','Ensamble','JZamarripa'],
['2021','Rosalba Ramirez Oliva','Operador C','Liberación','AGonzalez'],
['2022','Maria Berenice Serrano ','Operador C','Liberación','AGonzalez'],
['2023','Didier Maldonado Lopez','Aux Almacen B','','APacheco'],
['2024','Aury Cecilia Aguilar Castillo','Tec Pruebas','','EMedina'],
['2025','Maria Magdalena Villanueva','Operador C','Ensamble','JSanchez'],
['2026','Samantha Montserrat Aranda','Operador D','Ensamble','JSanchez'],
['2030','Jose Luis Ruiz Valdivia','Tec Pruebas','','EMedina'],
['2031','Jessica Lizbeth Sanchez','Lider Producción','Ensamble','DVillalpando'],
['2032','Martha Aranda Palacios','Operador A','Ensamble','SGalvan'],
['2033','Alma Delia Perez Martin','Operador B','Ensamble','JSanchez'],
['2034','Jessica Sarahi Torres P','Operador C','Ensamble','JSanchez'],
['2035','Neri Leticia Cervantes ','Operador B','Ensamble','JSanchez'],
['2037','Christian De Jesus Olvera','Lider Producción','Corte','JOlaes'],
['2038','Beatriz Elena Regalado ','Operador B','Ensamble','JZamarripa'],
['2041','Edward Medina Flores','Ing Calidad','','LRAMOS'],
['2042','Martha Evelia Trujillo ','Operador C','Ensamble','JZamarripa'],
['2043','Mayra Daniela Montes P','Operador C','Liberación','AGonzalez'],
['2044','Sanjuana Estela Mosqueda','Operador C','Ensamble','SCastro'],
['2046','Ma. De los Angeles   Flores Ortiz','Operador C','Ensamble','JSanchez'],
['2047','Maricela Alferes Montes','Intendencia B','','PAGUILAR'],
['2049','Jessica Estefania Galvan','Operador C','Ensamble','JSanchez'],
['2051','Sergio Vera Castillo','Inspector Calidad','','EVillegas'],
['2052','Erick Nuñez Vazquez','Aux Almacén A','','APacheco'],
['2054','Cristina Jacquelin Godinez Ortiz','Operador C','Ensamble','JZamarripa'],
['2056','Sobeida Amaya Mercado','Operador D','Ensamble','SCastro'],
['2057','Daniela Goretti Rocha C','Aux Calidad','','EMedina'],
['2058','Maria Barbara Castillo ','Operador C','Ensamble','JSanchez'],
['2060','Marisol Anahi Perez M','Aux Almacen B','','APacheco'],
['2062','Alejandro Daniel Robledo','Operador C','Corte','COlvera'],
['2065','Brenda Cecilia Galvan S','Operador D','Ensamble','SCastro'],
['2066','Patricia Castro Gomez','Operador C','Ensamble','SGalvan'],
['2067','Mariana Alferes Montes','Intendencia A','','PAGUILAR'],
['2068','Noemi Guadalupe Rangel ','Operador D','Liberación','AGonzalez'],
['2071','Luis  Segoviano','Tec Mantinimiento D','','JCERVANTES'],
['2073','Cinthya Veronica Galvan','Operador D','Ensamble','SGalvan'],
['2074','Yahir Alejandro Chacon ','Operador C','Ensamble','JZamarripa'],
['2075','Fatima De La Luz Garcia','Operador D','Ensamble','SGalvan'],
['2077','Marcos Enrique Delgado ','Operador D','Liberación','AGonzalez'],
['2079','Jesus Ernesto Castro R','Inspector Calidad','','EVillegas'],
['2080','Francisco Javier Melend','Operador C','Liberación','AGonzalez'],
['2081','Claudia Ivett Gonzalez ','Operador D','Liberación','AGonzalez'],
['2082','Annel Ivonne Castro E','Operador D','Ensamble','SCastro'],
['2085','Maria Guadalupe Valdes ','Operador C','Ensamble','JSanchez'],
['2087','Maria Teresa Jimenez R','Operador D','Liberación','AGonzalez'],
['2089','Silvia Edith Negrete M','Operador D','Ensamble','SCastro'],
['2090','Milagros Jazmin Sanchez','Operador D','Ensamble','JSanchez'],
['2091','Jhoana Jocelyn Lopez J','Tec procesos Calidad','','EMedina'],
['2098','Fernando Moises Barajas','Operador C','Corte','COlvera'],
['2101','Jorge Arturo Garrido M','Ingeniero','','JCERVERA'],
['2106','Luis Adrian Rodriguez A','Operador D','Corte','COlvera'],
['2108','Carmen Patricia Vera C','Operador D','Liberación','AGonzalez'],
['2111','Esteban Marajim Vazquez','Operador D','Corte','COlvera'],
['2112','Karla Jacqueline Martin','Operador D','Liberación','AGonzalez'],
['2113','Martin Baez Aguilar','Seguridad B','','JCERVANTES'],
['2114','Ma  Del Rosario','Operador D','Ensamble','JSanchez'],
['2116','Mario Alberto Delgado C','Seguridad B','','JCERVANTES'],
['2117','Gerardo Calvillo Martin','Seguridad B','','JCERVANTES'],
['2118','Daniela Karen Elizabeth Ojeda Ramirez','Inspector Calidad','','Evillegas'],
['2119','Sofia Sanchez Amezquita','Operador D','Ensamble','SCastro'],
['2120','Ana Ivette Lira Perez','Operador D','Ensamble','JSanchez'],
['2123','Saul Castro Ordaz','Lider Producción','Ensamble','DVillalpando'],
['2125','Fatima Yaireth Suarez Flores','Aux Comercio','','RFANDIÑO'],
['2127','Jonathan Ismael Falcon ','Tec Mantinimiento D','','AGonzalez'],
['2128','Jared Alejandro Moreno ','Tec OP B','','JGUILLEN'],
['2130','Indihra Paulina Martine','Aux Comercio','','RFANDIÑO'],
['2132','Maricruz Alonso Torres','Operador A','Ensamble','SGalvan'],
['2133','Sofia Alonso Torres','Operador D','Liberación','AGonzalez'],
['2134','Cecilia Del Rocio Rangel B','Operador C','Ensamble','JZamarripa'],
['2136','Cassandra Elizabeth Monjaraz Reyna','Operador C','Ensamble','JSanchez'],
['2137','Graciela Lopez Cervera','Operador C','Liberación','AGonzalez'],
['2138','Blanca Esthela Carpio R','Operador C','Ensamble','JZamarripa'],
['2139','Lizbeth Natali Sanchez ','Operador C','Ensamble','SGalvan'],
['2142','Marintia Fernanda Lugo ','Operador D','Liberación','AGonzalez'],
['2144','Nancy Noelia Aldana Rios','Ingeniero','','JCERVERA'],
['2145','Martin Aléman Gutierrez','Coordinador de sist de calidad','','LRAMOS'],
['2146','Javier Santos Cervantes','Supervisor Mantenimiento','','JGUILLEN'],
['2147','Jose de Jesus Cervera Lopez','Sup Ingeniería','','JGUILLEN'],
['2150','Rocio Fandiño','Coordinadora de immex','','JGUILLEN'],
['2152','Francisco  Gomez','Supervisor de embarque','','RFANDIÑO'],
['2153','Angel Gonzalez','Lider de producción','Liberación','JOlaes'],
['2157','Juan  Olaes','Sup de producción','Corte y Liberación','Jguillén'],
['2158','Edwin  Ortega','Contralor financiero','','APotter'],
['2159','Jesus Pereida Ordaz','Ingeniero','','JCERVANTES'],
['2160','Valeria Fernanda Pichardo','Compras','','JGUILLEN'],
['2161','Luis Alberto Ramos Cedeño','Gte Calidad','','GUmhoefer'],
['2162','Miriam Vanessa Reyes Araujo','Ctas por pagar','','EORTEGA'],
['2164','Jose Carlos Rodriguez G','Ingeniero','','JCERVERA'],
['2165','Paola Valeria Silva Vega','Ingeniero','','JCERVERA'],
['2166','Juliet Marlenne Torres ','Enfermera','','PAGUILAR'],
['2167','Mario Enrique Valadez V','Servicio al cliente','','JGUILLEN'],
['2169','David Villalpando Rodriguez','Sup de producción','Ensamble','Jguillén'],
['2170','Ana Paola Aguilar Hernandez','Gte RH','','JSchmit'],
['2171','Robert Melvin Smith','Dir de negocios','','JElliot'],
['2172','Jose Roberto Olivares A','Operador C','Liberación','AGonzalez'],
['2174','Maria De Los Angeles Bañuelos','Analista RH','','PAGUILAR'],
['2175','Juan Jose Guillen Miranda','Gte Operaciones','Operaciones','JElliot'],
['2181','Rodrigo  Ponce A','Practicante','','JCervantes'],
['2177','Juan Antonio ','Operador D','Ensamble','SGalvan'],
['2178','Juan Francisco ','Operador D','Liberación','AGonzalez'],
['2143','Carlos Samuel ','Operador D','Ensamble','JZamarripa'],
['2184','Yair ','Operador D','Corte','COlvera'],
['2183','Jonathan Ismael ','Operador D','Ensamble','SGalvan'],
['2185','Valeria ','Operador D','Ensamble','SGalvan'],
['2186','SanJuana ','Operador D','Ensamble','SGalvan'],
['2187','Sebastian ','Lider Mantenimiento','','JCervantes'],
['2188','Dafne ','Practicante','','VPichardo'],
['2180','Brandon ','Practicante','','JCervera'],
['2182','Christian Alejandro ','Practicante','','JCervera'],
];

const result = personal.filter(fila => {
    return !respo.includes(fila[0]) && !respo.includes(fila[1]);
  });

  const restName = result.map(fila => fila[0] + ' ' + fila[1]);
//console.log(restName);
window.addEventListener('DOMContentLoaded', () => {
    const tablaRes = document.getElementById("tres");

    restName.forEach(name => {
      const row = document.createElement("tr");
      const cell = document.createElement("td");
      cell.textContent = name;
      row.appendChild(cell);
      tablaRes.appendChild(row);
    });
  });



var totalp=[];
var paretoKeys = Object.keys(pareto);
var paretoValues = Object.values(pareto);
var totalParetos =paretoKeys.length;
for (var i = 0; i < totalParetos; i++) {
totalp[i]=97;
}
var keys = Object.keys(datos);
var values = Object.values(datos);
var color=color1 = [];

for (var i = 0; i < keys.length; i++) {
var red = Math.floor(Math.random() * 256);
var blue = Math.floor(Math.random() * 256);
var green = Math.floor(Math.random() * 256);
color.push("rgb(" + red + "," + blue + "," + green + ")");
}
for (var i = 0; i < keys.length; i++) {
var red1 = Math.floor(Math.random() * 256);
var blue1 = Math.floor(Math.random() * 256);
var green1 = Math.floor(Math.random() * 256);
color1.push("rgb(" + red + "," + blue + "," + green + ")");
}

var ctx1 = document.getElementById("BarCali");
var Calibar = new Chart(ctx1, {
type: 'bar',
data: {
    labels: keys,
    datasets: [{
        data:values,
        backgroundColor: color,
        hoverBackgroundColor:color1,
        hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
},
options: {

    maintainAspectRatio: false,
    tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
    },
    legend: {
        display: false
    },
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                min: 0,
                stepSize: 1,
            },
            gridLines: {
                color: '#e3e3e3',
                drawBorder: false,
            },
        }],
        xAxes: [{
            gridLines: {
                display: false,
            },
        }]
    }
},
});


var ctx2 = document.getElementById("pareto");
var calidadPareto = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: paretoKeys,
        datasets: [
            {
                label: 'FTQ',
                data: paretoValues,
                backgroundColor: ['#1cc88a', 'red'],
                hoverBackgroundColor: ['#1cc89a', '#ff1a1a'],
                borderColor: '#1cc88a',
                fill: false, // Evita rellenar el área debajo de la línea
                borderWidth: 4
            },
            {
                label: 'Goal',
                data: totalp,
                borderColor: '#FFCC00',
                borderDash: [5, 5],
                pointRadius: 0,
                fill: false,
                borderWidth: 2
            }
        ]
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    min: 90,
                    max: 100,
                    stepSize: 1,
                },
                gridLines: {
                    color: '#e3e3e3',
                    drawBorder: false,
                },
            }],
            xAxes: [{
                gridLines: {
                    display: false,
                },
            }]
        }
    }
});

//Bar pareto
//console.log(pareto);
var ctx2 = document.getElementById("barPareto");
var calidadPareto = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: pyl,
        datasets: [
            {
                label: 'FTQ',
                data: pyv,
                backgroundColor: ['#1cc88a', 'red','yellow','blue'],
                hoverBackgroundColor: ['#1cc89a', 'red','yellow','blue'],
                borderColor: '#1cc88a',
                fill: false, // Evita rellenar el área debajo de la línea
                borderWidth: 1
            },]
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        responsive: true,
        plugins: {
            legend: {
                display: true, // Mostrar leyendas
                labels: {
                    usePointStyle: true, // Cambiar íconos de las etiquetas a cuadrados
                    pointStyle: 'rect', // Configura los íconos a rectángulos
                    generateLabels: function(chart) {
                        const datasets = chart.data.datasets[0];
                        return chart.data.labels.map((label, index) => ({
                            text: label,
                            fillStyle: datasets.backgroundColor[index], // Color del cuadro
                            strokeStyle: datasets.backgroundColor[index], // Color del borde
                            hidden: false
                        }));
                    }
                }
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    min: 95, // Limitar mínimo
                    max: 100, // Limitar máximo
                    stepSize: .5, // Intervalos de 5 en 5
                },
                gridLines: {
                    color: '#e3e3e3',
                    drawBorder: false,
                },
            }],
            xAxes: [{
                gridLines: {
                    display: false,
                },
            }]
        }
    }
});

// Set default font family and color
Chart.defaults.global.defaultFontFamily = 'Nunito';
//Q as Quality

var ctxQ = document.getElementById("Q");
var myPieChart = new Chart(ctxQ, {
type: 'doughnut',
data: {
labels: labelQ,
datasets: [{
  data: Qdays,
  backgroundColor: colorQ,
 // hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
  hoverBorderColor: "rgba(234, 236, 244, 1)",
}],
},
options: {
maintainAspectRatio: false,
tooltips: {
  backgroundColor: "rgb(255,255,255)",
  bodyFontColor: "#858796",
  borderColor: '#dddfeb',
  borderWidth: 1,
  xPadding: 15,
  yPadding: 15,
  displayColors: false,
  caretPadding: 10,
},
legend: {
  display: false
},
cutoutPercentage: 80,
},

});


var incidencias = [];
var inc = document.getElementById("MonthIncidences");
var incs = new Chart(inc, {
    type: 'bar',
    data: {
        labels: employees,
        datasets: [
            {
                label: 'Incidencias del mes',
                data: empvalues,
                backgroundColor: ['rgba(151, 200, 28, 1)','rgba(171, 200, 28, 1)','rgba(188, 200, 28, 1)','rgba(194, 200, 28, 1)','rgba(200, 154, 28, 1)','rgba(210, 150, 28, 1)','rgba(200, 131, 28, 1)','rgba(200, 117, 28, 1)','rgba(200, 94, 28, 1)','rgba(200, 48, 28, 1)'],

                fill: false, // Evita rellenar el área debajo de la línea
                borderWidth: 4
            },

        ]
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,

        },
        legend: {
            display: true
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    min: 0,
                    max: 30,
                    stepSize: 10,
                },
                gridLines: {
                    color: '#e3e3e3',
                    drawBorder: false,
                },
            }],
            xAxes: [{
                gridLines: {
                    display: false,
                },
            }]
        }
    }
});

window.onload = function() {
    let define_fecha = document.getElementById('fecha').value;
    if (define_fecha == "") {
        define_fecha = new Date().toISOString().substring(0, 10);
    }
    document.getElementById('fecha').value = define_fecha;
    cortes();
    calidad();
   
}
function cortes() {
    try {
        let fecha = document.getElementById('fecha').value;
        let url_cortes = '/eoo/appJointtiemposCompletos?fecha=' + fecha;

        fetch(url_cortes)
        .then(response => response.json())
        .then(data => {
            //console.log("Datos recibidos de todas las máquinas:", data);
          //   document.getElementById('cortes').value = data.totalCortes;
               document.getElementById('oee').innerHTML = data.oee;
        
            const graficaOee = document.getElementById('graficaOee');
    //remove all child nodes
    while (graficaOee.firstChild) {
        graficaOee.removeChild(graficaOee.firstChild);
    }
    // create new canvas
    const newCanvas = document.createElement('canvas');
    newCanvas.id = 'oeeChart';
    newCanvas.style.width = '300px';
    newCanvas.style.height = '300px';
    graficaOee.appendChild(newCanvas);

     let canvas = document.getElementById('oeeChart');
    let define_fecha= document.getElementById('fecha').value;
    let disponibilidad = document.getElementById('disponibilidad').value;

    let rendimiento = document.getElementById('rendimiento').value;
    let calidad = document.getElementById('calidad').value;
    //alert(disponibilidad + " " + rendimiento + " " + calidad);
    //default hoy 
    
    
    if (canvas) {
        let ctx = canvas.getContext('2d');
        
        new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: ['Disponibilidad', 'Rendimiento', 'Calidad'], 
                datasets: [{
                    label: 'Porcentaje %',
                    data: [data.disponibilidad, data.productividad, data.porcentajeCalidad], 
                    backgroundColor: [
                        '#4e73df', // Azul
                         '#1cc88a', // Verde
                        '#e74a3b'  // Rojo
                    ],
                    hoverBackgroundColor: [
                        '#2e59d9', 
                        '#17a673', 
                        '#be2617'
                    ],
                    borderWidth: 1
                    
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top', 
                    }
                }
            }
        });
    }

           
             
    })
    .catch(error => {
        console.error('Error al obtener los cortes:', error);
    });
}catch(e){
    console.log(e); 
};

}
function calidad(){
    let fecha = document.getElementById('fecha').value;
    let url_calidad = '/eoo/appJointtiemposCalidad?fecha=' + fecha;
    fetch(url_calidad)
    .then(response => response.json())
    .then(data => {
     //   console.log("Datos recibidos de todas las máquinas Calidad:", data);
    })
    .catch(error => {
        console.error('Error al obtener los cortes:', error);
    });
}


function cargarGraficas(){
   cortes();
   
  
}
var gann= document.getElementById('myChart1').getContext('2d');
var myChart = new Chart(gann, {
    type: 'bar',
    data: {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        datasets: [
            {
                label: 'Dataset 1',
                data: [[20,30],[40,50],[60,70],[80,90],[100,110],[120,130],[140,150],[160,170],[180,190],[200,210],[220,230],[240,250]],
                borderColor: [
                    'rgba(255, 99, 132, 1)',],
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',],
              },]
    },
    options: {
        responsive: true,


        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                
            }
        }
    }
});

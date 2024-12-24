
    var canvas = document.getElementById('planning');
  //  console.log(dat);

        var ctx = canvas.getContext('2d');

        var data = {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [{
                label: 'PO registradas',
                data: [dat[0],dat[1],dat[2],dat[3],dat[4],dat[5],dat[6],dat[7],dat[8],dat[9],dat[10],dat[11]],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                hoverBackgroundColor: 'rgba(75, 192, 192, 0.4)'
            }]
        };

        var options = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

       var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });




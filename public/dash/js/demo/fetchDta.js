
    // Function to update the data
    function updateData() {
    $.ajax({
        url: fetchDta,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
           // console.log(response);
            // Update table body content with new data
            $('#table-body').html(response.tableContent);
            $('#saldo').html(response.saldo);
            $('#backlock').html(response.backlock);
            //$('#inform').html(response.inform);
            if (response.labels && response.data) {
                // Call function to initialize or update the chart with the retrieved data
                var ctx = document.getElementById("myAreaChart");
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: response.labels,
            datasets: [{
                data: response.data,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
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
        },
    });

        var ctx = document.getElementById("pie");
        var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["Delay", "On Time", "Great Time"],
        datasets: [{
        data: [response.tiemposPass[0], response.tiemposPass[1], response.tiemposPass[2]],
        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
        hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
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

    // Set default font family and color
    Chart.defaults.global.defaultFontFamily = 'Nunito';
    Chart.defaults.global.defaultFontColor = '#858796';


    // Bar Chart Example
    var ctx = document.getElementById("bar");
    var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: response.label,
        datasets: [{
        label: "WO by Area",
        backgroundColor: "rgb(243, 19, 1)",
        data: response.dato,
        }],
    },
    options: {
        maintainAspectRatio: false,
        scales: {
        yAxes: [{

        }]
        },
        tooltips: {
        callbacks: {
            label: function(tooltipItem, chart) {
            return chart.datasets[tooltipItem.datasetIndex].label +" "+  tooltipItem.yLabel.toFixed(0);
            }
        }
        }
    }
    });
    }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Initial call to update data
    updateData();


    setInterval(updateData, 120000);




 // Function to change the area based on the selected action
 function changeArea(action) {
    var areaToChange = document.getElementById('chart-area');

    // Clear existing content
    areaToChange.innerHTML = '';

    // Depending on the selected action, update the area content
    switch (action) {
        case 'lines':
            areaToChange.innerHTML =` <canvas id="myAreaChart" height=40%></canvas>`;
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
            break;
        case 'table':
                areaToChange.innerHTML = `
            <style>
                                    table {     width: 100%;                     }
                                    td {border-bottom: solid 2px lightblue; }
                                    thead{background-color: #FC4747; color:white;  }
                                    a{text-decoration: none; color: whitesmoke;  }
                                    a:hover{ text-decoration: none; color: white; font:bold;}
                                </style>
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <th>Part Number</th>
                                            <th>Revision</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">

                                    </tbody>
                                </table>

            `;
            break;
    }
}

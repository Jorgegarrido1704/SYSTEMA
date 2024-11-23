function changeArea(action) {
        var areaToChange = document.getElementById('chart-area');

        // Clear existing content
        areaToChange.innerHTML = '';

        // Depending on the selected action, update the area content
        switch (action) {
            case 'lines':
                areaToChange.innerHTML =`

        <canvas id="myAreaChart" height=40%></canvas>
    `;
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';



                break;
            case 'table':
                // Default case: Show default table content
                areaToChange.innerHTML = `
                <style>
                                                table {     width: 100%;                     }
                                                td {border-bottom: solid 2px lightblue; }
                                                thead{background-color: #FC4747; color:white;  }
                                                a{text-decoration: none; color: whitesmoke;  }
                                                a:hover{ text-decoration: none; color: white; font:bold;}
                                            </style>
                                            <table id="table-sales" class="table-sales">
                                                <thead>
                                                    <th>Time</th>
                                                    <th>Part Number</th>
                                                    <th>Revision</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                </thead>
                                                <tbody id="table-body"> </tbody>
                                            </table>

                `;
                break;
        }
}

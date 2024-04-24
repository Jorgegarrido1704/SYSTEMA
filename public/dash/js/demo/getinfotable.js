 // Function to update the data
 function updateData() {
    $.ajax({
        url: '{{ route("fetchdata") }}',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            // Update table body content with new data
            $('#table-body').html(response.tableContent);
            $('#saldo').html(response.saldo);
            $('#backlock').html(response.backlock);
            if (response.labels && response.data) {
                // Call function to initialize or update the chart with the retrieved data
                updateChart(response.labels, response.data);
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// Initial call to update data
updateData();

// Set interval to periodically update data
setInterval(updateData, 2000); // 2000 milliseconds = 2 seconds

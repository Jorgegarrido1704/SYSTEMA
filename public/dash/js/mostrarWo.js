// En un archivo JavaScript separado o en la sección <script> en tu Blade

function mostrarWo(workOrder) {
    $.ajax({
        url: routeMostrarWo,
        method: 'GET',
        data: { buscarWo: workOrder },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            $('#table-harness').html(response.tableContent);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

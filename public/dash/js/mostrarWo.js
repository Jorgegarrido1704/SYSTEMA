// En un archivo JavaScript separado o en la sección <script> en tu Blade

function mostrarWo(workOrder) {
    $.ajax({
        url: routeMostrarWo,
        method: 'GET',
        data: { buscarWo: workOrder },
        dataType: 'json',
        success: function(response) {
            ok=response.paretos[0];
            nog=response.paretos[1];
            paretos=response.paretos[2]+ '%';
            $('#table-harness').html(response.tableContent);
            $('#table-retiradas').html(response.tableReg);
            $('#table-ftq').html(response.tableftq);
            $('#tok').html(ok);
            $('#tng').html(nog);
            $('#tftq').html(paretos);
            $('#table-pulltest').html(response.pullTest);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

function submitForm(formId) {
    // Get the form by ID
    var form = document.getElementById('form' + formId);
    var corte = document.getElementById('cortPar' + formId).value;
    console.log(corte);
}


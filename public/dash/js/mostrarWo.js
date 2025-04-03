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
    var plan = document.getElementById('plan' + formId);
    if(plan.checked){
        plan=1;
    }else{
        plan=0;
    }
    var corte = document.getElementById('cortPar' + formId).value;
    var liber = document.getElementById('libePar' + formId).value;
    var ensa = document.getElementById('ensaPar' + formId).value;
    var loom = document.getElementById('loomPar' + formId).value;
    var pre = document.getElementById('preCalidad' + formId).value;
    var cali = document.getElementById('testPar' + formId).value;
    var emba = document.getElementById('embPar' + formId).value;
    var eng = document.getElementById('eng' + formId).value;
    var wo = document.getElementById('wo' + formId).value;
    var datos = {
        plan: plan,
        corte: corte,
        liber: liber,
        ensa: ensa,
        loom: loom,
        pre: pre,
        cali: cali,
        emba: emba,
        eng: eng,
        wo: wo
    };
     // console.log(datos);
    $.ajax({
        type: 'GET',
        url: updateDatos,
        data: { plan: plan,
            corte: corte,
            liber: liber,
            ensa: ensa,
            loom: loom,
            pre: pre,
            cali: cali,
            emba: emba,
            eng: eng,
            wo: wo},
        dataType: 'json',
        success: function(response) {

           // console.log();
            alert('Datos actualizados correctamente');
        },
        error: function(xhr, status, error) {
            console.error('Error al actualizar los datos:', error);
            alert('Hubo un error al actualizar los datos');
        }

    });
}


// En un archivo JavaScript separado o en la sección <script> en tu Blade

function mostrarWo(workOrder) {
    $.ajax({
        url: routeMostrarWo,
        method: "GET",
        data: { buscarWo: workOrder },
        dataType: "json",
        success: function (response) {
            ok = response.paretos[0];
            nog = response.paretos[1];
            paretos = response.paretos[2] + "%";
            $("#table-harness").html(response.tableContent);
            $("#table-retiradas").html(response.tableReg);
            $("#table-ftq").html(response.tableftq);
            $("#tok").html(ok);
            $("#tng").html(nog);
            $("#tftq").html(paretos);
            $("#table-pulltest").html(response.pullTest);
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function submitForm(formId) {
    // Get the form by ID
    var form = document.getElementById("form" + formId);
    var plan = document.getElementById("plan" + formId).value;
    var precut = document.getElementById("precut" + formId).value;
    var tobecut = document.getElementById("tobecut" + formId).value;
    var corte = document.getElementById("cortPar" + formId).value;
    var preterm = document.getElementById("preterm" + formId).value;
    var tobeterm = document.getElementById("tobeterm" + formId).value;
    var liber = document.getElementById("libePar" + formId).value;
    var preassembly = document.getElementById("preassembly" + formId).value;
    var tobeassembly = document.getElementById("tobeassembly" + formId).value;
    var ensa = document.getElementById("ensaPar" + formId).value;
    var preloom = document.getElementById("preloom" + formId).value;
    var tobeloom = document.getElementById("tobeloom" + formId).value;
    var loom = document.getElementById("loomPar" + formId).value;
    var pre = document.getElementById("preCalidad" + formId).value;
    var cali = document.getElementById("testPar" + formId).value;
    var preemba = document.getElementById("preemba" + formId).value;
    var emba = document.getElementById("embPar" + formId).value;
    var eng = document.getElementById("eng" + formId).value;
    var wo = document.getElementById("wo" + formId).value;
    var datos = {
        plan: plan,
        precut: precut,
        tobecut: tobecut,
        corte: corte,
        preterm: preterm,
        tobeterm: tobeterm,
        liber: liber,
        preassembly: preassembly,
        tobeassembly: tobeassembly,
        ensa: ensa,
        preloom: preloom,
        tobeloom: tobeloom,
        loom: loom,
        pre: pre,
        cali: cali,
        preemba: preemba,
        emba: emba,
        eng: eng,
        wo: wo,
    };
    // console.log(datos);
    $.ajax({
        type: "GET",
        url: updateDatos,
        data: {
            plan: plan,
            precut: precut,
            tobecut: tobecut,
            corte: corte,
            preterm: preterm,
            tobeterm: tobeterm,
            liber: liber,
            preassembly: preassembly,
            tobeassembly: tobeassembly,
            ensa: ensa,
            preloom: preloom,
            tobeloom: tobeloom,
            loom: loom,
            pre: pre,
            cali: cali,
            preemba: preemba,
            emba: emba,
            eng: eng,
            wo: wo,
        },
        dataType: "json",
        success: function (response) {
            // console.log();
            alert("Datos actualizados correctamente");
        },
        error: function (xhr, status, error) {
            console.error("Error al actualizar los datos:", error);
            alert("Hubo un error al actualizar los datos");
        },
    });
}

function mostrarQualityIssues(QualityIssues) {
    $.ajax({
        url: routeQualityIssues,
        method: "GET",
        data: { buscarQualityIssues: QualityIssues },
        dataType: "json",
        success: function (response) {
            $("#table-qualityIssues").html(response.tableQualityIssues);
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

function cambiofecha() {
    document.getElementById("fechasQuality").style.display = "none";
    document.getElementById("searchQualityIssues").style.display = "block";
}

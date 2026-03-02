<!DOCTYPE html>
<html>
<head>
    <title>Eliminacion de {{ $acciones->campoEliminado }} </title>
</head>
<body>
    <h2>Eliminacion de {{ $acciones->campoEliminado }} </h2>


    <p><strong>Folio:</strong> {{ $acciones->folioAccion ?? 'N/A' }}</p>
    <p><strong>Se elemino el campo:</strong> {{ $acciones->campoEliminado }}</p>

    <p><strong>EL motivo de la eliminacion fue: </strong> {{ $acciones->motivoEliminacion ?? 'N/A' }}</p>

    <br><br>

    <p>Favor de llenar nuevamente el campo eliminado o contactar al Coordinador de gestion de calidad para alguna aclaracion.</p>
    <p>Gracias.</p>
</body>
</html>


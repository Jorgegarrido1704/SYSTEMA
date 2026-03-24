<!DOCTYPE html>
<html>
<head>
    <title>Acción Correctiva</title>
</head>
<body>
    <h2>Recordatorio "Contestacion de Acción Correctiva"</h2>


    <p><strong>Folio:</strong> {{ $acciones->folioAccion ?? 'N/A' }}</p>
    <p><strong>Descripción de la accion:</strong> {{ $acciones->descripcionAccion ?? 'N/A' }}</p>
    <p><strong>Responsable:</strong> {{ $acciones->resposableAccion ?? 'N/A' }}</p>
    <p><strong>Proceso Afectado:</strong> {{ $acciones->Afecta ?? 'N/A' }}</p>
    <p><strong>Origen de la accion fue detectada en el proceso de: </strong> {{ $acciones->origenAccion ?? 'N/A' }}</p>
    <p><strong>Tu accion se encuentra en el estatus:  {{$acciones->status}} </strong></p>

    <br><br>

    <p>Favor de atender la acción correctiva lo antes posible.</p>
    <p>Gracias.</p>
</body>
</html>


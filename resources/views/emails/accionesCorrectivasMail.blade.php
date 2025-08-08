<!DOCTYPE html>
<html>
<head>
    <title>Acción Correctiva</title>
</head>
<body>
    <h2>Recordatorio de Acción Correctiva</h2>

    <p><strong>Folio:</strong> {{ $acciones->folioAccion ?? 'N/A' }}</p>
    <p><strong>Descripción:</strong> {{ $acciones->accion ?? 'N/A' }}</p>
    <p><strong>Responsable:</strong> {{ $acciones->reponsableAccion ?? 'N/A' }}</p>
    <p><strong>Fecha Límite:</strong> {{ $acciones->fechaFinAccion ?? 'N/A' }}</p>
    <p>Favor de atender la acción correctiva lo antes posible.</p>
</body>
</html>

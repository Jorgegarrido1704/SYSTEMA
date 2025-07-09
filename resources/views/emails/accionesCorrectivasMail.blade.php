<!DOCTYPE html>
<html>
<head>
    <title>Acción Correctiva</title>
</head>
<body>
    <h2>Recordatorio de Acción Correctiva</h2>

    <p><strong>Folio:</strong> {{ $accion->folioAccion ?? 'N/A' }}</p>
    <p><strong>Descripción:</strong> {{ $accion->accion ?? 'N/A' }}</p>
    <p><strong>Responsable:</strong> {{ $accion->reponsableAccion ?? 'N/A' }}</p>
    <p><strong>Fecha Límite:</strong> {{ $accion->fechaFinAccion ?? 'N/A' }}</p>

    <p>Favor de atender la acción correctiva lo antes posible.</p>
</body>
</html>

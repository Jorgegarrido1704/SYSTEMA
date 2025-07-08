<!DOCTYPE html>
<html>
<head>
    <title>Acción Correctiva</title>
</head>
<body>
    <h2>Recordatorio de Acción Correctiva</h2>

    <p><strong>Folio:</strong> {{ $accion->folio ?? 'N/A' }}</p>
    <p><strong>Descripción:</strong> {{ $accion->descripcion ?? 'N/A' }}</p>
    <p><strong>Responsable:</strong> {{ $accion->responsable ?? 'N/A' }}</p>
    <p><strong>Fecha Límite:</strong> {{ $accion->fecha_limite ?? 'N/A' }}</p>

    <p>Favor de atender la acción correctiva lo antes posible.</p>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Planes de accion</title>
</head>
<body>
    <h2>Recordatorio "recoleccion de evidencia planes de accion"</h2>


    <p><strong>Folio:</strong> {{ $acciones->id ?? 'N/A' }}</p>
    <p><strong>Accion Correctiva:</strong> {{ $acciones->folioAccion ?? 'N/A' }}</p>
    <p><strong>Descripción del plan de accion:</strong> {{ $acciones->descripcionSubAccion ?? 'N/A' }}</p>
    <p><strong>Responsable:</strong> {{ $acciones->resposableSubAccion ?? 'N/A' }}</p>
    <p><strong>Fecha limite asisgnada por usted para la recoleccion de evidencia:</strong> {{ $acciones->fechaFinSubAccion ?? 'N/A' }}</p>
   
    <br><br>

    <p>Favor tener la evidencia necesario para el plan de accion.</p>

    <p>Gracias.</p>
</body>
</html>


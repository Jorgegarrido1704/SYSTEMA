<!DOCTYPE html>
<html>
<head>
    <title>Acción Correctiva</title>
</head>
<body>
    <h2>Levantamiento de Acción Correctiva</h2>

    <p><strong>Folio:</strong> {{ $acciones->folioAccion ?? 'N/A' }}</p>
    <p><strong>Descripción de la accion:</strong> {{ $acciones->descripcionAccion ?? 'N/A' }}</p>
    <p><strong>Responsable:</strong> {{ $acciones->resposableAccion ?? 'N/A' }}</p>
    <p><strong>Esta accion fue creada el:</strong> {{ $acciones->fechaAccion ?? 'N/A' }} <strong>y se tiene un plazo de 48 horas para realizar la descripcion de la contencion de la accion</strong></p>
   <p><strong>Fecha limite para la descripcion de la contencion:</strong> {{ \Carbon\Carbon::parse($acciones->fechaAccion)->addWeekDays(2)->format('Y-m-d') }}</p>
    <p><strong>Proceso Afectado:</strong> {{ $acciones->Afecta ?? 'N/A' }}</p>
    <p><strong>Origen de la accion fue detectada en el proceso de: </strong> {{ $acciones->origenAccion ?? 'N/A' }}</p>

    <br><br>

    <p>Favor de atender la acción correctiva lo antes posible.</p>
    <p>Gracias.</p>
</body>
</html>

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
    <p><strong>Esta accion fue creada el:</strong> {{ \Carbon\Carbon::parse($acciones->fechaAccion)->format('d-m-Y').' a las '.\Carbon\Carbon::now()->format('H:i')." " }} <strong>y se tiene un plazo de 48 horas habiles apartir de la recepcion de este correo</strong></p>
    <p><strong>Proceso Afectado:</strong> {{ $acciones->Afecta ?? 'N/A' }}</p>
    <p><strong>Origen de la accion fue detectada en el proceso de: </strong> {{ $acciones->origenAccion ?? 'N/A' }}</p>

    <br><br>

    <p>Favor de atender la acción correctiva lo antes posible.</p>
    <p>Gracias.</p>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Acción Correctiva</title>
</head>
<body>
    <h2>Medicion de la eficiencia de la accion correctiva</h2>


    <p><strong>Folio:</strong> {{ $acciones->folioAccion ?? 'N/A' }}</p>
    <p><strong>Descripción de la accion:</strong> {{ $acciones->descripcionAccion ?? 'N/A' }}</p>
    <p><strong>Responsable:</strong> {{ $acciones->resposableAccion ?? 'N/A' }}</p>
    <p><strong>Proceso Afectado:</strong> {{ $acciones->Afecta ?? 'N/A' }}</p>
    <p><strong>Origen de la accion fue detectada en el proceso de: </strong> {{ $acciones->origenAccion ?? 'N/A' }}</p>
    <br>
    <p><strong>El responsable agrego la medicion de la eficacia de la accion correctiva el dia de hoy, con la descripcion de la medicion de la eficacia de la accion:</strong>{{ $acciones->accion ?? 'N/A' }}</p>
    <p><strong>Con fecha compromiso para la medicion de la eficacia de la accion correctiva el dia: </strong> {{ $acciones->fechaInicioAccion ?? 'N/A' }}</p>
    <br><br>

    <p>Favor de solicitar al coordinador de gestion de calidad la aprobacion de la medicion de la eficacia de la accion correctiva. y cumplir con la fecha compromiso.</p>
    <br>
    <p>Gracias.</p>
</body>
</html>


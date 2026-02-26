<!DOCTYPE html>
<html>
<head>
    <title>Acción Correctiva</title>
</head>
<body>
    <h2>Descripción de contencion para la accion correctiva</h2>

    <p><strong>Folio:</strong> {{ $acciones->folioAccion ?? 'N/A' }}</p>
    <p><strong>Descripción de la accion:</strong> {{ $acciones->descripcionAccion ?? 'N/A' }}</p>
    <p><strong>Responsable:</strong> {{ $acciones->resposableAccion ?? 'N/A' }}</p>
    <p><strong>El responsable agrego la contencion de la accion correctiva el dia de hoy, con la descripcion de la contencion de la accion:</strong>{{ $acciones->descripcionContencion ?? 'N/A' }}</p>
        <p><strong>Tambien se asigno la fecha compromiso para el cierre de la accion correctiva:</strong> {{ $acciones->fechaCompromiso ?? 'N/A' }}</p>

    <br><br>

    <p>Favor de continuar el proceso siguiente.</p>
    <p>Gracias.</p>
</body>
</html>

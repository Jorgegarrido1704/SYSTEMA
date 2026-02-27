<!DOCTYPE html>
<html>
<head>
    <title>Acción Correctiva</title>
</head>
<body>
    <h2>Registro de 5 porques en accion correctiva</h2>

    <p><strong>Folio:</strong> {{ $acciones->folioAccion ?? 'N/A' }}</p>
    <p><strong>Descripción de la accion:</strong> {{ $acciones->descripcionAccion ?? 'N/A' }}</p>
    <p><strong>Responsable:</strong> {{ $acciones->resposableAccion ?? 'N/A' }}</p>
    <p><strong>El responsable agrego la contencion de la accion correctiva el dia de hoy, con la descripcion de la contencion de la accion:</strong>{{ $acciones->descripcionContencion ?? 'N/A' }}</p>
    <p><strong>Se registraron los 5 porques:</strong> {{ $acciones->porques ?? 'N/A' }}</p>
    <table>
        <thead>
            <tr>
                <th>Porqué 1</th>
                <th>Porqué 2</th>
                <th>Porqué 3</th>
                <th>Porqué 4</th>
                <th>Porqué 5</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $acciones->porque1 ?? 'N/A' }}</td>
                <td>{{ $acciones->porque2 ?? 'N/A' }}</td>
                <td>{{ $acciones->porque3 ?? 'N/A' }}</td>
                <td>{{ $acciones->porque4 ?? 'N/A' }}</td>
                <td>{{ $acciones->porque5 ?? 'N/A' }}</td>
            </tr>
        </tbody>
    <p><strong>Tambien se asigno la fecha compromiso para el cierre de la accion correctiva:</strong> {{ $acciones->fechaCompromiso ?? 'N/A' }}</p>

    <br><br>

    <p>Favor de continuar el proceso siguiente.</p>
    <p>Gracias.</p>
</body>
</html>

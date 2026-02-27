<!DOCTYPE html>
<html>
<head>
    <title>Solicitud de Material pruebas electricas</title>
</head>
<body>
    <h2>Solicitud de Material pruebas electricas</h2>

    <p><strong>Folio de solicitud:</strong> {{ $material->id  }}</p>
    <p><strong>Este material es para el numero de parte </strong> {{ $material->pn }} REV {{ $material->rev }}
    para el cliente {{ $material->customer }}</p>
    <p><strong>Prioridad:</strong> {{ $material->priority }}</p>

    <p><strong>Material solicidado:</strong> 
        @if($material->connector =='N/A')  
        <p><strong>Terminal:</strong> {{ $material->terminal}} <strong> por la cantidad de:</strong> {{ $material->terminalQty }} </p>
        @else
        <p><strong>Conector:</strong> {{ $material->connector}} <strong> por la cantidad de:</strong> {{ $material->connectorQty }} </p>
        @endif
       <p><strong>Observaciones:</strong> {{ $material->observaciones }}</p>
    <br><br>

    <p>Favor de darle seguimiento a esta solicitud en el CVTS</p>
    <p>Gracias.</p>
</body>
</html>

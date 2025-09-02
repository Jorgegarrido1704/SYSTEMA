<!DOCTYPE html>
<html>
<head>
    <title>Solicitud de Vacaciones </title>
</head>
<body>
    <p> {{ $contend['asunto'] }}</p><br><br>
    <p> Folio:{{$contend['Folio']}} </p>
    <p> Fecha de Solicitud:{{$contend['fecha_de_solicitud']}} </p>
    <p> Dias Solicitados:{{$contend['dias_solicitados']}}
    <p> Empleado:{{$contend['nombre']}} </p>
    <p> Departamento:{{$contend['departamento']}} </p>
    <p> Supervisor:{{$contend['supervisor']}} </p>
        <button class="btn btn-primary"><a href="{{ $contend['link'] }}" target="_blank"></a></button>
    <p>Favor de revisar la solicitud en el CVTS </p>



 <br><br><p> De antemano Agradezco su atencion<br>ATTE: J.G.</p><br>
</body>
</html>

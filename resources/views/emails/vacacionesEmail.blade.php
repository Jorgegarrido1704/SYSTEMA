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
        <button style="background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;"><a href="{{ $contend['link'] }}" >
           Revisar Solicitud</a></button>
    <br><br>
    <p>Favor de revisar la solicitud en el CVTS </p>



 <br><br><p> De antemano Agradezco su atencion<br>ATTE: J.G.</p><br>
</body>
</html>

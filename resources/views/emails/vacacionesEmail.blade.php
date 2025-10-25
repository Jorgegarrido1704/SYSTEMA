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

   <!-- <p>
        <a href="$contend['link'] }}" target="_blank"
           style="display:inline-block;
                  padding:10px 20px;
                  background-color:#007bff;
                  color:#ffffff;
                  text-decoration:none;
                  border-radius:5px;
                  font-weight:bold;">
            Revisar Solicitud
        </a>
    </p>-->

    <br><br>
    <p>Favor de revisar la solicitud en el CVTS </p>



 <br><br><p> De antemano Agradezco su atencion<br>ATTE: J.G.</p><br>
</body>
</html>

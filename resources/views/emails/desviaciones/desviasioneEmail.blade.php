<!DOCTYPE html>
<html>
<head>
    <title>Alta desviacion</title>
</head>
<body>

    <p> Se registro una nueva desviacion por: {{$accion->quien}} con las siguineres caracteristicas: </p>
     <p> Con el folio de la desviacion: {{$accion->id}}</p>
    <p> Cliente: {{$accion->cliente}}</p>
    <p> Numero de parte: {{$accion->Mafec}}</p>
    <p>  Work Order: {{$accion->wo}}</p>
    <p> Parte Original: {{ $accion->porg}}</p>
     <p> Parte Sustituto: {{$accion->psus}}</p>
    <p> Cantidad: {{$accion->clsus}}</p>
    <p> Periodo de Desviación: {{$accion->peridoDesv}}</p>
    <p> Causa: {{$accion->Causa}}</p>
    <p> Accion preventiva: {{$accion->accion}}</p>
    <p> Evidencia: {{$accion->evidencia}}</p>

    <p> Recuerda que al autorizar esta desviaciones debe ingresar al CVTS para realizar su firma digital<br>
        Al firmar esta solicitud usted aprueba el cambio para el tiempo y la cantidad en la respectiva WO.</p><br>


 <br><br><p> De antemano Agradezco su atencion<br>ATTE: J.G.</p><br>
</body>
</html>

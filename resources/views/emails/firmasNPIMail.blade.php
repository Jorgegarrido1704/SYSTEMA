<!DOCTYPE html>
<html>
<head>
    <title>Fimar NPI</title>
</head>
<body>
    <p> Se registro un nuevo producto</p><br><br>
 <p> Tipo DE cambio: {{ $accion->tp }} </p><br>
 <p> Cliente: {{ $accion->client }}</p><br>
 <p> Número de parte:{{$accion->pn}}</p><br>
 <p>El tipo de producto es: {{$accion->tipo}}</p><br>
 @if($accion->tp=='NUEVA PPAP (Hoja Verde)')
   <p> Con la revision: {{$accion->REV1}}</p><br>
@elseif($accion->tp=='Cambio REV PrimeraPieza (Hoja Amarilla)' or $accion->tp =='NO PPAP')
    <p> Cambio de la revision: {{$accion->REV1}} a la revision: '{{$accion->REV2}} </p><br>
@endif
 <p> Dado de alta por: {{ $accion->eng }}</p><br>
 <p> Con la descripción : {{$accion->cambios}}</p><br>
 <br><p> Al Firmar esta solicitud usted acepta el proceso de trabajo que
involucra a su departamento en este proceso.</p><br>
<br> <p><b>Ingrese al CVTS para realizar su firma digital</b></p><br>

 <br><br><p> De antemano Agradezco su atencion<br>ATTE: J.G.</p><br>
</body>
</html>

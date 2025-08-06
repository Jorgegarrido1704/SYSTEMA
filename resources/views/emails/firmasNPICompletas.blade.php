<!DOCTYPE html>
<html>
<head>
    <title>Firmas Completas NPI</title>
</head>
<body>
    <p> Se registraron las firmas completas </p><br><br>
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
 

 <br><br><p> De antemano Agradezco su atencion<br>ATTE: J.G.</p><br>
</body>
</html>

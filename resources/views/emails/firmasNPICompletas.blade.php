<!DOCTYPE html>
<html>
<head>
    <title>Firmas Completas NPI</title>
</head>
<body>
    <p><strong>Se registraron las firmas completas</strong></p><br><br>
 <p><strong>Tipo DE cambio: {{ $accion->tp }} </strong></p><br>
 <p><strong>Cliente: {{ $accion->client }}</strong></p><br>
 <p> <strong>Número de parte:  {{$accion->pn}}</strong></p><br>
 <p> <strong>El tipo de producto es: {{$accion->tipo}}</strong></p><br>
 @if($accion->tp=='NUEVA PPAP (Hoja Verde)')
   <p> <strong>Con la revision: {{$accion->REV1}}</strong></p><br>
@elseif($accion->tp=='Cambio REV PrimeraPieza (Hoja Amarilla)' or $accion->tp =='NO PPAP')
    <p> <strong>Cambio de la revision: {{$accion->REV1}} a la revision: '{{$accion->REV2}}</strong> </p><br>
@endif
 <p> <strong>Dado de alta por: {{ $accion->eng }}</strong></p><br>
 <p> <strong>Con la descripción : {{$accion->cambios}}</strong></p><br>


 <br><p><strong> De antemano Agradezco su atencion</strong><br>ATTE: J.G.</p><br>
</body>
</html>

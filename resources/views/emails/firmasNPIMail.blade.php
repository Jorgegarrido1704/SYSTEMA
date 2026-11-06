<!DOCTYPE html>
<html>
<head>
    <title>Fimar NPI</title>
</head>
<body>
    <p><strong>Buen día,<br><br> se registro un nuevo producto con la siguiente información:</strong></p>
 <p><strong> Tipo DE cambio: {{ $accion->tp }} <br>
  Cliente: {{ $accion->client }}<br>
  Número de parte:{{$accion->pn}}<br>
 El tipo de producto es: {{$accion->tipo}}<br>
 @if($accion->tp=='NUEVA PPAP (Hoja Verde)')
    Con la revision: {{$accion->REV1}}<br>
@elseif($accion->tp=='Cambio REV PrimeraPieza (Hoja Amarilla)' or $accion->tp =='NO PPAP')
     Cambio de la revision: {{$accion->REV1}} a la revision: '{{$accion->REV2}}<br>
@endif
  Dado de alta por: {{ $accion->eng }}<br>
  Con la descripción : {{$accion->cambios}}<br></strong></p><br>
 <p> <strong>Al Firmar esta solicitud usted acepta el proceso de trabajo que
involucra a su departamento en este proceso.<br></strong>
<br> <b>Ingrese al CVTS para realizar su firma digital </b></p><br>

 <p> <strong>De antemano Agradezco su atencion</strong><br>ATTE: J.G.</p><br>
</body>
</html>

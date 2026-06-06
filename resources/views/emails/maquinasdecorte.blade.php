<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Paro de máquina de corte</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto; padding: 20px;">
    
    <h2 style="color: #d9534f;"> Alerta de Inactividad</h2>
    <p>Se ha detectado que una máquina de corte ha superado el tiempo límite de 30 minutos sin registrar actividad.</p>
    
    <div style="background-color: #f8f9fa; border-left: 4px solid #d9534f; padding: 15px; margin: 20px 0;">
        <p style="margin: 5px 0;"><strong>Máquina:</strong> {{ $accion->maquina }}</p>
        <p style="margin: 5px 0;"><strong>Último folio de registro:</strong> {{ $accion->id }}</p>
        <p style="margin: 5px 0;"><strong>Fecha/Hora última lectura:</strong> {{ $accion->fecha }}</p>
    </div>

    <p style="margin-top: 30px;">De antemano agradezco su atención.<br>
    <strong>ATTE:</strong> J.G.</p>
</body>
</html>
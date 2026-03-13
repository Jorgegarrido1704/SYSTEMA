<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
</head>
<body>
    <div>
        <p>Buen día,</p>

        <p>Les comparto que hoy {{$content['dia'] }}, a las {{ $content['hora'] }} se libero a piso la siguiente {{$content['tipo']}}: </p>
        <p>Cliente: {{ $content['client'] }}</p>
        <p>Numero de parte: {{ $content['np'] }} REV {{ $content['rev'] }}</p>
        <p>Work Order: {{ $content['wo'] }}</p>
        <p>Por la cantidad de: {{ $content['qty'] }} </p>
        <p>Esto para seguir con el proceso de producción y revision por parte de ingeniería y calidad, asi como el apoyo de todos los departamentos involucrados.</p>
        <h3 style="color:red"> Este arnes debe entregarce al cliente antes del {{ $content['reqDay'] }}</h2>
        <p>De antemano Agradezco su atencion<br>ATTE: J.G.</p><br>

    </div>
</body>
</html>

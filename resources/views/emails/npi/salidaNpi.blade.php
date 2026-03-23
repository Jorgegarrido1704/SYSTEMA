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
        <p> {{$content['info']}} </p>
        <p>Cliente: {{ $content['client'] }}</p>
        <p>Numero de parte: {{ $content['np'] }} REV {{ $content['rev'] }}</p>
        <p>Work Order: {{ $content['wo'] }}</p>
        <p>Por la cantidad de: {{ $content['qty'] }} </p>
        <p>se agradece su colaboración con el proceso de producción y revision por parte de ingeniería y calidad, asi como el apoyo de todos los departamentos involucrados.</p>
        <h3 style="color:red"> Este arnes debio entregarce al cliente antes del {{ $content['reqDay'] }}</h3>
        <p>De antemano Agradezco su atencion<br>ATTE: J.G.</p><br>

    </div>
</body>
</html>

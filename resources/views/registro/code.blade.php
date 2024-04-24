<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if (!empty($cat) && $cat=='plan')
    <meta http-equiv="refresh" content="5; url={{route('planning')}}">
    @else
    <meta http-equiv="refresh" content="5; url={{route('label')}}">
    @endif


    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <title>Print barcode</title>

</head>
<body>

    <div align="center">
        <canvas id="barcode" style="padding-top:40px; width:350px; max-height:90px;"></canvas>
        <div>



<script>
var codigos = {!! json_encode($codes) !!};

var canvas = document.getElementById("barcode");
        var ctx = canvas.getContext("2d");

        JsBarcode(canvas, codigos, {
            format: "CODE128",
            displayValue: true,
            fontSize: 12,
            textMargin: 0
        });



      window.onload = function() {
            window.print();
        };
</script>
</body>
</html>

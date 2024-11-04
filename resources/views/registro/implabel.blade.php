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
    <title>Print labels</title>

</head>
<body>
    @if (!empty($corte))
@for ($i=0; $i < count($corte); $i++)
<div style="display: flex; width: 100mm; height: 50mm;" >
        <!-- <canvas id="etiqueta{{$i}}" || style=" margin-top: 15mm; height: 8mm; "></canvas>-->
        <canvas id="barcode{{$i}}" || style=" margin-top: 15mm; height: 8mm; width: 150%;transform: rotate(90deg); "></canvas>
<div>
        <img src="{{ asset('/dash/img/bergs.jpg')}}" alt="" style="width: 80px; max-height: 20px;"><b> Cons: {{$corte[$i][3]}}
            <h5>{{$corte[$i][0]}} Cant: {{$corte[$i][12]}} WO: {{$corte[$i][2]}} AWG: {{$corte[$i][6]}}
                TIPO: {{$corte[$i][5]}} PN: {{$corte[$i][1]}} Color: {{$corte[$i][4]}} Tamaño: {{$corte[$i][13]}}
                Term1: {{$corte[$i][8]}} Term2: {{$corte[$i][9]}} From: {{$corte[$i][10]}} TO: {{$corte[$i][11]}}
                Estampado:  {{$corte[$i][14]}}
            <canvas id="bcode{{$i}}" style="height: 7mm; width: 80%;"></canvas>

            </h5>
        </div>
    </div>
    <script>

        (function() {
            var canvas = document.getElementById("barcode{{$i}}");
            var codigos = "{{$corte[$i][7]}}";
            JsBarcode(canvas, codigos, {
                format: "CODE128",
                displayValue: true,
                fontSize: 12,
                textMargin: 0
            });

            var canvas1 = document.getElementById("bcode{{$i}}");
            var codigos1 = "{{$corte[$i][14]}}";
            JsBarcode(canvas1, codigos1, {
                format: "CODE128",
                displayValue: true,
                fontSize: 12,
                textMargin: 0
            });
        })();
    </script>
@endfor

    @endif
    @if (!empty($labelwo))
    @for($labelbeg;$labelbeg<=$labelend;$labelbeg++)
    <div align='center' style="padding-top:5px"><img src='{{ asset('/dash/img/bergs.jpg')}}' alt=''> <br></div>
    <div align='center' style='padding-top:1px;'><b>{{$cliente}} Wo: {{$labelwo}} Rev: {{$rev}}<br> Part: {{$pn}} Qty: {{$qty}} Cons: {{$labelbeg}}</b><br></div>
    @endfor
    @endif
</body>
</html>
<script>
    window.onload = function() {
     window.print();
 };
</script>

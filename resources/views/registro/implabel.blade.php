<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Labels 104x54</title>

    <!-- Redirección lógica -->
    @if (!empty($cat) && $cat=='plan')
        <meta http-equiv="refresh" content="5; url={{route('planning')}}">
    @else
        <meta http-equiv="refresh" content="5; url={{route('label')}}">
    @endif

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>

    <style>
        /* Configuración de página para etiquetas */
        @page {
            size: 100mm 50mm;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            font-size: 9pt;
            background-color: white;
        }

        /* Salto de página para cada etiqueta */
        .label-container {
            width: 100mm;
            height: 50mm;
            box-sizing: border-box;
            padding: 1mm;
            display: flex; /* Dividimos en Izquierda (Barcode) y Derecha (Info) */
            overflow: hidden;
            page-break-after: always;
            border: 0.1mm solid #eee; /* Solo para visualización, se puede quitar */
        }

        /* Contenedor del código de barras vertical */
        .barcode-side {
            width: 25mm;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .barcode-vertical {
            transform: rotate(-90deg); /* Rotado para optimizar altura */
            transform-origin: center;
        }

        /* Contenedor de la información */
        .info-side {
            flex: 1;
            padding-left: 2mm;
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #000;
            margin-bottom: 2px;
            padding-bottom: 2px;
        }

        .logo {
            width: 60px;
            height: auto;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr ;
            gap: 1px;
            line-height: 1.1;
        }

        .full-width {
            grid-column: span 2;
        }

        .label-bold {
            font-weight: bold;
            text-transform: uppercase;
        }

        .footer-barcode {
            margin-top: auto;
            text-align: center;
        }

        #bcode-canvas {
            max-width: 100%;
            height: 7mm;
        }
    </style>
</head>
<body>

@if (!empty($corte))
    @for ($i=0; $i < count($corte); $i++)
    <div class="label-container">
        <!-- BARRA LATERAL (Barcode Principal) -->
        <div class="barcode-side" style="transform: rotate(90deg);">
            <svg id="barcode{{$i}}" class="barcode-vertical"></svg>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="info-side">
            <div class="header">
                <img src="{{ asset('/dash/img/bergs.jpg')}}" class="logo" alt="Logo">
                <span><b>Cons:</b> {{$corte[$i][3]}}</span>
            </div>

            <div class="content-grid">
                <div class="full-width"><span class="label-bold">Customer:</span> {{$corte[$i][0]}}</div>
                <div><span class="label-bold">Qty:</span> {{$corte[$i][12]}}</div>
                <div><span class="label-bold">WO:</span> {{$corte[$i][2]}}</div>
                <div><span class="label-bold">AWG:</span> {{$corte[$i][6]}}</div>
                <div><span class="label-bold">Tipo:</span> {{$corte[$i][5]}}</div>
                <div><span class="label-bold">PN:</span> {{$corte[$i][1]}}</div>
                <div><span class="label-bold">Rev:</span> {{$corte[$i][15]}}</div>
                <div><span class="label-bold">Color:</span> {{$corte[$i][4]}}</div>

                <div class="full-width" style="font-size: 8pt; margin-top: 2px;">
                    <b>T1:</b> {{$corte[$i][8]}} | <b>T2:</b> {{$corte[$i][9]}}<br>
                    <b>F:</b> {{$corte[$i][10]}} <b>T:</b> {{$corte[$i][11]}}
                </div>
            </div>

            <div class="footer-barcode">
                <svg id="bcode{{$i}}"></svg>
                <div style="font-size: 5pt;">Estampado: {{$corte[$i][14]}}</div>
            </div>
        </div>
    </div>

    <script>
        // Generar Barcode Lateral (Vertical)
        JsBarcode("#barcode{{$i}}", "{{$corte[$i][7]}}", {
            format: "CODE128",
            width: 1.5,
            height: 20,
            displayValue: true,
            fontSize: 10
        });

        // Generar Barcode Inferior (Horizontal)
        JsBarcode("#bcode{{$i}}", "{{$corte[$i][14]}}", {
            format: "CODE128",
            width: 1.2,
            height: 20,
            displayValue: false
        });
    </script>
    @endfor
@endif

<script>
    window.onload = function() {
        // Un pequeño delay ayuda a que los códigos de barras se rendericen antes de abrir el diálogo
        setTimeout(function() {
            window.print();
        }, 500);
    };
</script>
</body>
</html>

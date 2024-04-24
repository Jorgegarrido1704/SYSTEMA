@extends('layouts.main')

@section('contenido')
<style>
    .form-container {
        display: flex;
        gap: 20px;
    }

    .form-container form {
        width: 50%; /* Each form takes 50% of the container width */
    }

    .form-container form div {
        margin-bottom: 15px;
    }

    .form-container form label {
        display: block;
        margin-bottom: 5px;
    }

    .form-container form input {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    @media screen and (max-width: 768px) {
        .form-container {
            flex-direction: column; /* Stack forms on smaller screens */
        }

        .form-container form {
            width: 100%; /* Each form takes full width on smaller screens */
        }
    }
</style>
@if (!empty($resp))
<script>
    alert({{$resp}});
</script>
@endif
<div class="form-container">
    <form action="{{route('code')}}" method="GET">
        <div>
            <label for="wo">WO For Barcode</label>
            <input type="text" name="wo" id="wo" required >
        </div>

        <input type="submit" name="enviar" id="enviar" value="Imprimir">
    </form>

    <form action="{{route('implabel')}}" method="GET">
        <div>
            <label for="tren1">Wo For lables</label>
            @if (!empty($labels))
            <input type="text" name="wola" id="wola" value={{$labels}} required >
            @else
            <input type="text" name="wola" id="wola" required >
            @endif
        </div>
        <div>
            <label for="tren2">Begin label</label>
            <input type="number" name="label1" id="label1" value='1' required>
        </div>
        <div>
            <label for="tren1">end label</label>
            <input type="number" name="label2" id="label2" required autofocus>
        </div>


        <input type="submit" name="enviar" id="enviar" value="Imprimir">
    </form>
</div>

@endsection

@extends('layouts.main')
@section('contenido')
    <style>
    body{   @media screen and (max-width: 768px) {
            font-size: 12px;
            text-align: center;
            align-items: center;
            margin-bottom: 5px;
            display: block;
        } }
    table { width: 100%;  text-align: center;  }
     input[type="number"] { width: 120px; text-align: center; border-radius: 15px; }
     input[type="submit"] { width: 120px; text-align: center; border-radius: 15px; background-color: blue; color: white; }
    #volver { width: 120px; text-align: center; border-radius: 15px; background-color: blue; color: white; }
    </style>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><h1>Numero de parte</h1></th>
                    <th><h1>Wo</h1></th>
                    <th><h1>Item</h1></th>
                    <th><h1>Cantidad en kit</h1></th>
                    <th><h1>Cantidad de retorno</h1></th>
                </tr>
            </thead>
            <tbody>
            @if (!empty($table))
            <form action="{{route('entradas')}}" method="GET">
                @csrf
                @foreach ($table as $tab )
                    <tr>
                        <td>{{$tab[0]}}</td>
                        <td>{{$tab[1]}}</td>
                        <td>{{$tab[2]}}</td>
                        <td>{{$tab[3]}}</td>
                        <td><input type="number" name="cant[]" id="cant" value="0"  max="{{$tab[3]}}" min="0" required></td>
                        <input type="hidden" name="id_return[]" id="id_return" value="{{$tab[4]}}" >
                    </tr>
                @endforeach
            </tbody>
        </table>
                <input type="submit" name="save" id="save" value="Guardar">
            </form>
            @endif
    </div>
@endsection

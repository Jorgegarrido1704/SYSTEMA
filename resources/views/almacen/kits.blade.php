@extends('layouts.mainWithoutsidebar')
@section('contenido')
<style>
    body{
        @media screen and (max-width: 768px) {
            font-size: 12px;
            text-align: center;
            align-items: center;
            margin-bottom: 5px;
            display: block;
        }
    }
    table {     width: 100%;    text-align: center;  }
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
                    <th><h1>Cantidad</h1></th>
                </tr>
            </thead>
            <tbody>
                <form action="{{ route('trabajoKits')}}" method="POST">
                @csrf
                @if(!empty($kits))
                @foreach ($kits as $kit)
                <tr>
                    <td><input type="hidden" name="np" id="np" value="{{ $kit[0] }}">{{ $kit[0] }}</td>
                    <td><input type="hidden" name="wo" id="wo" value="{{ $kit[1] }}">{{ $kit[1] }}</td>
                    <td><input type="hidden" name="item[]" id="item" value="{{ $kit[2] }}">{{ $kit[2] }}</td>
                    <td><input type="number" name="qty[]" value="{{ $kit[3] }}" step="0.01" id="qty"></td>
                </tr>
                @endforeach
                @endif
                <tr><td></td><td></td><td><input type="submit" name="guardar" id="guardar" value="Guardar"></td></tr>
            </form>
            </tbody>
        </table>
        <button id="volver"><a id="volver" href="{{url('/inventario')}}">Regresar</a></button>
    </div>
@endsection
